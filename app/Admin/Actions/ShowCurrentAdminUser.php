<?php

namespace App\Admin\Actions;

use Dcat\Admin\Admin;
use Dcat\Admin\Widgets\Table;
use Dcat\Admin\Actions\Action;
use Dcat\Admin\Actions\Response;
use Dcat\Admin\Models\HasPermissions;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ShowCurrentAdminUser extends Action
{
    /**
     * 按钮标题
     *
     * @var string
     */
    protected $title = '个人信息';

    /**
     * @var string
     */
    protected $modalId = 'show-current-user';

    /**
     * 处理当前动作的请求
     *
     * @param Request $request
     *
     * @return Response
     */
    public function handle(Request $request)
    {
        // 获取当前登录用户模型
        $user = Admin::user();
        // 这里我们用表格展示模型数据
        $table = Table::make($user->toArray());

        return $this->response()
            ->success('查询成功')
            ->html($table);
    }

    /**
     * 处理响应的HTML字符串，附加到弹窗节点中
     *
     * @return string
     */
    protected function handleHtmlResponse()
    {
        return <<<'JS'
var $modal = $(target.data('target')); 

$modal.find('.modal-body').html(response.html)
$modal.modal('show')
JS;
    }

    /**
     * 设置HTML标签的属性
     *
     * @return void
     */
    protected function setupHtmlAttributes()
    {
        // 添加class
        $this->addHtmlClass('btn btn-primary');

        // 保存弹窗的ID
        $this->setHtmlAttribute('data-target', '#'.$this->modalId);

        parent::setupHtmlAttributes();
    }

    /**
     * 设置按钮的HTML，这里我们需要附加上弹窗的HTML
     *
     * @return string|void
     */
    public function html()
    {
        // 按钮的html
        $html = parent::html();

        return <<<HTML
{$html}        
<div class="modal fade" id="{$this->modalId}" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">{$this->title()}</h4>
      </div>
      <div class="modal-body"></div>
    </div>
  </div>
</div>
HTML;
    }

    /**
     * 确认信息，如果此方法返回不为空，则点击按钮之后会弹出确认框
     *
     * @return string|void
     */
    public function confirm()
    {
    }

    /**
     * 动作权限判断，返回false则表示无权限
     *
     * @param Model|Authenticatable|HasPermissions|null $user
     *
     * @return bool
     */
    protected function authorize($user): bool
    {
        return true;
    }

    /**
     * 通过这个方法可以设置动作发起请求时需要附带的参数
     *
     * @return array
     */
    protected function parameters()
    {
        return [];
    }
}