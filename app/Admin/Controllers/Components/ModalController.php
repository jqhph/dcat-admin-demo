<?php

namespace App\Admin\Controllers\Components;

use App\Admin\Controllers\PreviewCode;
use App\Admin\Forms\UserProfile;
use App\Admin\Renderable\BarChart;
use App\Admin\Renderable\ModalForm;
use App\Admin\Renderable\UserTable;
use Dcat\Admin\Admin;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Widgets\Modal;
use Dcat\Admin\Widgets\Table;
use Illuminate\Routing\Controller;
use Illuminate\Support\Arr;

class ModalController extends Controller
{
    use PreviewCode;

    public function index(Content $content)
    {
        return $content
            ->header('Modal')
            ->description('模态窗')
            ->body($this->render());
    }

    // 普通非异步弹窗
    protected function modal1()
    {
        return Modal::make()
            ->lg()
            ->title('弹窗')
            ->body($this->table())
            ->button('<button class="btn btn-white"><i class="feather icon-grid"></i> 普通弹窗</button>');
    }

    // 异步加载弹窗内容
    protected function modal2()
    {
        return Modal::make()
            ->lg()
            ->delay(300) // loading 效果延迟时间设置长一些，否则图表可能显示不出来
            ->title('异步加载 - 图表')
            ->body(BarChart::make())
            ->button('<button class="btn btn-white"><i class="feather icon-bar-chart-2"></i> 异步加载</button>');
    }

    // 异步加载弹窗内容
    protected function modal3()
    {
        return Modal::make()
            ->lg()
            ->title('异步加载 - 表单')
            ->body(UserProfile::make())
            ->button('<button class="btn btn-white btn-outline"><i class="feather icon-edit"></i> 异步加载</button>');
    }

    // 异步加载表格
    protected function modal4()
    {
        return Modal::make()
            ->lg()
            ->title('异步加载 - 表格')
            ->body(UserTable::make())
            ->button('<button class="btn btn-white "><i class="feather icon-grid"></i> 异步加载</button>');
    }

    protected function render()
    {
        return <<<HTML
{$this->buildPreviewButton('btn-primary btn-outline')}
&nbsp;&nbsp;
<div class="btn-group">
{$this->modal2()}
{$this->modal3()}
{$this->modal4()}
</div>
&nbsp;
{$this->modal1()}

HTML;
    }

    protected function table()
    {
        Admin::style('.table td{padding: .85rem .55rem}');

        $data = [
            ['name' => 'PHP version',       'value' => 'PHP/'.PHP_VERSION],
            ['name' => 'Laravel version',   'value' => app()->version()],
            ['name' => 'CGI',               'value' => php_sapi_name()],
            ['name' => 'Uname',             'value' => php_uname()],
            ['name' => 'Server',            'value' => Arr::get($_SERVER, 'SERVER_SOFTWARE')],
            ['name' => 'Cache driver',      'value' => config('cache.default')],
            ['name' => 'Session driver',    'value' => config('session.driver')],
        ];

        return Table::make(['name', 'value'], $data);
    }
}
