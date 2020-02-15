<?php

namespace App\Admin\Controllers\Components;

use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Widgets\Alert;
use Dcat\Admin\Widgets\Box;
use Dcat\Admin\Widgets\Code;
use Faker\Factory;
use Illuminate\Routing\Controller;

class AlertController extends Controller
{
    public function index(Content $content)
    {
        $faker = Factory::create();

        $content->row(Alert::make($faker->text, 'Danger'));
        $content->row(Alert::make($faker->text, 'Warning')->warning());
        $content->row(Alert::make($faker->text, 'Success')->success());
        $content->row(Alert::make($faker->text, 'Info')->info());

        $content->row(Box::make('代码', new Code(__FILE__, 15, 35))->style('default'));

        $header = 'Alert';
        $content->breadcrumb('Components');
        $content->breadcrumb($header);

        return $content->header($header);

    }
}
