<?php

namespace App\Admin\Controllers\Components;

use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Widgets\Box;
use Dcat\Admin\Widgets\Code;
use Dcat\Admin\Widgets\Dropdown;
use Dcat\Admin\Widgets\Navbar;
use Dcat\Admin\Widgets\NavList;
use Faker\Factory;
use Illuminate\Routing\Controller;

class NavbarController extends Controller
{
    public function index(Content $content)
    {
        return $content->header('Navbar')
            ->body(function (Row $row) {
                $values = ['a' => 'text1' , 'b' => 'text2', 'c' => 'text3', 'd' => 'text4', ['github', 'https://www.github.com']];

                $row->column(3, Box::make('# NAVLIST', function () use (&$values) {
                    $nav = NavList::make($values)
                        ->checked('a')
                        ->click()
                        ->map(function ($v) {
                            $tpl = '<a style="font-weight:bold;color:var(--80)" href="%s" target="%s">%s</a>';

                            if (is_array($v)) {
                                list($text, $url) = $v;

                                return sprintf($tpl, $url, '_blank', $text);
                            }

                            return sprintf($tpl, 'javascript:void(0)', '_self', $v);
                        });

                    return $nav;
                })->padding(0)->style('default'));

                $navbar = Navbar::make('# Navbar', $values)
                    ->checked('a')
                    ->click()
                    ->map(function ($v) {
                        if (is_array($v)) {
                            list($text, $url) = $v;

                            return "<li><a href='$url' target='_blank'>$text</a></li>";
                        }

                        return $v;
                    })
                    ->dropdown(null, ['dropdown1', 'dropdown2', 'dropdown3',], function (Dropdown $Dropdown) {
                        $Dropdown->click();
                    });

                $row->column(4, $navbar);

            })
            ->body(Box::make('代码', new Code(__FILE__, 17, 63))->style('default'));
    }
}
