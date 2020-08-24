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

    $router->resource('users', 'UserController');

    // 布局示例
    $router->get('layout', 'LayoutController@index');
    // 报表示例
    $router->get('reports', 'ReportController@index');
    $router->get('reports/preview', 'ReportController@preview');
    // 固定列功能示例
    $router->get('fixed-columns', 'FixedController@index');
    $router->get('fixed-columns/preview', 'FixedController@preview');
    // 固定列功能示例
    $router->get('with-border', 'BorderTableController@index');
    $router->get('with-border/preview', 'BorderTableController@preview');
    // 行间距
    $router->get('row-space', 'RowSpaceController@index');
    $router->get('row-space/preview', 'RowSpaceController@preview');
    // 自定义表格视图
    $router->get('grid/custom', 'CustomGridController@index');
    $router->get('grid/custom/preview', 'CustomGridController@preview');

    // simple page
    $router->get('full', 'FullPageController@index');

    $router->get('tree', 'GridTreeController@index');
    $router->get('tree/preview', 'GridTreeController@preview');

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

    // 动态显示表单
    $router->get('form/when/preview', 'FormWhenController@preview');
    $router->get('form/when', 'FormWhenController@index');
    $router->post('form/when', 'FormWhenController@store');

    // 表单弹窗
    $router->get('form/modal', 'ModalFormController@index');
    $router->get('form/modal/preview', 'ModalFormController@preview');

    $router->get('form/tinymce', 'EditorController@tinymce');
    $router->get('form/tinymce/preview', 'EditorController@preview');
    $router->get('form/markdown', 'EditorController@markdown');

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
    $router->get('components/metric-cards', 'Components\MetricCardController@index');
    $router->get('components/metric-cards/preview', 'Components\MetricCardController@preview');

    $router->get('components/modal', 'Components\ModalController@index');
    $router->get('components/modal/preview', 'Components\ModalController@preview');

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
