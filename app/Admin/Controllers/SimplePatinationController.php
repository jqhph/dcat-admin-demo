<?php

namespace App\Admin\Controllers;

use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\UserController;

class SimplePatinationController extends UserController
{
    use PreviewCode;

    protected $description = [
        'index' => '启用 <a href="https://laravel.com/docs/8.x/pagination#simple-pagination" target="_blank">simplePaginate</a> 功能后可以提升页面的响应速度，如果你的表格不需要展示<b>总数</b>，那么就可以使用此方法进行分页。',
    ];

    public function grid()
    {
        return tap(parent::grid(), function (Grid $grid) {
            // 启用 simplePaginate 分页功能
            $grid->simplePaginate();

            $grid->tools($this->buildPreviewButton());
        });
    }
}
