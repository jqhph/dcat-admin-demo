<?php

namespace App\Admin\Controllers\Components;

use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Widgets\Box;
use Dcat\Admin\Widgets\Code;
use Dcat\Admin\Widgets\Tab;
use Faker\Factory;
use Illuminate\Routing\Controller;

class TabController extends Controller
{
    public function index(Content $content)
    {
        $header = 'Tab & Button';

        $faker = Factory::create();

        return $content->header($header)
            ->breadcrumb('Components')
            ->breadcrumb($header)
            ->body(function (Row $row) use ($faker) {
                $tab = new Tab();

                $isLink = request('link') ? true : false;

                if (!$isLink) {
                    $tab->add('Buttons', $this->buttons());
                    $tab->addLink('Link', request()->fullUrlWithQuery(['link' => 1]));
                } else {
                    $tab->addLink('Button', request()->fullUrlWithQuery(['link' => 0]));
                    $tab->add('Link', "<div style='padding:15px'> <p>{$faker->text(300)}</p>  <p>{$faker->text(200)}</p></div>", true);
                }

                $row->column(12, $tab);
            })
            ->body(function (Row $row) use ($faker) {
                $tab = new Tab();

                $tab->custom();
                $tab->add('Code', new Code(__FILE__, 15, 53));
                $tab->add('Custom2', "<p>{$faker->text(200)}</p><p>{$faker->text(200)}</p>");
                $tab->add('Custom3', "<p>{$faker->text(200)}</p><p>{$faker->text(200)}</p>");

                $row->column(12, $tab);
            });
    }

    protected function buttons()
    {
        return "
<p> 
    <div class='pull-left'>
    <a class='btn btn-default'>btn-default</a> &nbsp;&nbsp;
    </div>
    <div class='btn-group default pull-left'>
        <a class='btn btn-default'>btn-group</a>
        <a class='btn btn-default'>btn-default</a>
    </div>
 
    <div class='btn-group default no-shadow pull-left' style='margin-left:12px'>
        <a class='btn btn-light'>btn-group</a>
        <a class='btn btn-light'>btn-light</a>
    </div>
    
    <div class='btn-group no-shadow' style='margin-left:12px'>
        <a class='btn btn-primary no-shadow'> btn-primary </a><a class='btn btn-primary no-shadow'> no-shadow </a>&nbsp;&nbsp;
    </div>
</p>
 
<div class='clearfix'></div>
<div  style='margin-top:15px'>
    <a class='btn btn-primary  '> btn-primary </a>&nbsp;&nbsp;
    <a class='btn btn-info  '> btn-info </a>&nbsp;
    <a class='btn btn-custom  '> btn-custom </a>&nbsp;&nbsp;
     <a class='btn btn-success  '> btn-success </a>&nbsp;&nbsp;
      <a class='btn btn-warning  '> btn-warning </a>&nbsp;&nbsp;
    <a class='btn btn-danger  '> btn-danger </a>&nbsp;&nbsp;
    <a class='btn btn-purple  '> btn-purple </a>&nbsp;&nbsp;
      <a class='btn btn-tear  '> btn-tear </a>&nbsp;&nbsp;
    <a class='btn btn-pink  '> btn-pink </a>&nbsp;&nbsp;
    <a class='btn btn-inverse  '> btn-inverse </a>&nbsp;&nbsp;
    
     <a class='btn btn-blue  '> btn-blue </a>&nbsp;&nbsp;
      <a class='btn btn-facebook '> btn-facebook </a>&nbsp;&nbsp;
      <a class='btn btn-instagram '> btn-instagram </a>&nbsp;&nbsp;
</div>

 <br >
<div class='clearfix'></div>

<div >
    <a class='btn btn-primary btn-circle '><i class='ti-check'></i></a>&nbsp;&nbsp;
     <a class='btn btn-default btn-lg btn-circle '><i class='ti-plus'></i></a>&nbsp;&nbsp;
    <a class='btn btn-success btn-lg btn-circle '><i class='ti-plus'></i></a>&nbsp;&nbsp;
     <a class='btn btn-purple btn-lg btn-circle '><i class='ti-check'></i></a>&nbsp;&nbsp;
     <a class='btn btn-danger btn-lg btn-circle '><i class='fa fa-heart'></i></a>
</div>
<div  style='margin-top:15px'>
    <a class='btn btn-light btn-circle'><i class='ti-check'></i></a>&nbsp;&nbsp;
     <a class='btn btn-light btn-lg btn-circle '><i class='ti-plus'></i></a>&nbsp;&nbsp;
     <a class='btn btn-light btn-lg btn-circle '><i class='ti-pencil-alt text-primary'></i></a>&nbsp;&nbsp;
    <a class='btn btn-light btn-lg btn-circle '><i class='ti-trash text-danger'></i></a>&nbsp;&nbsp;
     <a class='btn btn-light btn-lg btn-circle '><i class='fa fa-heart text-purple'></i></a>
</div>

 <br >
<div class='clearfix'></div>

<p>
<a class='btn btn-default btn-trans '>btn-default</a>&nbsp;&nbsp;
    <a class='btn btn-primary btn-trans '>btn-primary</a>&nbsp;&nbsp;
    <a class='btn btn-info btn-trans '>btn-info</a>&nbsp;&nbsp;
     <a class='btn btn-success btn-trans '>btn-success</a>&nbsp;&nbsp;
      <a class='btn btn-warning btn-trans  '>btn-warning</a>&nbsp;&nbsp;
    <a class='btn btn-danger btn-trans '>btn-danger</a>&nbsp;&nbsp;
    <a class='btn btn-purple btn-trans  '>btn-purple</a>&nbsp;&nbsp;
    <a class='btn btn-pink btn-trans '>btn-pink</a>&nbsp;&nbsp;
    
     <a class='btn btn-custom btn-trans'> btn-custom </a>&nbsp;&nbsp;
    <a class='btn btn-blue btn-trans'> btn-blue </a>&nbsp;&nbsp;
</p>
      ";
    }
}
