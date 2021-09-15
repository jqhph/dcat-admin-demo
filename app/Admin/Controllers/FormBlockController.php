<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\NullRepository;
use Dcat\Admin\Form;
use Dcat\Admin\Layout\Content;

class FormBlockController
{
    use PreviewCode;

    public function create(Content $content)
    {
        return $content
            ->title('表单Block布局')
            ->description('创建')
            ->body($this->buildPreviewButton())
            ->body($this->newline())
            ->body($this->form());
    }

    protected function form()
    {
        return Form::make(new NullRepository(), function (Form $form) {
            $form->block(8, function (Form\BlockForm $form) {
                // 设置标题
                $form->title('基本设置');

                // 显示底部提交按钮
                $form->showFooter();

                // 设置字段宽度
                $form->width(9, 2);

                $form->column(6, function (Form\BlockForm $form) {
                    $form->display('id');
                    $form->text('name');
                    $form->email('email');
                    $form->image('avatar');
                    $form->password('password');
                });

                $form->column(6, function (Form\BlockForm $form) {
                    $form->text('username');
                    $form->email('mobile');
                    $form->textarea('description');
                });
            });
            $form->block(4, function (Form\BlockForm $form) {
                $form->title('分块2');

                $form->text('nickname');
                $form->number('age');
                $form->radio('status')->options(['1' => '默认', 2 => '冻结'])->default(1);

                $form->next(function (Form\BlockForm $form) {
                    $form->title('分块3');

                    $form->date('birthday');
                    $form->date('created_at');
                });
            });
        });
    }
}
