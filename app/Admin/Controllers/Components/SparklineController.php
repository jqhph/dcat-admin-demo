<?php

namespace App\Admin\Controllers\Components;

use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Widgets\Alert;
use Dcat\Admin\Widgets\Box;
use Dcat\Admin\Widgets\Code;
use Faker\Factory;
use Illuminate\Routing\Controller;

class SparklineController extends Controller
{
    public function index(Content $content)
    {
        return $content->header('Sparkline')
            ->body(
                Box::make('代码', new Code(__FILE__, 15, 35))
                    ->style('default')
            );
    }
}
