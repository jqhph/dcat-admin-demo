<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Dcat\Admin\Admin;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Http\Repositories\Permission;
use Illuminate\Support\Str;

class GridTreeController extends Controller
{
    use PreviewCode;

    public function index(Content $content)
    {
        Admin::style('.tab-content .da-box{margin-bottom:0}');

        return $content
            ->header('树形表格')
            ->description('支持无限极分页加载')
            ->body($this->grid());
    }

    protected function grid()
    {
        $grid = new Grid(new Permission());

        $grid->column('id')->bold()->sortable();
        $grid->column('name')->tree();
        $grid->column('order')->orderable();
        $grid->column('slug')->label('primary');

        $grid->column('http_path')->display(function ($path) {
            if (! $path) {
                return;
            }

            $method = $this->http_method ?: ['ANY'];
            $method = collect($method)->map(function ($name) {
                    return strtoupper($name);
                })->map(function ($name) {
                    return "<span class='label label-primary'>{$name}</span>";
                })->implode('&nbsp;').'&nbsp;';

            return collect($path)->filter()->map(function ($path) use ($method) {
                if (Str::contains($path, ':')) {
                    [$method, $path] = explode(':', $path);
                    $method = collect(explode(',', $method))->map(function ($name) {
                            return strtoupper($name);
                        })->map(function ($name) {
                            return "<span class='label label-primary'>{$name}</span>";
                        })->implode('&nbsp;').'&nbsp;';
                }

                if (! empty(config('admin.route.prefix'))) {
                    $path = admin_base_path($path);
                }

                return "<div style='margin-bottom: 5px;'>$method<code>$path</code></div>";
            })->implode('');
        });

        $grid->column('created_at');
        $grid->column('updated_at')->sortable();

        $grid->setResource('auth/permissions');
        $grid->disableEditButton();
        $grid->showQuickEditButton();
        $grid->enableDialogCreate();
        $grid->disableBatchDelete();
        $grid->disableViewButton();

        $grid->tools($this->buildPreviewButton());

        $grid->filter(function (Grid\Filter $filter) {
            $filter->like('slug');
            $filter->like('name');
            $filter->like('http_path');
        });

        return $grid;
    }
}
