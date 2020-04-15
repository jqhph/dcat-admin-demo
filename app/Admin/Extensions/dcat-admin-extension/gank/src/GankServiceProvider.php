<?php

namespace Dcat\Admin\Extension\Gank;

use Dcat\Admin\Admin;
use Illuminate\Support\ServiceProvider;

class GankServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        $extension = Gank::make();

        if ($views = $extension->views()) {
            $this->loadViewsFrom($views, Gank::NAME);
        }

        if ($lang = $extension->lang()) {
            $this->loadTranslationsFrom($lang, Gank::NAME);
        }

        if ($migrations = $extension->migrations()) {
            $this->loadMigrationsFrom($migrations);
        }

        $this->app->booted(function () use ($extension) {
            $extension->routes(__DIR__.'/../routes/web.php');
        });

        // 添加菜单
        $this->registerMenus();
    }

    protected function registerMenus()
    {
        Admin::menu()->add([
            [
                'id'        => 1,
                'title'     => '干货集中营',
                'icon'      => ' fa-newspaper-o',
                'uri'       => 'gank',
                'parent_id' => 0,
                'permission_id' => 'gank',
            ],
            [
                'id'        => 2,
                'title'     => '今日最新干货',
                'icon'      => 'fa-smile-o',
                'uri'       => 'gank/latest',
                'parent_id' => 1,
                'permission_id' => 'gank',
            ],
            [
                'id'        => 3,
                'title'     => '所有干货',
                'icon'      => 'fa-smile-o',
                'uri'       => 'gank',
                'parent_id' => 1,
                'permission_id' => 'gank',
            ],
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    }

}