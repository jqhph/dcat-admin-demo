<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Dcat\Admin\Admin;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');

    $router->resource('posts', 'PostsController');

    // 布局示例
    $router->get('layout', 'LayoutController@index');
    // 报表示例
    $router->get('reports', 'ReportController@index');
    // simple page
    $router->get('simple', 'SimpleController@index');

    // grid
    $router->resource('components/grid', 'GridController', ['except' => ['create', 'show', 'destroy']]);
    $router->get('components/grid/preview', 'GridController@preview');
    // form
    $router->get('form', 'FormController@index');
    $router->post('form', 'FormController@index');
    $router->get('form/preview', 'FormController@preview');

    // 分步表单
    $router->get('form/step/preview', 'StepFormController@preview');
    $router->get('form/step', 'StepFormController@index');
    $router->post('form/step', 'StepFormController@store');

    // 表单弹窗
    $router->get('form/modal', 'ModalFormController@index');
    $router->get('form/modal/preview', 'ModalFormController@preview');


    // 表格
    $router->get('tables/selector', 'SelectorController@index');
    $router->get('tables/selector/preview', 'SelectorController@preview');

    // 其余组件
    $router->get('components/charts', 'Components\ChartController@index');
    $router->get('components/charts/preview', 'Components\ChartController@preview');
    $router->get('components/card-box', 'Components\BoxController@index');
    $router->get('components/alert', 'Components\AlertController@index');
    $router->get('components/tab-button', 'Components\TabController@index');
    $router->get('components/markdown', 'Components\MarkdownController@index');
    $router->get('components/layer', 'Components\LayerController@index');
    $router->get('components/checkbox-radio', 'Components\CheckboxController@index');
    $router->get('components/checkbox-radio/preview', 'Components\CheckboxController@preview');
    $router->get('components/tooltip', 'Components\TooltipController@index');
    $router->get('components/dropdown-menu', 'Components\DropdownMenuController@index');
    $router->get('components/loading', 'Components\LoadingController@index');
    $router->get('components/loading/preview', 'Components\LoadingController@preview');
    $router->get('components/data-cards', 'Components\DataCardController@index');
    $router->get('components/data-cards/preview', 'Components\DataCardController@preview');

    $router->get('components/navbar', 'Components\NavbarController@index');
    $router->get('components/accordion', 'Components\AccordionController@index');

    // movies
    $router->get('movies/coming-soon', 'Movies\ComingSoonController@index');
    $router->get('movies/coming-soon/preview', 'Movies\ComingSoonController@preview');
    $router->resource('movies/in-theaters', 'Movies\InTheaterController', ['except' => ['create', 'show']]);
    $router->get('movies/in-theaters/preview', 'Movies\InTheaterController@preview');
    $router->get('movies/top250', 'Movies\Top250Controller@index');
    $router->get('movies/top250/preview', 'Movies\Top250Controller@preview');

    $router->get('/extensions/ueditor', 'Extensions\UeditorController@index');
    $router->get('/extensions/ueditor/preview', 'Extensions\UeditorController@preview');

});
