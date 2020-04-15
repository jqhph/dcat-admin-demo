<?php

namespace Dcat\Page;

use function DcatPage\asset;
use function DcatPage\generate_doc_path_when_compiling;
use function DcatPage\markdown;
use function DcatPage\path;
use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class Documentation
{
    /**
     * The filesystem implementation.
     *
     * @var Filesystem
     */
    protected $files;

    protected $basePath;

    /**
     * Create a new documentation instance.
     *
     * @param Filesystem $files
     * @param Cache      $cache
     *
     * @return void
     */
    public function __construct(Filesystem $files, $basePath = null)
    {
        $this->files = $files;
        $this->setBasePath($basePath);
    }

    /**
     * @param $basePath
     */
    public function setBasePath($basePath)
    {
        $this->basePath = $basePath;
    }

    /**
     * @param string $path
     *
     * @return string
     */
    public function fullPath($path)
    {
        $path = $this->basePath.'/'.trim($path, '/');

        if (!Str::contains($path, '.md')) {
            $path .= '.md';
        }

        return $path;
    }

    /**
     * Get the documentation index page.
     *
     * @param string $version
     *
     * @return string
     */
    public function getIndex($version, $index = 'documentation')
    {
        $path = $this->fullPath("{$version}/{$index}");

        if ($this->files->exists($path)) {
            return $this->replaceLinks($version, markdown($this->files->get($path)));
        }

        return null;
    }

    /**
     * Get the given documentation page.
     *
     * @param string $version
     * @param string $page
     *
     * @return string
     */
    public function get($version, $page)
    {
        $path = $this->fullPath($version.'/'.$page);

        if ($this->files->exists($path)) {
            return $this->replaceLinks($version, markdown($this->files->get($path)));
        }

        return null;
    }

    /**
     * Replace the version place-holder in links.
     *
     * @param string $version
     * @param string $content
     *
     * @return string
     */
    public static function replaceLinks($version, $content)
    {
        if (!$content) {
            return $content;
        }

        $path = '/'.trim(asset('/'), '/');

        if (DcatPage::isCompiling()) {
            $path = '';

            $content = preg_replace_callback('/href[\s]*=[\s]*[\"\']([\s]*[\w-]+.md[^\"\']*)[\"\']/u', function (&$text) use ($version) {
                $text = $text[1] ?? '';

                return 'href="'.generate_doc_path_when_compiling($version, $text).'"';
            }, $content);

            $content = str_replace('{{public}}/', '{{public}}', $content);
        }

        $content = str_replace(['{{version}}', '{{public}}'], [$version, $path], $content);
        $content = str_replace('&amp;#123;', '{', $content);

        return $content;
    }

    /**
     * Check if the given section exists.
     *
     * @param string $version
     * @param string $page
     *
     * @return bool
     */
    public function sectionExists($version, $page)
    {
        return $this->files->exists(
            $this->fullPath($version.'/'.$page)
        );
    }

    /**
     * @param null $basePath
     *
     * @return static
     */
    public static function make($basePath = null)
    {
        $basePath = $basePath ?: path('docs');

        return new static(app('files'), $basePath);
    }

    /**
     * @return array
     */
    public function getVersions()
    {
        if (!isset($this->versions)) {
            $this->versions = array_map('basename', $this->files->directories($this->basePath));
        }

        return $this->versions;
    }
}
