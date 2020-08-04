<?php

namespace App\Admin\Grid\Tools;

use Illuminate\Contracts\Support\Renderable;

class SwitchGridMode implements Renderable
{
    public function render()
    {
        $url = request()->fullUrlWithQuery(['_row_' => 1]);

        return <<<HTML
<a class="btn btn-white" href="$url" style="margin-right: 5px">表格行间距模式</a>
HTML;
    }
}
