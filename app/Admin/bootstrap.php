<?php

use App\Admin\Grid\Tools\SwitchGridMode;
use Dcat\Admin\Admin;
use Dcat\Admin\Grid;
use Dcat\Admin\Form;
use Dcat\Admin\Grid\Filter;
use Dcat\Admin\Layout\Navbar;
use Dcat\Admin\Show;
use Dcat\Admin\Repositories\Repository;

/**
 * Dcat-admin - admin builder based on Laravel.
 * @author jqhph <https://github.com/jqhph>
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 *
 * extend custom field:
 * Dcat\Admin\Form::extend('php', PHPEditor::class);
 * Dcat\Admin\Grid\Column::extend('php', PHPEditor::class);
 * Dcat\Admin\Grid\Filter::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */

// 覆盖默认配置
config(['admin' => user_admin_config()]);
config(['app.locale' => config('admin.lang') ?: config('app.locale')]);

Admin::style('.main-sidebar .nav-sidebar .nav-item>.nav-link {
    border-radius: .1rem;
}');

// 扩展Column
Grid\Column::extend('code', function ($v) {
    return "<code>$v</code>";
});

Grid::resolving(function (Grid $grid) {
    if (! request('_row_')) {
        $grid->tableCollapse();


//        $grid->tools(new App\Admin\Grid\Tools\SwitchGridMode());
    }
});

// 追加菜单
Admin::menu()->add(include __DIR__.'/menu.php', 0);

Admin::navbar(function (Navbar $navbar) {
    // 切换主题
//    $navbar->right(view('admin.switch-theme', [
//        'map' => [
//            'indigo'    => Dcat\Admin\Admin::color()->indigo(),
//            'blue'      => '#5686d4',
//            'blue-dark' => '#5686d4',
//        ],
//    ]));

    // ajax请求不执行
    if (! Dcat\Admin\Support\Helper::isAjaxRequest()) {
        $navbar->right(App\Admin\Actions\AdminSetting::make()->render());
    }

    // 下拉菜单
    //$navbar->right(view('admin.navbar-2'));

    // 搜索框
    $navbar->right(
        <<<HTML
HTML
    );

    // 下拉面板
    $navbar->right(view('admin.navbar-1'));
});
