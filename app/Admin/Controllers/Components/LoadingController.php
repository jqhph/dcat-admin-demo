<?php

namespace App\Admin\Controllers\Components;

use App\Admin\Controllers\PreviewCode;
use Dcat\Admin\Admin;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Widgets\Box;
use Dcat\Admin\Widgets\Card;
use Dcat\Admin\Widgets\Code;
use Dcat\Admin\Widgets\DropdownMenu;
use Illuminate\Routing\Controller;

class LoadingController extends Controller
{
    use PreviewCode;

    protected $colorMap = [
        'Default' => 'var(--primary-60)',
        'Green'   => '#a9cf82',
        'Purple'  => '#919bd2',
        'Red'     => '#ff8e8e',
        'Gray'    => 'var(--60)',
    ];

    protected $options = [
        'Default',
        'Green',
        'Purple',
        'Red',
        'Gray',
        DropdownMenu::DIVIDER,
        'Transparent',
    ];

    public function index(Content $content)
    {
        $content->row($this->buildPreviewButton().$this->newline());
        $content->row(function (Row $row) {

            $card = Card::make('Loading', function () {
                return <<<HTML
<div >
     开启loading效果: &nbsp;<code>$('#loadingtest').loading();</code>
</div>
<div class="m-b-15">
     销毁: &nbsp;<code>$('#loadingtest').loading(false);</code>
</div>

<div >
     全屏居中: &nbsp;<code>LA.loading();</code>
</div>
<div >
     销毁: &nbsp;<code>LA.loading(false);</code>
</div>
HTML;
            })
                ->id('loadingtest')
                ->tool($this->buildDropdownMenu())
                ->tool('<a class="btn btn-light btn-sm" onclick="LA.loading();setTimeout(function () { LA.loading(false); }, 2000)">Auto Center</a>');

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
JS
            );

            $row->column(4, $card);

            $row->column(4, <<<HTML
<span onclick="LA.NP.start()" class="btn btn-primary"> NProgress Start</span> &nbsp; <span onclick="LA.NP.done()" class="btn btn-success"> Done </span>
HTML
);
        });

        return $content->header('Loading');
    }

    /**
     * 创建下拉菜单
     *
     * @return DropdownMenu
     */
    protected function buildDropdownMenu()
    {
        $map = $this->colorMap;

        return DropdownMenu::make($this->options)
            ->click()
            ->buttonClass('btn btn-sm btn-light')
            ->map(function ($label) use ($map) {
                if ($label === 'Transparent') {
                    return "<a data-bg='rgba(255,255,255,.4)' data-color='var(--primary)' class='start_loading' href='javascript:void(0)'>$label</a>";
                }

                return "<a data-color='{$map[$label]}' class='start_loading' href='javascript:void(0)'>$label</a>";
            });

    }


}
