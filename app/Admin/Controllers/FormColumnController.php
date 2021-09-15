<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\NullRepository;
use Dcat\Admin\Form;
use Dcat\Admin\Layout\Content;

class FormColumnController
{
    use PreviewCode;

    public function create(Content $content)
    {
        return $content
            ->title('表单Column布局')
            ->description('创建')
            ->body($this->buildPreviewButton())
            ->body($this->newline())
            ->body($this->form());
    }

    protected function form()
    {
        return Form::make(new NullRepository(), function (Form $form) {
            $form->disableListButton();

            // 第一列占据1/2的页面宽度
            $form->column(6, function (Form $form) {
                $form->text('name')->required();
                $form->date('born')->required();
                $form->select('education')->options([])->required();
                $form->text('nation')->required();
                $form->text('native')->required();
                $form->text('job')->required();
                $form->text('code')->required();
                $form->text('phone')->required();
                $form->text('work')->required();
                $form->text('census')->required();
            });

            // 第二列占据1/2的页面宽度
            $form->column(6, function (Form $form) {
                $form->image('avatar');
                $form->decimal('wages');
                $form->decimal('fund');
                $form->decimal('pension');
                $form->decimal('fee');
                $form->decimal('business');
                $form->decimal('other');
                $form->text('area')->default(0);
                $form->textarea('illness');
                $form->textarea('comment');
            });
        });
    }
}
