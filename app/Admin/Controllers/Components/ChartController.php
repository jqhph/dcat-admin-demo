<?php

namespace App\Admin\Controllers\Components;

use App\Admin\Controllers\PreviewCode;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Widgets\Box;
use Illuminate\Routing\Controller;

class ChartController extends Controller
{
    use PreviewCode;

    public function index(Content $content)
    {
        return $content->header('Charts')
            ->description("See <a href='https://www.chartjs.org' target='_blank'>https://www.chartjs.org</a>.")
            ->body($this->buildPreviewButton().$this->newline())
            ->body(function (Row $row) {
            })
            ->body($this->newline())
            ->body(function (Row $row) {
            })
            ->body($this->newline())
            ->body(function (Row $row) {

            });
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
