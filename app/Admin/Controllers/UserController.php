<?php

namespace App\Admin\Controllers;

use Dcat\Admin\Admin;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Models\Repositories\Administrator;

class UserController
{
    public function index(Content $content)
    {
        Admin::style('#app{padding: 1.2rem}');

        return $content->full()->body($this->grid());
    }

    protected function grid()
    {
        return Grid::make(new Administrator(), function (Grid $grid) {
            $grid->column('id', 'ID')->sortable();
            $grid->column('username');
            $grid->column('name');
            $grid->column('created_at');

            $grid->rowSelector()->click();

            $grid->disableActions();
            $grid->disableBatchDelete();
            $grid->disableCreateButton();

            $grid->quickSearch(['id', 'username', 'name']);
        });
    }
}
