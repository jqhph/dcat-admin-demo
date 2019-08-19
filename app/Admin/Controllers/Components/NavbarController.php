<?php

namespace App\Admin\Controllers\Components;

use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Widgets\Box;
use Dcat\Admin\Widgets\Code;
use Dcat\Admin\Widgets\DropdownMenu;
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
                $row->column(3, Box::make('# NAVLIST', function () {
                    $nav = NavList::make(['a' => 'Link1' , 'b' => 'link2', ['github', 'https://www.github.com']])
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

                $navbar = Navbar::make('# Navbar', ['a' => 'Link1' , 'b' => 'link2', ['github', 'https://www.github.com']])
                    ->checked('a')
                    ->click()
                    ->map(function ($v) {
                        if (is_array($v)) {
                            list($text, $url) = $v;

                            return "<li><a href='$url' target='_blank'>$text</a></li>";
                        }

                        return $v;
                    })
                    ->dropdown(null, ['dropdown1', 'dropdown2', 'dropdown3',], function (DropdownMenu $dropdownMenu) {
                        $dropdownMenu->click();
                    });

                $row->column(4, $navbar);

            })
            ->body(Box::make('代码', new Code(__FILE__, 17, 63))->style('default'));
    }



}
