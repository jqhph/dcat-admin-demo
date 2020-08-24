<?php

namespace App\Admin\Forms;

use Dcat\Admin\Models\Administrator;
use Dcat\Admin\Support\Helper;
use Dcat\Admin\Traits\LazyWidget;
use Dcat\Admin\Widgets\Form;
use Dcat\Admin\Contracts\LazyRenderable;

class ResetPassword extends Form implements LazyRenderable
{
    use LazyWidget; // 使用异步加载功能

    // 处理请求
    public function handle(array $input)
    {
        // 获取外部传递参数
        //$id = $this->payload['id'] ?? null;
        $id = Helper::array($input['id'] ?? null);

        // 表单参数
        $password = $input['password'] ?? null;

        if (! $id) {
            return $this->error('参数错误');
        }

        $user = Administrator::query()->find($id);

        if (! $user) {
            return $this->error('用户不存在');
        }

        $user->update(['password' => bcrypt($password)]);

        return $this->success('密码修改成功');
    }

    public function form()
    {
        // 获取外部传递参数
        //$id = $this->payload['id'] ?? null;

        $this->password('password')->required();
        // 密码确认表单
        $this->password('password_confirm')->same('password');

        $this->hidden('id')->attribute('id', 'reset-password-id');
    }

    // 返回表单数据，如不需要可以删除此方法
    public function default()
    {
        return [
            'password'         => '',
            'password_confirm' => '',
        ];
    }
}
