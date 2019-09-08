<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Dcat\Admin\Form;
use Dcat\Admin\Layout\Content;

class ModalFormController extends Controller
{
    use PreviewCode;

    public function index(Content $content)
    {
        return $content
            ->header('Dialog Form')
            ->description('在 <b>Dcat Admin</b> 中只需要使用数行代码即可构建出一个<b>非iframe</b>表单弹窗。')
            ->body($this->build());
    }

    protected function build()
    {
        Form::modal('新增角色')
            ->click('.create-form') // 绑定点击按钮
            ->url('auth/roles/create') // 表单页面链接，此参数会被按钮中的 “data-url” 属性替换。。
            ->width('700px') // 指定弹窗宽度，可填写百分比，默认 720px
            ->height('650px') // 指定弹窗高度，可填写百分比，默认 690px
            ->success('LA.reload()') // 新增成功后刷新页面
            ->render();

        Form::modal('编辑角色')
            ->click('.edit-form')
            ->success('LA.reload()') // 编辑成功后刷新页面
            ->render();

        // 当需要在同个“class”的按钮中绑定不同的链接时，把链接放到按钮的“data-url”属性中即可
        $editPage = admin_base_path('auth/roles/1/edit');

        return "
<div style='padding:30px 0'>
    {$this->buildPreviewButton()} <br/><br/>
    <span class='btn btn-success create-form'> &nbsp;&nbsp;&nbsp;新增表单弹窗&nbsp;&nbsp;&nbsp; </span> &nbsp;&nbsp;
    <span class='btn btn-blue edit-form' data-url='{$editPage}'> &nbsp;&nbsp;&nbsp;编辑表单弹窗&nbsp;&nbsp;&nbsp; </span>
</div>

";
    }

}
