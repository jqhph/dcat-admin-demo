<?php

namespace Dcat\Page\Console;

use Dcat\Page\DcatPage;
use function DcatPage\markdown;
use function DcatPage\path;
use function DcatPage\slug;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Finder\SplFileInfo;

class IndexCommand extends Command
{
    use DcatApp;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dcatpage:index {name?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Index all documentation.';

    /**
     * @var Filesystem
     */
    protected $files;

    /**
     * @var array
     */
    protected $dirs = DcatPage::NAME;

    /**
     * @var array
     */
    protected $tags = ['h2', 'h3', 'h4'];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->getAppName();

        if ($name && !$this->exist($name)) {
            return $this->error("[$name] not found!");
        }

        $this->files = app('files');

        if (!$name) {
            $name = DcatPage::getAllAppNames();
        }

        foreach ((array) $name as $app) {
            $this->generate($app);
        }
    }

    /**
     * 生成json格式文档.
     *
     * @param $name
     */
    protected function generate($name)
    {
        DcatPage::init($name, true);

        $docBasePath = str_replace('\\', '/', path('docs'));

        collect($this->files->directories($docBasePath))->map(function ($dir) use ($name) {
            $version = basename($dir);

            $nodes = $this->generateIndices($dir, $name, $version);

            $base = 'public/assets/indices/'.$version.'.js';
            $path = path($base);

            $this->putContent($path, $this->formatIndices($nodes));

            $this->info("[{$name} --- {$base}] created successfully.");
        });
    }

    /**
     * 生成索引节点.
     *
     * @param $path
     * @param $name
     * @param $version
     *
     * @return array
     */
    protected function generateIndices($path, $name, $version)
    {
        $values = [];

        collect($this->files->allFiles($path, true))->each(function (SplFileInfo $fileInfo) use (&$values, $name, $version) {
            if ($this->shouldSkip(basename($fileInfo->getRealPath()))) {
                return;
            }

            try {
                $content = $this->getDocContent($fileInfo->getRealPath());

                $crawler = new Crawler(markdown($content));

                // 获取总标题下的内容
                $node = $this->filterTopContent($crawler);

                // 获取所有下级内容
                $nodes = $this->filterWithTag($crawler, $this->tags);
                $nodes = $this->unique($nodes, 'name');

                $node && array_unshift($nodes, $node);

                $link = str_replace('.md', '', slug(basename($fileInfo->getRealPath())));

                $title = $crawler->count() ? $crawler->filterXPath('//h1')->text() : null;
            } catch (\Exception $e) {
            }

            if (!empty($title) || !empty($nodes)) {
                $values[] = [
                    'title' => $title ?? null,
                    'link'  => $link ?? null,
                    'nodes' => $nodes ?? [],
                ];
            }
        });

        return array_filter($values);
    }

    /**
     * 获取总标题下的内容.
     *
     * @param Crawler $crawler
     *
     * @return array
     */
    protected function filterTopContent(Crawler $crawler)
    {
        $end = false;

        try {
            $values = $crawler->children()->first()->children()->each(function (Crawler $node) use (&$end) {
                if ($node->nodeName() == 'h1' || !$node->count()) {
                    return;
                }
                if ($end || in_array($node->nodeName(), $this->tags)) {
                    $end = true;

                    return;
                }

                return $node->text();
            });
        } catch (\Exception $e) {
            $values = [];
        }

        $text = implode(' ', array_filter($values));

        if (!$text) {
            return [];
        }

        return [
            'h2'      => '',
            'h3'      => '',
            'h4'      => '',
            'name'    => '',
            'content' => $this->replaceText($text),
        ];
    }

    /**
     * 按标题分类生成索引数组.
     *
     * @param Crawler $crawler
     * @param array   $tags
     * @param array   $prevTags
     * @param array   $titles
     *
     * @return array
     */
    protected function filterWithTag(Crawler $crawler, array $tags, array $prevTags = [], array $titles = [])
    {
        if (!$tags) {
            return [];
        }

        $tag = array_shift($tags);

        $nodes = $crawler->filter($tag);

        if (!$nodes->count()) {
            // 如果中间有标题“断层”（如：h2,h4，中间少了h3），会一直往下找
            // 但是会有获取到重复的数据，所以需要在获取到所有数据后进行去重
            array_unshift($prevTags, $tag);

            return $this->filterWithTag($crawler, $tags, $prevTags, $titles);
        }

        $values = $nodes->each(function (Crawler $node) use (&$prevTags, &$tags, &$titles) {
            $currentTag = $node->nodeName();

            // 标题
            $titles[$currentTag] = $node->text();

            // 锚点名称
            $name = $this->getAnchorName($node);

            // 合并所有标题标签名称
            $allTags = array_merge($prevTags, $tags, [$currentTag]);

            // 获取标题下最顶部文本（不属于任何子标题的文本）
            $topContent = null;
            if ($topText = $this->getNextAllText($node, $allTags)) {
                $topContent = array_merge([
                    'h2'      => '',
                    'h3'      => '',
                    'h4'      => '',
                    'name'    => $name,
                    'content' => $topText,
                ], $titles);
            }

            if (!in_array($currentTag, $prevTags)) {
                array_unshift($prevTags, $currentTag);
            }

            $end = false;
            $allNextNodes = $node->count() ? $node->nextAll()->each(function (Crawler $node) use (&$end, &$tags, &$titles, &$prevTags) {
                if (!$node->count()) {
                    return;
                }

                if ($end || in_array($node->nodeName(), $prevTags)) {
                    $end = true;

                    return;
                }

                // 递归获取所有子标题下的内容
                return $this->filterWithTag($node, $tags, $prevTags, $titles);
            }) : [];

            // 过滤空数组
            $allNextNodes = array_values(array_filter($allNextNodes, function ($v) {
                return !empty($v);
            }));

            // 三维数组转为二维
            if ($allNextNodes && !Arr::isAssoc($allNextNodes[0])) {
                $allNextNodes = Arr::flatten($allNextNodes, 1);
            }

            $topContent && array_unshift($allNextNodes, $topContent);

            return $allNextNodes;
        });

        return Arr::flatten($values, 1);
    }

    /**
     * 获取下面所有相邻节点的文本内容.
     *
     * @param Crawler $node
     * @param $endTag
     *
     * @return string
     */
    protected function getNextAllText(Crawler $node, $endTag)
    {
        if (!$node->count()) {
            return '';
        }

        $end = false;
        $endTag = (array) $endTag;

        $contents = $node->nextAll()->each(function (Crawler $node) use (&$end, $endTag) {
            if (!$node->count()) {
                return;
            }
            if ($end || in_array($node->nodeName(), $endTag)) {
                $end = true;

                return;
            }

            return $this->replaceText($node->text());
        });

        return implode('  ', array_filter($contents));
    }

    /**
     * 获取锚点名称.
     *
     * @param Crawler $node
     *
     * @return string|null
     */
    protected function getAnchorName(Crawler $node)
    {
        if (!$node->count()) {
            return;
        }

        $name = $node->previousAll()->first()->filter('a[name]');

        return $name->count() ? $name->attr('name') :
            (trim(str_replace([' ', '?', '#', '/', '\\', '&', '\'', '"', '<', '>', '='], '', $node->text())).'-'.$node->nodeName());
    }

    /**
     * 获取文档内容.
     *
     * @param $path
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     *
     * @return string
     */
    protected function getDocContent($path)
    {
        $content = $this->files->get($path);

        // 过滤导航标题
        // - [xxx](xxx)
        return preg_replace("/((?:-\s*){1}\[[^\]]*?\]\([^\)]*?\))/", '', trim($content));
    }

    /**
     * @param $content
     *
     * @return string
     */
    protected function replaceText($content)
    {
        // 过滤无意义字符
        $content = str_replace(['{tip}', '{note}', '{vedio}', "\r"], '', $content);
        $content = preg_replace('/(<a[\s]+name=[\'\"]{1}.*?[\'\"]{1}[\s]*>.*?<\/a>)/', '', $content);
        $content = preg_replace('/([\s]+)/', ' ', $content);
        $content = str_replace(["\n"], ' ', $content);

        return $content;
    }

    /**
     * @param array $indices
     *
     * @return string
     */
    protected function formatIndices(array $indices)
    {
        $indices = json_encode($indices, JSON_UNESCAPED_UNICODE);

        return 'window.CURRENT_INDICES='.str_replace('\/', '/', $indices);
    }

    /**
     * 二维数组按指定键去重.
     *
     * @param array  $values
     * @param string $key
     *
     * @return array
     */
    protected function unique(array $values, ?string $key)
    {
        $keys = [];

        foreach ($values as $k => $v) {
            if (!isset($v[$key]) || in_array($v[$key], $keys)) {
                unset($values[$k]);
                continue;
            }

            $keys[] = $v[$key];
        }

        return array_values($values);
    }
}
