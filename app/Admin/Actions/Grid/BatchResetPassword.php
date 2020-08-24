<?php

namespace App\Admin\Actions\Grid;

use App\Admin\Forms\ResetPassword as ResetPasswordForm;
use Dcat\Admin\Widgets\Modal;
use Dcat\Admin\Grid\BatchAction;

class BatchResetPassword extends BatchAction
{
    protected $title = '修改密码';

    public function render()
    {
        // 实例化表单类
        $form = ResetPasswordForm::make();

        return Modal::make()
            ->lg()
            ->title($this->title)
            ->body($form)
            ->onLoad($this->getModalScript()) // 弹窗显示后往隐藏表单写入选中的ID
            ->button($this->title);
    }

    protected function getModalScript()
    {
        // 弹窗显示后往隐藏的id表单中写入批量选中的行ID
        return <<<JS
// 获取选中的ID数组
var key = {$this->getSelectedKeysScript()}

$('#reset-password-id').val(key);
JS;
    }
}
