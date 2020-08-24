<?php

namespace App\Admin\Actions\Grid;

use App\Admin\Forms\ResetPassword as ResetPasswordForm;
use Dcat\Admin\Widgets\Modal;
use Dcat\Admin\Grid\RowAction;

class ResetPassword extends RowAction
{
    protected $title = '修改密码';

    public function render()
    {
        // 实例化表单类并传递自定义参数
        $form = ResetPasswordForm::make()->payload(['id' => $this->getKey()]);

        return Modal::make()
            ->lg()
            ->title($this->title)
            ->body($form)
            ->button($this->title);
    }
}
