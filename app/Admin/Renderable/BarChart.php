<?php

namespace App\Admin\Renderable;

use App\Admin\Widgets\Charts\Bar;
use Dcat\Admin\Support\LazyRenderable;

class BarChart extends LazyRenderable
{
    public function render()
    {
        return Bar::make();
    }
}
