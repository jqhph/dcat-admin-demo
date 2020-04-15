<?php

namespace Dcat\Page\Console;

use Dcat\Page\DcatPage;
use Dcat\Page\Http\Controllers\PageController;
use function DcatPage\default_version;
use function DcatPage\generate_doc_path_when_compiling;
use function DcatPage\page;
use function DcatPage\path;
use function DcatPage\slug;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Symfony\Component\Finder\SplFileInfo;

class CompileCommand extends Command
{
    use DcatApp;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dcatpage:compile {name?} {--dir=} {--path=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Compile the app.';

    /**
     * @var Filesystem
     */
    protected $files;

    /**
     * @var string
     */
    protected $distPath;

    /**
     * @var int
     */
    public $counter = 0;

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

        $start = microtime(true);

        if (!$name) {
            $name = $this->getAllAppNames();
        }

        foreach ((array) $name as $app) {
            $this->compile($app);

            $this->counter = 0;
            $this->distPath = null;
        }

        $cost = round(microtime(true) - $start, 2);

        $this->info("Completed in {$cost} seconds.");
    }

    /**
     * 编译.
     *
     * @param $name
     */
    protected function compile($name)
    {
        DcatPage::init($name, true);

        $this->setAppName($name);

        $this->callSilent('view:clear');

        $this->makeDistDirectory($name);

        $this->call('dcatpage:index', ['name' => $name]);
        $this->compilePages($name);
        $this->compileDocumentations($name);
        $this->copyAssets($name);

        DcatPage::callCompiling($this);

        $this->callSilent('view:clear');

        $dist = basename($this->getDistPath());

        $this->info("[{$name} --- _dist_/{$dist}] Successfully compiled {$this->counter} pages.");
    }

    /**
     * 生成构建目录.
     *
     * @param $name
     */
    protected function makeDistDirectory($name)
    {
        $this->distPath = $this->createDistPath($name);

        if (!is_dir(dirname($this->distPath))) {
            $this->files->makeDirectory(dirname($this->distPath));
        }

        $this->files->makeDirectory($this->distPath);
    }

    /**
     * 构建页面.
     *
     * @param $name
     */
    protected function compilePages($name)
    {
        $from = $this->getPagesPath($name);
        $dist = $this->getDistPath();

        collect($this->files->allFiles($from, true))->each(function (SplFileInfo $fileInfo) use ($name, $from, $dist) {
            $view = trim(
                str_replace(
                    [$from, '\\', '.blade', '.php'],
                    ['', '/', '', ''],
                    $fileInfo->getRealPath()
                ),
                '/'
            );

            $path = $dist.'/'.str_replace('/', '-', slug($view)).'.html';

            if ($view == 'docs') {
                return $this->putDefaultDocumention($path);
            }

            $this->putContent($dist.'/'.str_replace('/', '-', slug($view)).'.html', page($view)->render());
        });
    }

    /**
     * @param string $path
     */
    protected function putDefaultDocumention($path)
    {
        $doc = \DcatPage\config('doc.default', 'installation');

        $version = default_version();

        $file = $path ?: ($this->getDistPath().'/'.generate_doc_path_when_compiling($version, $doc));

        $path = generate_doc_path_when_compiling($version, $doc);

        $this->putContent(
            $file,
            <<<HTML
<html>
    <body>
        <script>
            location.href='{$path}';
        </script>    
    </body>
</html>
HTML
        );
    }

    /**
     * 构建文档.
     *
     * @param $name
     */
    protected function compileDocumentations($name)
    {
        $docBasePath = str_replace('\\', '/', path('docs')).'/';

        collect($this->files->allFiles($docBasePath, true))->map(function (SplFileInfo $fileInfo) use ($name, $docBasePath) {
            if ($this->shouldSkip(basename($fileInfo->getRealPath()))) {
                return;
            }

            $real = str_replace('\\', '/', $fileInfo->getRealPath());

            $this->compileDocumentation($name, str_replace([$docBasePath, '.md'], ['', ''], $real));
        });
    }

    /**
     * 生成文档.
     *
     * @param $name
     * @param $doc
     * @param null $path
     */
    public function compileDocumentation($name, $doc, $path = null)
    {
        $doc = str_replace(DIRECTORY_SEPARATOR, '/', $doc);

        list($version, $doc) = explode('/', $doc);

        $content = (new PageController())->doc($name, $version, $doc)->render();

        $path = $path ?: ($this->getDistPath().'/'.generate_doc_path_when_compiling($version, $doc));

        $this->putContent($path, $this->replaceDocumentAssetsLinks($path, $version, $content));
    }

    /**
     * @param $path
     * @param $version
     * @param string|null $content
     *
     * @return string
     */
    protected function replaceDocumentAssetsLinks($path, $version, ?string $content)
    {
        if (!Str::contains($path, $version)) {
            return $content;
        }

        $content = $this->htmlspecialchars($content);

        $content = preg_replace_callback('/href[\s]*=[\s]*[\"\']([\s]*[^\"\']*)[\"\']/u', function (&$text) {
            $url = trim($text[1] ?? '');

            return 'href="'.$this->getDocumentAssetsUrl($url).'"';
        }, $content);

        return $this->htmlspecialcharsDecode(
            preg_replace_callback('/src[\s]*=[\s]*[\"\']([\s]*[^\"\']*)[\"\']/u', function (&$text) {
                $url = trim($text[1] ?? '');

                return 'src="'.$this->getDocumentAssetsUrl($url).'"';
            }, $content)
        );
    }

    /**
     * @param $content
     *
     * @return string
     */
    protected function htmlspecialchars($content)
    {
        return preg_replace_callback('/<code([^>]*)>([^<]*)<\/code>/u', function (&$text) {
            $attrs = $text[1] ?? '';
            $text = e($text[2] ?? '');

            return "<code {$attrs}>{$text}</code>";
        }, $content);
    }

    /**
     * @param $content
     *
     * @return string
     */
    protected function htmlspecialcharsDecode($content)
    {
        return preg_replace_callback('/<code([^>]*)>([^<]*)<\/code>/u', function (&$text) {
            $attrs = $text[1] ?? '';
            $text = htmlspecialchars_decode($text[2] ?? '');

            return "<code {$attrs}>{$text}</code>";
        }, $content);
    }

    /**
     * @param $url
     *
     * @return string
     */
    protected function getDocumentAssetsUrl($url)
    {
        if (
            $url
            && !in_array($url, ['#'])
            && strpos($url, '#') !== 0
            && !Str::contains($url, 'javascript:')
            && !Str::contains($url, '//')
        ) {
            $url = '../../'.$url;
        }

        return $url;
    }

    /**
     * 复制静态资源.
     *
     * @param $name
     */
    protected function copyAssets($name)
    {
        $from = $this->path($name.DIRECTORY_SEPARATOR.'public');
        $dist = $this->getDistPath();

        collect($this->files->allFiles($from, true))->each(function (SplFileInfo $fileInfo) use ($from, $dist) {
            $realPath = $fileInfo->getRealPath();

            $to = $dist.str_replace($from, '', $realPath);
            $dir = dirname($to);
            if (!is_dir($dir)) {
                $this->files->makeDirectory($dir, 0755, true);
            }

            $this->files->copy($realPath, $to);
        });
    }

    /**
     * 获取页面目录.
     *
     * @param $name
     *
     * @return string
     */
    public function getPagesPath($name)
    {
        return $this->path($name).DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'pages';
    }

    /**
     * 获取编译目录.
     *
     * @return mixed
     */
    public function getDistPath()
    {
        return $this->distPath;
    }

    /**
     * 拼接编译目录.
     *
     * @param $name
     *
     * @return string
     */
    protected function createDistPath($name)
    {
        $dirName = $this->getDir($name);

        return $this->getDistBasePath($name, $dirName);
    }

    /**
     * 拼接编译目录.
     *
     * @param $name
     * @param $dirName
     *
     * @return string
     */
    public function getDistBasePath($name, $dirName)
    {
        if (!$path = $this->option('path')) {
            return $this->path($name.DIRECTORY_SEPARATOR.'_dist_'.DIRECTORY_SEPARATOR.$dirName);
        }

        // 如果指定了路径
        $path = $this->replaceDistPath($path, $name);

        if (!is_dir($path)) {
            $this->files->makeDirectory($path, 0755, true);
        }

        return $path.DIRECTORY_SEPARATOR.$dirName;
    }

    /**
     * 获取编译文件夹名称.
     *
     * @param $name
     *
     * @return false|string
     */
    public function getDir($name)
    {
        $dir = $this->replaceDistPath($this->option('dir') ?: date('Ymd-His'), $name);

        $fullPath = rtrim($this->getDistBasePath($name, ''), '/');

        if (!is_dir($fullPath)) {
            return $dir;
        }

        $same = 0;
        collect($this->files->directories($fullPath))->map(function ($v) use ($dir, &$same) {
            $v = preg_replace('(-[0-9]+$)', '', basename($v));

            if ($v == $dir) {
                $same++;
            }
        });

        if (!$same) {
            return $dir;
        }

        return $dir.'-'.($same);
    }

    /**
     * @param string $path
     * @param string $name
     *
     * @return string
     */
    protected function replaceDistPath($path, $name)
    {
        return str_replace(':app', $name, $path);
    }

    /**
     * 获取所有应用名称.
     *
     * @return array
     */
    public function getAllAppNames()
    {
        return DcatPage::getAllAppNames();
    }
}
