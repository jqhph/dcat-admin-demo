<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Report;
use App\Http\Controllers\Controller;
use Dcat\Admin\Admin;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Illuminate\Contracts\Support\Renderable;

class ReportController extends Controller
{
    use PreviewCode;

    public function index(Content $content)
    {
        Admin::style('.tab-content .da-box{margin-bottom:0}');

        $tab = $this->buildPreviewTab(function ($tab) {
            $tab->padding('5px 0 0 ');

            return $this->grid()->render();
        });

        return $content
            ->header('报表')
            ->description('合并表头功能示例')
            ->body($tab->custom());
    }

    protected function grid()
    {
        $grid = new Grid(new Report);

        // 开启responsive插件
        $grid->responsive();
        $grid->disableActions();
        $grid->disableBatchDelete();
        $grid->disableCreateButton();
        $grid->disableCreateButton();

        $grid->setRowSelectorOptions(['style' => 'success', 'clicktr' => true]);

        // 更改表格外层容器
        $grid->wrap(function (Renderable $view) {
            return $view;
        });

        $grid->combine('avgCost', ['avgMonthCost', 'avgQuarterCost', 'avgYearCost'])->responsive()->help('test');
        $grid->combine('avgVist', ['avgMonthVist', 'avgQuarterVist', 'avgYearVist'])->responsive();
        $grid->combine('top', ['topCost', 'topVist', 'topIncr'])->responsive()->style('color:#1867c0');

        $grid->content->limit(50)->responsive();
        $grid->cost->sortable()->responsive();
        $grid->avgMonthCost->responsive();
        $grid->avgQuarterCost->responsive()->setHeaderAttributes(['style' => 'color:#5b69bc']);
        $grid->avgYearCost->responsive();
        $grid->avgMonthVist->responsive();
        $grid->avgQuarterVist->responsive();
        $grid->avgYearVist->responsive();
        $grid->incrs->hide();
        $grid->avgVists->hide();
        $grid->topCost->responsive();
        $grid->topVist->responsive();
        $grid->topIncr->responsive();
        $grid->date->sortable()->responsive();

        $grid->filter(function (Grid\Filter $filter) {
            $filter->scope(1, admin_trans_field('month'))->where('date', 2019, '<=');
            $filter->scope(2, admin_trans_label('quarter'))->where('date', 2019, '<=');
            $filter->scope(3, admin_trans_label('year'))->where('date', 2019, '<=');

            $filter->equal('content');
            $filter->equal('cost');
        });

        return $grid;
    }
}
