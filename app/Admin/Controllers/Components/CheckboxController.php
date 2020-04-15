<?php

namespace App\Admin\Controllers\Components;

use App\Admin\Controllers\PreviewCode;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Widgets\Card;
use Dcat\Admin\Widgets\Checkbox;
use Dcat\Admin\Widgets\Radio;
use Illuminate\Routing\Controller;

class CheckboxController extends Controller
{
    use PreviewCode;

    protected $colors = [
        'Default',
        'Primary',
        'Success',
        'Info',
        'Danger',
        'Purple',
        'Inverse',
    ];

    protected function block1()
    {
        $checkbox = Checkbox::make('la1[]', $this->colors)
            ->inline()
            ->check([0, 5])
            ->render();

        $radio = Radio::make('la1', $this->colors)
            ->inline()
            ->check(0)
            ->render();

        return Card::make('Block1', $checkbox . $this->newline() . $radio);
    }

    protected function block2()
    {
        $checkbox1 = Checkbox::make('__', [1 => 'Square1', 2 => 'Square2'])
            ->inline()
            ->checkAll()
            ->render();
        $checkbox2 = Checkbox::make('__', [1 => 'Disabled'])
            ->inline()
            ->checkAll()
            ->disable()
            ->render();
        $radio1 = Radio::make('__1', [1 => 'Disabled'])
            ->inline()
            ->check(1)
            ->disable()
            ->render();

        $colors = collect($this->colors)->map(function ($color) {
            return Checkbox::make('n', compact('color'))
                ->style(strtolower($color))
                ->inline()
                ->checkAll()
                ->render();
        })->join('');

        $radios = collect($this->colors)->map(function ($color, $k) {
            return Radio::make('n'.$k, compact('color'))
                ->style(strtolower($color))
                ->check(0)
                ->inline()
                ->render();
        })->join('');

        return Card::make(
            'Block2',
            $checkbox1.$this->newline().$checkbox2.'&nbsp;&nbsp;'.$radio1. $this->newline().$colors.$this->newline().$radios
        );
    }

    protected function block3()
    {
        $checkbox = Checkbox::make('la[]', $this->colors)
            ->checkAll([1, 4])
            ->render();

        $radio = Radio::make('la', $this->colors)
            ->check(0)
            ->render();

        return Card::make('Block3', $checkbox . '<div style="height:15px"></div>' . $radio);
    }

    /**
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        $header = 'Checkbox & Radio';

        return $content
            ->header($header)
            ->breadcrumb($header)
            ->row($this->buildPreviewButton())
            ->row($this->newline())
            ->row($this->block1())
            ->row($this->block2())
            ->row($this->block3());
    }
}

