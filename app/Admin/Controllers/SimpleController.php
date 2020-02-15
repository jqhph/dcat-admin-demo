<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Widgets\Alert;
use Dcat\Admin\Widgets\Box;
use Dcat\Admin\Widgets\Form;
use Dcat\Admin\Widgets\Markdown;
use Illuminate\Contracts\Support\Renderable;

class SimpleController extends Controller
{
    use PreviewCode;

    public function index(Content $content)
    {
        $description = '<code>Content::simple</code> 接口用于构建一个没有菜单栏以及顶部导航栏的页面，常用于<b>iframe弹窗</b>。';

        $alert = Alert::make($description, '说明')->info();

        return $content->header('Simple Page')
            ->row($alert)
            ->row($this->newline())
            ->row(function (Row $row) {
                $form = new Form();

                $form->disableResetButton();
                $form->disableSubmitButton();

                $form->selectResource('user')
                    ->path('auth/users')
                    ->multiple(3)
                    ->width(9);

                $row->column(4, $form);
            })
            ->row($this->newline())
            ->row(Box::make('代码', $this->markdown())->style('default'));
    }

    protected function markdown()
    {
        $text = <<<'CODE'
>表单构建部分代码如下：

```php
public function index(Content $content)
{
    $description = '<code>Content::simple</code> 接口用于构建一个没有菜单栏以及顶部导航栏的页面，常用于<b>iframe弹窗</b>。';

    $alert = Alert::make($description, '说明')->info();

    return $content->header('Simple Page')
        ->row($alert)
        ->row($this->newline())
        ->row(function (Row $row) {
            $form = new Form();

            $form->disableResetButton();
            $form->disableSubmitButton();

            $form->selectResource('user')
                ->path('auth/users')
                ->multiple(3)
                ->setWidth(9);

            $row->column(4, $form);
        })
        ->row($this->newline())
        ->row(Box::make('代码', $this->markdown())->style('default'));
}
```        
        
        
>Iframe弹窗页面控制器代码如下：        
        
```php
/**
 * Index interface.
 *
 * @return Content
 */
public function index(Content $content)
{
    if (request('_mini')) {
        // 构建一个没有菜单栏和顶部导航栏的页面
        // 此处无需手动调用 "Content::simple" 方法，因为 "MiniGrid" 对象初始化时会自动调用 "Content::simple" 方法
        return $content->body($this->miniGrid());
    }

    ...
}

protected function miniGrid()
{
    $grid = new MiniGrid(new Administrator());

    $grid->id->sortable();
    $grid->username;
    $grid->name;

    $grid->filter(function (Grid\Filter $filter) {
        $filter->equal('id');
        $filter->like('username');
        $filter->like('name');
    });

    return $grid;
}
```
CODE;

        return Markdown::make($text);
    }
}
