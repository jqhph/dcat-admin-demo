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
            $grid->combine('avgCost', ['avgMonthCost', 'avgQuarterCost', 'avgYearCost'])->responsive()->help('提示信息演示');
            $grid->combine('avgVist', ['avgMonthVist', 'avgQuarterVist', 'avgYearVist'])->responsive();

            $grid->tableCollapse(false);

            $grid->column('content')->limit(50)->responsive();
            $grid->column('cost')->sortable()->responsive();
            $grid->column('avgMonthCost')->responsive();
            $grid->column('avgQuarterCost')->responsive()->setHeaderAttributes(['style' => 'color:#5b69bc']);
            $grid->column('avgYearCost')->responsive();
            $grid->column('avgMonthVist')->responsive();
            $grid->column('avgQuarterVist')->responsive();
            $grid->column('avgYearVist')->responsive();
            $grid->column('incrs')->hide();
            $grid->column('avgVists')->hide();
            $grid->column('date')->sortable()->responsive();

            // 开启responsive插件
            $grid->responsive();
            $grid->disableActions();
            $grid->disableBatchDelete();
            $grid->disableCreateButton();
            $grid->disableCreateButton();

            $grid->rowSelector()
                ->style('success')
                ->click();

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
