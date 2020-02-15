<?php

namespace App\Admin\Controllers\Components;

use App\Admin\Controllers\PreviewCode;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Widgets\Box;
use Dcat\Admin\Widgets\Color;
use Dcat\Admin\Widgets\Sparkline\Line;
use Illuminate\Routing\Controller;
use Dcat\Admin\Widgets\DataCard;
use Illuminate\Support\Collection;

class DataCardController extends Controller
{
    use PreviewCode;

    protected $routesMap = [
        'default'  => 'fetchDefaultData',
        'line'     => 'fetchLineData',
        'doughnut' => 'fetchDoughnutData',
        'pie'      => 'fetchPieData',
        'polar'    => 'fetchPolarData',
    ];

    public function index(Content $content)
    {
        if (($route = request('card')) && isset($this->routesMap[$route])) {
            // 接口分派
            return $this->{$this->routesMap[$route]}(request('condition'));
        }

        return $content->header('Data Card')
            ->body($this->buildPreviewButton().$this->newline())
            ->body($this->default())
            ->body($this->chartJs())
            ->body($this->line());
    }

    /**
     * 构建默认卡片
     *
     * @return $this
     */
    protected function default()
    {
        $cards[] = DataCard\Card::make()
            ->title('日活用户增长')
            ->description('Revenue today')
            ->content(function () {
                // 数字放在number标签会有计数动画效果
                return "<number>273</number> <small>/ 1243</small>";
            });

        $cards[] = DataCard\Card::make()
            ->title('注册用户增长')
            ->description('Revenue today')
            ->number(mt_rand(0, 499))
            ->progress(32) // 显示进度条
            ->rightContent(function () { // 增加右边内容
                return '<span class="badge bg-primary">32% <i class="ti-stats-up"></i></span>';
            });

        $cards[] = DataCard\Card::make()
            ->title('商品销售额增长')
            ->description('Ajax request')
            ->content(function () { // 这里设置默认值，设置0即可
                return "<number>0</number> <small>/ 0</small>";
            })
            ->progress(0)
            ->requestCurrent(['card' => 'default']) // 设置ajax接口为当前页面链接，用于获取卡片数据并渲染
            ->refetch('.default-card-item') // 这里绑定的是下拉菜单的选项class，当点击下拉菜单选项时会重新请求接口获取数据
            ->dropdown(['今天', '最近30天', '最近3个月', '最近一年'], function ($v, $k) {
                // 工具栏显示下拉菜单
                // 设置 "data" 属性，点击时可以把属性内容当做请求参数发送到接口
                return "<a class='default-card-item' data-condition='$v' href='javascript:void(0)'>{$v}</a>";
            });

        return $this->box('默认卡片', $cards);
    }

    /**
     * 默认卡片数据获取接口
     *
     * @param $condition
     * @return \Illuminate\Http\JsonResponse
     */
    protected function fetchDefaultData($condition)
    {
        switch ($condition) { // 根据接口传递的参数不同可以查询不同的数据
            case '最近30天':
                // TODO
                break;
            case '最近3个月':
                // TODO
                break;
            case '今天': // 第一次进页面（非点击按钮请求接口）时，接口是不附带此参数值的，
            default:    // 所以此处 今天 与 default 放在一起
                // TODO
                break;
        }

        // 返回卡片json数据
        return DataCard\Card::make()
            ->content(function () {
                $v = mt_rand(20, 1259);
                return "<number>$v</number> <small>/ 1259</small>";
            })
            ->progress(mt_rand(2, 100))
            ->toJsonResponse();
    }

    /**
     * chartJs图表卡片
     *
     * @return $this
     */
    protected function chartJs()
    {
        $cards[] = DataCard\DoughnutChartCard::make()
            ->title('日活用户增长')
            ->requestCurrent(['card' => 'doughnut'])
            ->refetch(['.doughnut-card-item', '.dcolor-card-item'])
            ->chart(['广告', '运营']) // 饼状图卡片不论是否是ajax请求都应该先设置 labels
            ->dropdown(['今天', '最近30天', '最近3个月', '最近一年'], function ($v, $k) {
                return "<a class='doughnut-card-item' data-condition='$v' href='javascript:void(0)'>{$v}</a>";
            })
            ->dropdown(array_keys(Color::$chartTheme), function ($v, $k) {
                $label = strtoupper($v);
                return "<a class='dcolor-card-item' data-condition='$v' href='javascript:void(0)'>{$label}</a>";
            }, 'BLUE'); // 再设置一个下拉菜单，并设置按钮默认显示值

        $cards[] = DataCard\PieChartCard::make()
            ->title('注册用户增长')
            ->requestCurrent(['card' => 'pie'])
            ->refetch(['.pie-card-item', '.pcolor-card-item'])
            ->chart(['广告', '运营']) // 饼状图卡片不论是否是ajax请求都应该先设置 labels
            ->dropdown(['今天', '最近30天', '最近3个月', '最近一年'], function ($v, $k) {
                return "<a class='pie-card-item' data-condition='$v' href='javascript:void(0)'>{$v}</a>";
            })
            ->dropdown(array_keys(Color::$chartTheme), function ($v, $k) {
                $label = strtoupper($v);
                return "<a class='pcolor-card-item' data-condition='$v' href='javascript:void(0)'>{$label}</a>";
            }, 'BLUE');

        $cards[] = DataCard\PolarAreaChartCard::make()
            ->title('商品销售额增长')
            ->description('Ajax request')
            ->number(0)
            ->requestCurrent(['card' => 'polar'])
            ->refetch(['.polar-card-item', '.pacolor-card-item'])
            ->chart(['一', '二']) // 饼状图卡片不论是否是ajax请求都应该先设置 labels
            ->dropdown(['今天', '最近30天', '最近3个月', '最近一年'], function ($v, $k) {
                return "<a class='polar-card-item' data-condition='$v' href='javascript:void(0)'>{$v}</a>";
            })
            ->dropdown(array_keys(Color::$chartTheme), function ($v, $k) {
                $label = strtoupper($v);
                return "<a class='pacolor-card-item' data-condition='$v' href='javascript:void(0)'>{$label}</a>";
            }, 'BLUE');

        return $this->box('ChartJs图表卡片 <small>Doughnut、Pie、PolarArea</small>', $cards);
    }

    /**
     * 圆圈形图表卡片数据获取接口
     *
     * @param $condition
     * @return \Illuminate\Http\JsonResponse
     */
    protected function fetchDoughnutData($condition)
    {
        $a = mt_rand(15, 189);
        $b = mt_rand(15, 100);

        $p1 = ceil($a / ($a + $b) * 100);
        $p2 = ceil($b / ($a + $b) * 100);

        $card = DataCard\DoughnutChartCard::make()
            ->dot("广告转化 (<b><number>$a</number></b> - <number>$p1</number>%)")
            ->dot("运营转化 (<number>$b</number> - <number>$p2</number>%)")
            ->chart(null, [mt_rand(0, 88), mt_rand(0, 169)]); // 接口获取数据时第一个参数传 null 即可

        if (isset(Color::$chartTheme[$condition])) {
            $card->$condition();
        }

        return $card->toJsonResponse();
    }

    /**
     * 饼状图表卡片数据获取接口
     *
     * @param $condition
     * @return \Illuminate\Http\JsonResponse
     */
    protected function fetchPieData($condition)
    {
        $a = mt_rand(15, 189);
        $b = mt_rand(15, 100);

        $p1 = ceil($a / ($a + $b) * 100);
        $p2 = ceil($b / ($a + $b) * 100);

        $card = DataCard\PieChartCard::make()
            ->dot("广告转化 (<b><number>$a</number></b> - <number>$p1</number>%)")
            ->dot("运营转化 (<number>$b</number> - <number>$p2</number>%)")
            ->chart(null, [$a, $b]); // 接口获取数据时第一个参数传 null 即可

        if (isset(Color::$chartTheme[$condition])) {
            $card->$condition();
        }

        return $card->toJsonResponse();
    }

    protected function fetchPolarData($condition)
    {
        $card = DataCard\PolarAreaChartCard::make()
            ->content(function () {
                $v = mt_rand(20, 2800);
                return "<number>$v</number> <small>/ 3200</small>";
            })
            ->chart(null, [mt_rand(30, 189), mt_rand(30, 100)]); // 接口获取数据时第一个参数传 null 即可

        if (isset(Color::$chartTheme[$condition])) {
            $card->$condition();
        }

        return $card->toJsonResponse();
    }

    /**
     * 构建折线图卡片
     *
     * @return $this
     */
    protected function line()
    {
        $cards[] = DataCard\LineChartCard::make()
            ->title('日活用户增长')
            ->description('Revenue today')
            ->rightContent('<span class="text-muted">Revenue today</span>')
            ->number(mt_rand(10, 799))
            ->chart($this->buildRandomArray()); // 设置折线图数据

        $cards[] = DataCard\LineChartCard::make()
            ->title('注册用户增长')
            ->description('Revenue today')
            ->number(0)
            ->requestCurrent(['card' => 'line'])
            ->refetch('.line-card-item')
            ->dropdown(['今天', '最近30天', '最近3个月', '最近一年'], function ($v, $k) {
                return "<a class='line-card-item' data-condition='$v' href='javascript:void(0)'>{$v}</a>";
            });

        $cards[] = DataCard\LineChartCard::make()
            ->title('商品销售额增长')
            ->description('Revenue today')
            ->rightContent('<span class="text-muted">Revenue today</span>')
            ->number(mt_rand(10, 799))
            ->chart(function (Line $line) {
                $line->purple(true);
                $line->values($this->buildRandomArray());
            });

        return $this->box('折线图卡片', $cards);
    }

    /**
     * 折线图卡片数据获取接口
     *
     * @param $condition
     * @return \Illuminate\Http\JsonResponse
     */
    protected function fetchLineData($condition)
    {
        return DataCard\LineChartCard::make()
            ->number(mt_rand(10, 799))
            ->chart($this->buildRandomArray()) // 设置折线图数据
            ->toJsonResponse();
    }

    protected function box(string $title, array $cards, string $class = '')
    {
        return Box::make($title, function () use ($cards) {
            $row = new Row();

            foreach ($cards as $card) {
                $row->column(3, $card);
            }

            return $row;
        })->style('default')->setHtmlAttribute('class', $class);
    }

    protected function buildRandomArray()
    {
        return Collection::times(30, function () {
            return mt_rand(1, 9);
        });
    }
}
