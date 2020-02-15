<?php

namespace App\Admin\Controllers\Components;

use App\Admin\Controllers\PreviewCode;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Widgets\Box;
use Dcat\Admin\Widgets\Chart\Bar;
use Dcat\Admin\Widgets\Chart\Bubble;
use Dcat\Admin\Widgets\Chart\Doughnut;
use Dcat\Admin\Widgets\Chart\Line;
use Dcat\Admin\Widgets\Chart\Pie;
use Dcat\Admin\Widgets\Chart\PolarArea;
use Dcat\Admin\Widgets\Chart\Radar;
use Dcat\Admin\Widgets\Dropdown;
use Illuminate\Routing\Controller;
use Illuminate\Support\Collection;

class ChartController extends Controller
{
    use PreviewCode;

    public function index(Content $content)
    {
        if (request('fetch_bar')) {
            // 返回 条形图 数据
            return $this->fetchBar();
        }

        return $content->header('Charts')
            ->description("See <a href='https://www.chartjs.org' target='_blank'>https://www.chartjs.org</a>.")
            ->body($this->buildPreviewButton().$this->newline())
            ->body(function (Row $row) {
                $row->column(4, $this->line());
                $row->column(4, $this->bar());
                $row->column(4, $this->bubble());
            })
            ->body($this->newline())
            ->body(function (Row $row) {
                $row->column(4, $this->pie());
                $row->column(4, $this->doughnut());
                $row->column(4, $this->polarArea());
            })
            ->body($this->newline())
            ->body(function (Row $row) {
                $row->column(4, $this->radar());

            });
    }

    protected function line()
    {
        $chart = Line::make('Line', ['一', '二', '三', '四', '五'])
            ->add(
                [
                    ['离心', [16, 18, 6, 10, 6]], ['阿翡', [4, 11, 8, 25, 19]],
                    ['离心2', [7, 18, 20, 19, 26]], ['阿翡2', [13, 16, 15, 12, 22]],
                    ['离心3', [17, 12, 2, 5, 20]], ['阿翡3', [15, 3, 12, 23, 9]],
                ]
            );

        switch ((int)request('fill')) {
            case 1:
                $chart->fillBackground();
                break;
            case 2:
                $chart->fillBackground(true);
                break;
        }

        return $this->box('Line', $chart)->tool(function () {
            $req = request();
            return <<<HTML
<div class="btn-group">
    <a class='btn btn-default' href="{$req->fullUrlWithQuery(['fill' => 1])}"> Fill background </a>
    <a class='btn btn-default' href="{$req->fullUrlWithQuery(['fill' => 2])}"> Opaque </a>
    <a class='btn btn-default' href="{$req->fullUrlWithQuery(['fill' => 0])}"> Reset </a>
</div>
HTML;
        });
    }

    protected function bar()
    {
        $chart = Bar::make('Bar [AJAX]', ['一', '二', '三', '四', '五'])
            ->request('components/charts?fetch_bar=1') // 设置远程抓取数据接口
            ->refetch('.bar-dropdown-option') // 绑定重新抓取数据按钮
            ->fetching('$(".bar-box").loading({bg:"rgba(255,255,255, 0.2)", color: "var(--60)"})') // 显示loading效果
            ->fetched('$(".bar-box").loading(false);console.log("fetched", result)'); // 移除loading效果并打印接口数据到控制台

        return $this->box('Bar [AJAX]', $chart, 'bar-box')->tool(function () {
            // 创建下拉菜单
            return Dropdown::make(['Ajax Default',  'Ajax Combo', 'Ajax Random'])
                ->click()
                ->buttonClass('btn btn-default')
                ->map(function ($v, $k) {
                    // 设置 "data" 属性，点击时可以把属性内容当做请求参数发送到接口
                    return "<a data-act='$k' class='bar-dropdown-option' href='javascript:void(0)'>$v</a>";
                });
        });
    }

    protected function bubble()
    {
        $chart = Bubble::make('Bubble')
            ->displayScaleLabelOnX('Number')
            ->displayScaleLabelOnY('Value')
            ->add('一', [
                ['x' => 1, 'y' => 8, 'r' => 12],
                ['x' => 4, 'y' => 3, 'r' => 5],
                ['x' => 3, 'y' => 5, 'r' => 8],
            ])
            ->add('二', [
                ['x' => -2, 'y' => 4, 'r' => 9],
                ['x' => 3, 'y' => 7, 'r' => 13],
                ['x' => 4, 'y' => 2, 'r' => 4],
                ['x' => -1, 'y' => 6, 'r' => 5],
            ])
            ->add('三', [
                ['x' => 0, 'y' => 2, 'r' => 7],
                ['x' => 2, 'y' => 8, 'r' => 9],
                ['x' => 1, 'y' => 3, 'r' => 10],
            ])
            ->add('四', [
                ['x' => -1, 'y' => 5, 'r' => 6],
                ['x' => 0, 'y' => 4, 'r' => 11],
                ['x' => 1, 'y' => 6, 'r' => 8],
                ['x' => 2, 'y' => 1, 'r' => 6],
            ]);

        return $this->box('Bubble', $chart);
    }

    protected function pie()
    {
        $chart = Pie::make('Pie', ['一', '二', '三'])->add([12, 34, 21])->legendPosition('right');

        return $this->box('Pie', $chart);
    }

    protected function doughnut()
    {
        $chart = Doughnut::make('Doughnut', ['一', '二', '三', '四', '五', '六', '七', '八'])
            ->cutoutPercentage(55)
            ->add([31, 46, 25, 11, 18, 19, 13, 26]);

        switch ((int)request('dlegend')) {
            case 1:
                $chart->disableLegend();
                break;
            case 2:
                $chart->legendPosition('right');
                break;
            case 3:
                $chart->legendPosition('bottom');
                break;
            case 4:
                $chart->legendPosition('left');
                break;
        }

        return $this->box('Doughnut', $chart)->tool(function () {
            $req = request();
            return <<<HTML
<div class="btn-group">
    <a class='btn btn-default' href="{$req->fullUrlWithQuery(['dlegend' => 1])}"> Disable Legend </a>
    <a class='btn btn-default' href="{$req->fullUrlWithQuery(['dlegend' => 2])}"> Right </a>
    <a class='btn btn-default' href="{$req->fullUrlWithQuery(['dlegend' => 3])}"> Bottom </a>
    <a class='btn btn-default' href="{$req->fullUrlWithQuery(['dlegend' => 4])}"> Left </a>
    <a class='btn btn-default' href="{$req->fullUrlWithQuery(['dlegend' => 0])}"> Reset </a>
</div>
HTML;
        });
    }

    protected function polarArea()
    {
        $chart = PolarArea::make('PolarArea', ['一', '二', '三'])->add([25, 32, 18]);

        return $this->box('PolarArea', $chart);
    }

    protected function radar()
    {
        $chart = Radar::make('Radar', ['一', '二', '三', '四', '五'])->add([
            ['离心', [1, 23, 6, 10, 6]], ['阿翡', [4, 11, 8, 25, 19]],
        ]);

        switch ((int)request('fillr')) {
            case 1:
                $chart->fillBackground();
                break;
            case 2:
                $chart->fillBackground(true);
                break;
        }

        return $this->box('Radar', $chart)->tool(function () {
            $req = request();
            return <<<HTML
<div class="btn-group">
    <a class='btn btn-default' href="{$req->fullUrlWithQuery(['fillr' => 1])}"> Fill background </a>
    <a class='btn btn-default' href="{$req->fullUrlWithQuery(['fillr' => 2])}"> Opaque </a>
    <a class='btn btn-default' href="{$req->fullUrlWithQuery(['fillr' => 0])}"> Reset </a>
</div>
HTML;
        });
    }

    protected function fetchBar()
    {
        $chart = Bar::make();

        $def = [
            ['离心', [7, 23, 6, 10, 6]], ['阿翡', [4, 11, 13, 25, 19]],
        ];

        switch ((int)request('act')) {
            case 1: // 混合折线图
                $chart->add($def)
                    ->composite(
                        Line::make()
                            ->add('L1', [8, 15, 6, 10, 6])
                            ->add('L2', [4, 11, 8, 12, 10])
                    );
                break;
            case 2: // 随机数据
                $random = function () {
                    return Collection::times(5, function () {
                        return mt_rand(1, 28);
                    });
                };

                $chart->add([
                    ['离心', $random()], ['阿翡', $random()],
                ]);
                break;
            default: // 默认效果
                $chart->add($def);
        }

        return $chart->toJsonResponse();
    }

    /**
     * @param $title
     * @param $content
     * @return Box
     */
    protected function box(string $title, $content, string $class = '')
    {
        return Box::make($title, $content)->style('default')->setHtmlAttribute('class', $class);
    }
}
