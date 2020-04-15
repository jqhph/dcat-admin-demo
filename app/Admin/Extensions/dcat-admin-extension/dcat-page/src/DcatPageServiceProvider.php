<?php

namespace Dcat\Page;

use Dcat\Admin\Admin;
use Dcat\Page\Admin\DcatPageExtension;
use Dcat\Page\Http\Middleware\Initialization;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class DcatPageServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    protected $commands = [
        Console\CreateCommand::class,
        Console\CompileCommand::class,
        Console\IndexCommand::class,
    ];

    /**
     * @var array
     */
    protected $middlewares = [
        Initialization::class,
    ];

    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        // 如果安装了 dcat admin，则注册dcat admin扩展
        if (class_exists(Admin::class)) {
            if (! DcatPageExtension::enabled()) {
                return;
            }

            DcatPageExtension::make()->boot();
        }

        $this->registerRoutes();

        $this->loadViewsFrom(resource_path(DcatPage::NAME), DcatPage::NAME);
    }

    /**
     * Register routes.
     */
    public function registerRoutes()
    {
        $this->app->make('router')->group([
            'prefix'     => DcatPage::NAME,
            'middleware' => $this->middlewares,
            'namespace'  => 'Dcat\Page\Http\Controllers',
        ], function () {
            Route::get('{app}/resource/{path}', 'PageController@resource')->where('path', '.*');
            Route::get('{app}/docs/{version?}/{doc?}', 'PageController@doc');
            Route::get('{app}/{view?}', 'PageController@page')->where('view', '.*');
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands($this->commands);

        if (!defined('DCAT_PAGE_VERSION')) {
            include __DIR__.'/helpers.php';
        }
    }
}
