<?php

namespace App\Admin\Controllers\Components;

use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Widgets\Box;
use Dcat\Admin\Widgets\Code;
use Dcat\Admin\Widgets\Accordion;
use Faker\Factory;
use Illuminate\Routing\Controller;

class AccordionController extends Controller
{
    public function index(Content $content)
    {
        return $content->header('Accordion')
            ->row(function (Row $row) {
                $faker = Factory::create();

                $collapse = Accordion::make()->style('margin-bottom:0px');

                $collapse->add($faker->name(), $faker->text(200), true);
                $collapse->add($faker->name(), $faker->text(200));
                $collapse->add($faker->name(), $faker->text(200));
                $collapse->add($faker->name(), $faker->text(200));
                $collapse->add($faker->name(), $faker->text(200));

                $row->column(5, Box::make('Accordion', $collapse)->style('default'));

                $collapse = Accordion::make()->style('margin-bottom:0px')->white();

                $collapse->add($faker->name(), $faker->text(200));
                $collapse->add($faker->name(), $faker->text(200));
                $collapse->add($faker->name(), $faker->text(200));
                $collapse->add($faker->name(), $faker->text(200));
                $collapse->add($faker->name(), $faker->text(200));
                $row->column(5, $collapse);
            })
            ->row(Box::make('代码', new Code(__FILE__, 15, 44))->style('default'));

    }
}
