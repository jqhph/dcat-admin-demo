<?php

namespace Dcat\Page\Admin;

use Dcat\Admin\Admin;
use Dcat\Admin\Extension;
use Dcat\Page\DcatPage;
use Illuminate\Support\Facades\Route;

class DcatPageExtension extends Extension
{
    const NAME = DcatPage::NAME;

    protected $composer = __DIR__.'/../../composer.json';

    /**
     * 初始化
     */
    public function boot()
    {
        $this->registerMenu();

        $this->routes(function () {
            Route::get('dcat-page',  Controllers\AdminController::class.'@index');
            Route::post('dcat-page/create-app', Controllers\AdminController::class.'@createApp');
            Route::post('dcat-page/compile-app', Controllers\AdminController::class.'@compileApp');
            Route::post('dcat-page/index-app', Controllers\AdminController::class.'@indexApp');
        });
    }

    public function registerMenu()
    {
        Admin::menu()->add([
            [
                'id'            => 'dcat-page',
                'title'         => 'Dcat Page',
                'icon'          => 'fa-file-text-o',
                'uri'           => 'dcat-page',
                'parent_id'     => 0,
                'permission_id' => 'dcat-page',
            ],
        ]);
    }
}
