<?php

namespace App\Admin\Controllers\Components;

use App\Admin\Controllers\PreviewCode;
use Dcat\Admin\Admin;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Widgets\Box;
use Dcat\Admin\Widgets\Card;
use Dcat\Admin\Widgets\Code;
use Dcat\Admin\Widgets\Dropdown;
use Illuminate\Routing\Controller;

class LoadingController extends Controller
{
    use PreviewCode;

    protected $colorMap = [
        'Green'   => '#a9cf82',
        'Purple'  => '#919bd2',
        'Red'     => '#ff8e8e',
    ];

    protected $options = [
        'Default',
        'Green',
        'Purple',
        'Red',
        Dropdown::DIVIDER,
        'Transparent',
    ];

    public function index(Content $content)
    {
        $content->row($this->buildPreviewButton().$this->newline());
        $content->row(function (Row $row) {

            $card = Card::make('Loading', function () {
                return <<<HTML
<div class="mb-1">
     开启loading效果: &nbsp;<code>$('#loadingtest').loading();</code>
</div>
<div class="mb-1">
     销毁: &nbsp;<code>$('#loadingtest').loading(false);</code>
</div>

<hr>

<div  class="mb-1">
     全屏居中: &nbsp;<code>Dcat.loading();</code>
</div>
<div class="mb-1">
     销毁: &nbsp;<code>Dcat.loading(false);</code>
</div>

<hr>

<div class="mb-1">
     按钮loading效果: &nbsp;<code>$('.btn').buttonLoading();</code>
</div>
<div class="mb-1">
     销毁: &nbsp;<code>$('.btn').buttonLoading(false);</code>
</div>
HTML;
            })
                ->id('loadingtest')
                ->tool($this->buildDropdown())
                ->tool('<a class="btn btn-light btn-sm shadow-0" onclick="Dcat.loading();setTimeout(function () { Dcat.loading(false); }, 2000)">Auto Center</a>');

            Admin::script(
                <<<JS
function loading_test(opt) {
    // 开始loading效果
    $('#loadingtest').loading(opt);
    
    setTimeout(function () { // 1.2秒后自动移除loading效果
        $('#loadingtest').loading(false);
    }, 2000);
}
loading_test();

// 点击按钮开启loading效果
$('.start_loading').click(function () {
    loading_test($(this).data());
});

$('.loading-1,.loading-2').click(function() {
    var _this = $(this);
    _this.buttonLoading();
  
    setTimeout(function() {
        _this.buttonLoading(false);
    }, 2500);
});

JS
            );

            $row->column(4, $card);

            $row->column(4, <<<HTML
<div class="mb-1">
    <span onclick="Dcat.NP.start()" class="btn btn-primary"> NProgress Start</span> &nbsp; <span onclick="Dcat.NP.done()" class="btn btn-success"> Done </span>
</div>

<br class="mb-2">

<div>
<span class="btn btn-primary loading-1"> 按钮loading效果1</span> &nbsp;&nbsp; <a href="#" class="loading-2" onclick="Dcat.NP.done()" > 按钮loading效果2 </a> 
</div>
HTML
);
        });

        return $content->header('Loading');
    }

    /**
     * 创建下拉菜单
     *
     * @return Dropdown
     */
    protected function buildDropdown()
    {
        $map = $this->colorMap;

        return Dropdown::make($this->options)
            ->click()
            ->buttonClass('btn btn-sm btn-light shadow-0')
            ->map(function ($label) use ($map) {
                if ($label === 'Transparent') {
                    return "<a data-background='rgba(255,255,255,.4)' data-color='var(--primary)' class='start_loading' href='javascript:void(0)'>$label</a>";
                }

                $color = isset($map[$label]) ? "data-color='{$map[$label]}'" : '';

                return "<a {$color} class='start_loading' href='javascript:void(0)'>$label</a>";
            });
    }
}
