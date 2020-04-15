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

                $row->column(12, $tab->withCard());
            })
            ->body(function (Row $row) use ($faker) {
                $tab = new Tab();

                $tab->add('Code', new Code(__FILE__, 15, 53));
                $tab->add('Custom2', "<p>{$faker->text(200)}</p><p>{$faker->text(200)}</p>");
                $tab->add('Custom3', "<p>{$faker->text(200)}</p><p>{$faker->text(200)}</p>");

                $row->column(12, $tab->withCard());
            });
    }

    protected function buttons()
    {
        return "
<p> 
    <div class='pull-left'>
    <button class='btn btn-white'>btn-white</button> &nbsp;&nbsp;
    </div>
    <div class='btn-group default pull-left'>
        <button class='btn btn-white'>btn-group</button>
        <button class='btn btn-white'>btn-white</button>
    </div>
 
    <div class='btn-group default shadow-0 pull-left' style='margin-left:12px'>
        <button class='btn btn-light'>btn-group</button>
        <button class='btn btn-light'>btn-light</button>
    </div>
    
    <div class='btn-group shadow-0' style='margin-left:12px'>
        <button class='btn btn-primary shadow-0'> btn-primary </button><button class='btn btn-primary shadow-0'> shadow-0 </button>&nbsp;&nbsp;
    </div>
</p>
 
<div class='clearfix'></div>
<div  style='margin-top:15px'>
    <button class='btn btn-primary  '> btn-primary </button>&nbsp;&nbsp;
    <button class='btn btn-info  '> btn-info </button>&nbsp;
    <button class='btn btn-custom  '> btn-custom </button>&nbsp;&nbsp;
     <button class='btn btn-success  '> btn-success </button>&nbsp;&nbsp;
      <button class='btn btn-warning  '> btn-warning </button>&nbsp;&nbsp;
    <button class='btn btn-danger  '> btn-danger </button>&nbsp;&nbsp;
      <button class='btn btn-facebook '> btn-facebook </button>&nbsp;&nbsp;
      <button class='btn btn-instagram '> btn-instagram </button>&nbsp;&nbsp;
</div>

 <br >
<div class='clearfix'></div>


 <br >
<div class='clearfix'></div>

<p>
    <button class='btn btn-outline-primary '>btn-primary</button>&nbsp;&nbsp;
    <button class='btn btn-outline-info '>btn-info</button>&nbsp;&nbsp;
     <button class='btn btn-outline-success '>btn-success</button>&nbsp;&nbsp;
      <button class='btn btn-outline-warning  '>btn-warning</button>&nbsp;&nbsp;
    <button class='btn btn-outline-danger '>btn-danger</button>&nbsp;&nbsp;
     <button class='btn btn-outline-custom'> btn-custom </button>&nbsp;&nbsp;
</p>
      ";
    }
}
