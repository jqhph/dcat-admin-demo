<?php

namespace App\Admin\Controllers;

use App\Admin\Metrics\Examples\NewDevices;
use App\Admin\Metrics\Examples\NewUsers;
use App\Admin\Metrics\Examples\TotalUsers;
use App\Admin\Repositories\Report;
use App\Http\Controllers\Controller;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Illuminate\Contracts\Support\Renderable;

class ReportController extends Controller
{
    use PreviewCode;

    public function index(Content $content)
    {
        return $content
            ->header('报表')
            ->description('合并表头功能示例')
            ->body(function ($row) {
                $row->column(4, new TotalUsers());
                $row->column(4, new NewUsers());
                $row->column(4, new NewDevices());
            })
            ->body($this->grid());
    }

    protected function grid()
    {
        return new Grid(new Report(), function (Grid $grid) {
            // 开启responsive插件
            $grid->responsive();
            $grid->disableActions();
            $grid->disableBatchDelete();
            $grid->disableCreateButton();
            $grid->disableCreateButton();

            $grid->rowSelector()
                ->style('success')
                ->click();

            // 更改表格外层容器
            $grid->wrap(function (Renderable $view) {
                return $view;
            });

            $grid->combine('avgCost', ['avgMonthCost', 'avgQuarterCost', 'avgYearCost'])->responsive()->help('提示信息演示');
            $grid->combine('avgVist', ['avgMonthVist', 'avgQuarterVist', 'avgYearVist'])->responsive();

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
            $grid->date->sortable()->responsive();

            $grid->tools($this->buildPreviewButton());

            $grid->filter(function (Grid\Filter $filter) {
                $filter->scope(1, admin_trans_field('month'))->where('date', 2019, '<=');
                $filter->scope(2, admin_trans_label('quarter'))->where('date', 2019, '<=');
                $filter->scope(3, admin_trans_label('year'))->where('date', 2019, '<=');

                $filter->equal('content');
                $filter->equal('cost');
            });
        });
    }
}
