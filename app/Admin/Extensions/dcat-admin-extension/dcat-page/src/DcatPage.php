<?php

namespace Dcat\Page;

use DcatPage as Fun;
use Illuminate\Support\Facades\Event;

class DcatPage
{
    const VERSION = '1.0.0';
    const NAME = 'dcat-page';

    /**
     * @var string
     */
    protected static $appName;

    /**
     * @var bool
     */
    protected static $isCompiling = false;

    /**
     * @var array
     */
    protected static $allAppNames = [];

    /**
     * 初始化.
     *
     * @param string $app         应用名称
     * @param bool   $isCompiling
     */
    public static function init(?string $app, bool $isCompiling = false)
    {
        static::setCurrentAppName($app);
        static::setIsCompiling($isCompiling);
        static::setAppConfig($app);
    }

    /**
     * 设置应用配置.
     *
     * @param string|null $app
     */
    protected static function setAppConfig(?string $app)
    {
        $config = [];
        if (is_file($path = Fun\path('config.php'))) {
            $config = (array) include $path;
        }

        config([static::NAME.'.'.$app => $config]);
    }

    /**
     * @param bool $isCompiling
     */
    public static function setIsCompiling(bool $isCompiling)
    {
        self::$isCompiling = $isCompiling;
    }

    /**
     * 判断项目是否在编译中.
     *
     * @return bool
     */
    public static function isCompiling()
    {
        return static::$isCompiling;
    }

    /**
     * 监听编译事件.
     *
     * @param $listener
     */
    public static function compiling($listener)
    {
        Event::listen('dcat-page:compiling', $listener);
    }

    /**
     * 触发编译中事件.
     *
     * @param Console\CompileCommand $comman
     */
    public static function callCompiling(Console\CompileCommand $command)
    {
        Event::dispatch('dcat-page:compiling', $command);
    }

    /**
     * 设置当前应用名称.
     *
     * @param string|null $app
     */
    public static function setCurrentAppName(?string $app)
    {
        static::$appName = $app;
    }

    /**
     * 获取当前应用名称.
     *
     * @return string
     */
    public static function getCurrentAppName()
    {
        return static::$appName;
    }

    /**
     * 获取所有应用名称.
     *
     * @return array
     */
    public static function getAllAppNames()
    {
        return static::$allAppNames ?: (static::$allAppNames = array_map(
            'basename',
            app('files')->directories(Fun\path())
        ));
    }
}
