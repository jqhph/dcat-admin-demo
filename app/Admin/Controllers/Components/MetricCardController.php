<?php

namespace App\Admin\Controllers\Components;

use App\Admin\Controllers\PreviewCode;
use App\Admin\Metrics\Examples\GoalOverview;
use App\Admin\Metrics\Examples\NewDevices;
use App\Admin\Metrics\Examples\NewUsers;
use App\Admin\Metrics\Examples\ProductOrders;
use App\Admin\Metrics\Examples\Sessions;
use App\Admin\Metrics\Examples\Tickets;
use App\Admin\Metrics\Examples\TotalUsers;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Illuminate\Routing\Controller;

class MetricCardController extends Controller
{
    use PreviewCode;

    public function index(Content $content)
    {
        return $content
            ->header('数据统计卡片')
            ->body($this->buildPreviewButton().$this->newline())
            ->body(function (Row $row) {
                $row->column(4, new TotalUsers());
                $row->column(4, new NewUsers());
                $row->column(4, new NewDevices());
            })
            ->body(function (Row $row) {
                $row->column(6, new Sessions());
                $row->column(6, new ProductOrders());
            })
            ->body(function (Row $row) {
                $row->column(6, new Tickets());
                $row->column(4, new GoalOverview());
            });
    }
}
