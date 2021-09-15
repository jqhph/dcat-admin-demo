<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\NullRepository;
use Dcat\Admin\Form;
use Dcat\Admin\Layout\Content;

class FormTabController
{
    use PreviewCode;

    public function create(Content $content)
    {
        return $content
            ->title('表单Tab布局')
            ->description('创建')
            ->body($this->buildPreviewButton())
            ->body($this->newline())
            ->body($this->form());
    }

    protected function form()
    {
        return Form::make(new NullRepository(), function (Form $form) {
            $form->disableListButton();

            $form->tab('Basic info', function (Form $form) {
                // tab 可以和 column 布局结合
                $form->column(6, function (Form $form) {
                    $form->text('username');
                    $form->email('email');
                    $form->text('nation')->required();
                    $form->text('native')->required();
                    $form->text('job')->required();
                });
                $form->column(6, function (Form $form) {
                    $form->decimal('pension');
                    $form->decimal('fee');
                    $form->decimal('business');
                    $form->decimal('other');
                    $form->text('area')->default(0);
                    $form->textarea('illness');
                });

            })->tab('Profile', function (Form $form) {

                $form->image('avatar');
                $form->text('address');
                $form->mobile('phone');
                $form->text('code')->required();
                $form->text('phone')->required();
                $form->text('work')->required();

            })->tab('Jobs', function (Form $form) {

                $form->hasMany('jobs', function ($form) {
                    $form->text('company');
                    $form->date('start_date');
                    $form->date('end_date');
                });

            });
        });
    }
}
