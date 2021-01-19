<?php

namespace App\Admin\Controllers\Components;

use Dcat\Admin\Admin;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Widgets\Box;
use Dcat\Admin\Widgets\Code;
use Dcat\Admin\Widgets\Dropdown;
use Illuminate\Routing\Controller;

class DropdownMenuController extends Controller
{
    protected $tian = ['甲', '乙', '丙', '丁', '戊', '己'];
    protected $di = ['寅', '卯', '辰', '巳', '午', '未', '申'];

    public function index(Content $content)
    {
        return $content->header('Dropdown Menu')
            ->body(function (Row $row) {
                $row->column(3, $this->example1());
                $row->column(3, $this->example2());
                $row->column(3, $this->example3());
            })
            ->body(
                Box::make('代码', new Code(__FILE__, 1, 1000))
                    ->style('default')
            );
    }

    protected function example1()
    {
        $menu1 = Dropdown::make($this->tian)->button('天干');

        $menu2 = Dropdown::make()
            ->button('使用标题')
            ->buttonClass('btn btn-sm btn-inverse')
            ->options($this->tian, '天干')
            ->options($this->di, '地支');

        $menu3 = Dropdown::make([1, 2, 3, Dropdown::DIVIDER, 4, 5])->button('中间加分隔线');

        return Box::make(
            'Example1',
            $menu1->render().' &nbsp; '.$menu2->render().' &nbsp; '.$menu3->render()
        );
    }

    protected function example2()
    {
        $menu = Dropdown::make($this->tian);

        $menu->map(function ($v, $k) {
            if ($k === 7) {
                $this->divider();
            }
            $k++;
            return "{$k}. $v";
        });

        return Box::make('Example2', function () use ($menu) {
            return "<div class='dropdown'><a class='btn no-shadow text-muted' data-toggle='dropdown' href='javascript:void(0)'><i class='ti-email'></i> 自定义按钮 </a>{$menu->render()}</div>";
        });
    }

    protected function example3()
    {
        $menu1 = Dropdown::make()
            ->options($this->tian, '天干')
            ->options($this->di, '地支')
            ->click()
            ->buttonClass('btn btn-sm btn-light')
            ->map(function ($v, $k) {
                $k++;

                return "<a class='test_item' data-id='$k', data-value='{$v}' data-test='Hello world.' href='javascript:void(0)'>{$k}. $v</a>";
            });

        Admin::script(
            <<<JS
$('.test_item').click(function () {
    Dcat.success("Selected: " + JSON.stringify($(this).data()));
});
JS
        );

        return Box::make('Example3', $menu1);
    }
}
