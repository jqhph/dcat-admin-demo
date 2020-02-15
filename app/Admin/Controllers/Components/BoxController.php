<?php

namespace App\Admin\Controllers\Components;

use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Widgets\Box;
use Dcat\Admin\Widgets\Card;
use Dcat\Admin\Widgets\Code;
use Faker\Factory;
use Illuminate\Routing\Controller;

class BoxController extends Controller
{
    public function index(Content $content)
    {
        $faker = Factory::create();

        $content->row(Card::make('Card', $faker->text(500))->tool('<a class=\'btn btn-primary btn-sm\'>primary</a>&nbsp;'));

        $content->row(function (Row $row) use ($faker) {
            $row->column(6, Box::make('Default', $faker->text(200))->style('default')->collapsable()->removable());
            $row->column(6, Box::make('Success', $faker->text(200))->style('success'));
            $row->column(6, Box::make('Info', $faker->text(200))->style('info')->collapsable());
            $row->column(6, Box::make('Danger', $faker->text(200))->style('danger')->collapsable());
            $row->column(12, Box::make('代码', Code::make(__FILE__, 15, 38))->style('primary')->collapsable());
        });

        $header = 'Card & Box';
        $content->breadcrumb('Components');
        $content->breadcrumb($header);

        return $content->header($header);
    }
}
