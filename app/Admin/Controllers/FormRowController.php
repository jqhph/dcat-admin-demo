<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\NullRepository;
use Dcat\Admin\Form;
use Dcat\Admin\Layout\Content;

class FormRowController
{
    use PreviewCode;

    public function create(Content $content)
    {
        return $content
            ->title('表单Row布局')
            ->description('创建')
            ->body($this->buildPreviewButton())
            ->body($this->newline())
            ->body($this->form());
    }

    protected function form()
    {
        return Form::make(new NullRepository(), function (Form $form) {
            $form->disableListButton();

            $form->row(function ($form) {
                $form->width(3)->text('name')->required();
                $form->width(3)->date('born')->required();
                $form->width(3)->select('education')->options([])->required();
                $form->width(3)->text('nation')->required();
                $form->width(4)->text('native')->required();
                $form->width(4)->text('job')->required();
                $form->width(4)->text('code')->required();
                $form->width(6)->text('phone')->required();
                $form->width(5)->text('work')->required();
                $form->width(12)->textarea('census')->required();
            });

            $form->row(function ($form) {
                $form->image('avatar');
            });
        });
    }
}
