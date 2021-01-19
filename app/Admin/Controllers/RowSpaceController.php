<?php

namespace App\Admin\Controllers;

use Dcat\Admin\Http\Controllers\UserController;

class RowSpaceController extends UserController
{
    use PreviewCode;

    protected $title = '表格行间距模式';

    public function grid()
    {
        return parent::grid()
            ->tableCollapse(false)
            ->tools($this->buildPreviewButton());
    }
}
