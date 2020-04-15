<?php

namespace Dcat\Admin\Extension\UEditor;

use Dcat\Admin\Extension;
use Illuminate\Support\Arr;

class Ueditor extends Extension
{
    const NAME = 'ueditor';

    protected $serviceProvider = UeditorServiceProvider::class;

    protected $views = __DIR__.'/../resources/views';

    protected $assets = __DIR__.'/../resources/assets';

    protected $lang = __DIR__.'/../resources/lang';

    protected $composer = __DIR__.'/../composer.json';

    public static function getUploadConfig($key = null, $default = null)
    {
        $config = config('ueditor') ?: (include __DIR__.'/../config/ueditor.php');

        if ($key === null) {
            return $config;
        }

        return Arr::get($config, $key, $default);
    }
}
