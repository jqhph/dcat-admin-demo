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

class FullPageController extends Controller
{
    use PreviewCode;

    public function index(Content $content)
    {
        $description = '<code>Content::full</code> 接口用于构建一个没有菜单栏以及顶部导航栏的页面，常用于<b>iframe弹窗</b>。';

        $alert = Alert::make($description, '说明')->info();

        return $content->header('Full Page')
            ->row($alert)
            ->row($this->newline())
            ->row(function (Row $row) {
                $form = new Form();

                $form->disableResetButton();
                $form->disableSubmitButton();


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
    $description = '<code>Content::full</code> 接口用于构建一个没有菜单栏以及顶部导航栏的页面，常用于<b>iframe弹窗</b>。';

    $alert = Alert::make($description, '说明')->info();

    return $content->header('Simple Page')
        ->row($alert)
        ->row($this->newline())
        ->row(function (Row $row) {
            $form = new Form();

            $form->disableResetButton();
            $form->disableSubmitButton();

            $form->selectResource('user')
                ->path('users')
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
class UserController
{
    public function index(Content $content)
    {
        return $content->full()->body($this->grid());
    }

    protected function grid()
    {
        return Grid::make(new Administrator(), function (Grid $grid) {
            $grid->column('id', 'ID')->sortable();
            $grid->column('username');
            $grid->column('name');
            $grid->column('created_at');

            $grid->quickSearch(['id', 'username', 'name']);
        });
    }
}
```
CODE;

        return Markdown::make($text);
    }
}
