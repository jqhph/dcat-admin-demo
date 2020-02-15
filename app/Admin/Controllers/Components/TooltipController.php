<?php

namespace App\Admin\Controllers\Components;

use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Widgets\Box;
use Dcat\Admin\Widgets\Code;
use Dcat\Admin\Widgets\Tooltip;
use Illuminate\Routing\Controller;

class TooltipController extends Controller
{
    public function index(Content $content)
    {
        $header = 'Tooltip';
        $text = 'Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. ';

        Tooltip::make('.tt-left')
            ->left()
            ->content($text)
            ->render();

        Tooltip::make('.tt-right')
            ->green()
            ->right()
            ->content($text)
            ->render();

        Tooltip::make('.tt-top')
            ->purple()
            ->top()
            ->content($text)
            ->render();

        Tooltip::make('.tt-bottom')
            ->red()
            ->bottom()
            ->content($text)
            ->render();

        return $content
            ->header($header)
            ->body(function (Row $row) {
                $html = <<<'HTML'
<div class="card-padding" style="margin:60px 200px;">
    <div>
        <a class="tt-left btn-default btn btn-sm"><i class="fa fa-info-circle"></i> &nbsp;Left</a> &nbsp;&nbsp;&nbsp;
        <a class="tt-right btn-default btn btn-sm"><i class="fa fa-info-circle"></i> &nbsp;Right</a> &nbsp;&nbsp;&nbsp;
        <a class="tt-top btn-default btn btn-sm"><i class="fa fa-info-circle"></i> &nbsp;Top</a> &nbsp;&nbsp;&nbsp;
        <a class="tt-bottom btn-default btn btn-sm"><i class="fa fa-info-circle"></i> &nbsp;Bottom</a> &nbsp;&nbsp;&nbsp;
    </div>
</div>
HTML;

                $row->column(12, $html);
            })
            ->body(Box::make('代码', Code::make(__FILE__, 14, 65)));
    }
}
