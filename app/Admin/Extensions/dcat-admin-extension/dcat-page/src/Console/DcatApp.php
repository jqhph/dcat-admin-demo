<?php

namespace Dcat\Page\Console;

use Dcat\Page\DcatPage;
use function DcatPage\slug;

trait DcatApp
{
    protected $appName;

    /**
     * 获取应用名称.
     *
     * @return mixed
     */
    public function getAppName()
    {
        if ($this->appName) {
            return $this->appName;
        }

        if (!$this->hasArgument('name')) {
            return null;
        }

        $name = str_replace('.', '-', $this->argument('name'));

        return slug($name);
    }

    /**
     * 设置应用名称.
     *
     * @param $name
     */
    protected function setAppName($name)
    {
        $this->appName = $name;
    }

    /**
     * 获取应用目录.
     *
     * @param $name
     *
     * @return string
     */
    public function path($name)
    {
        return resource_path(DcatPage::NAME.DIRECTORY_SEPARATOR.$name);
    }

    /**
     * 判断应用目录是否存在.
     *
     * @param $name
     *
     * @return bool
     */
    public function exist($name)
    {
        return is_dir($this->path($name));
    }

    /**
     * 写文件.
     *
     * @param $path
     * @param $content
     *
     * @return bool|int
     */
    public function putContent($path, $content)
    {
        if (!isset($this->files) || !$this->files) {
            $this->files = app('files');
        }

        $dir = dirname($path);
        if (!is_dir($dir)) {
            $this->files->makeDirectory($dir, 0755, true);
        }

        if (isset($this->counter)) {
            $this->counter++;
        }

        return $this->files->put($path, $content);
    }

    /**
     * @param $doc
     *
     * @return bool
     */
    public function shouldSkip($doc)
    {
        if (!isset($this->skipDocs)) {
            $this->skipDocs = array_map(function ($v) {
                return $v.'.md';
            }, array_merge([
                \DcatPage\config('doc.index'),
                'LICENSE',
                'README',
            ], (array) \DcatPage\config('doc.ignore')));
        }

        return in_array($doc, $this->skipDocs);
    }
}
