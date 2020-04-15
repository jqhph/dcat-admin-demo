<?php

namespace Dcat\Admin\Extension\Gank\Http\Controllers;

use Dcat\Admin\Extension\Gank\Gank;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Illuminate\Routing\Controller;
use Dcat\Admin\Extension\Gank\Repositories\Latest;

class LatestController extends Controller
{
    /**
     * Index interface.
     *
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('今日最新干货')
            ->description('每日分享妹子图 和 技术干货')
            ->body(function (Row $row) {
                $row->column(7, Gank::navbar());

            })
            ->body($this->grid());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Gank::grid(new Latest)->disablePagination();
    }


}
