<?php

namespace Dcat\Admin\Extension\Gank\Http\Controllers;

use Dcat\Admin\Extension\Gank\Gank;
use Dcat\Admin\Extension\Gank\Repositories\Ganks;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Illuminate\Routing\Controller;

class GankController extends Controller
{
    /**
     * Index interface.
     *
     * @return Content
     */
    public function index(Content $content)
    {
        $grid = $this->grid();

        $grid->disableFilter();
        $grid->filter()
            ->panel()
            ->withoutInputBorder()
            ->expand()
            ->resetPosition()
            ->hiddenResetButtonText();

        return $content
            ->header('所有干货')
            ->description('每日分享妹子图 和 技术干货')
            ->body($grid->filter())
            ->body(function (Row $row) {
                $row->column(7, Gank::navbar());
            })
            ->body($grid);
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Gank::grid(new Ganks)->perPages([])->filter(function (Grid\Filter $filter) {
            $category = $filter->input(Grid\Filter\Scope::QUERY_NAME, '全部');

            if ($category != '福利') {
                $filter->like('keyword', ucfirst($category))->width('300px')->placeholder('请输入');
            }
        });
    }
}