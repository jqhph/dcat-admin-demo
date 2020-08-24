<?php

namespace App\Admin\Actions;

use App\Admin\Renderable\AdminSetting as AdminSettingView;
use Dcat\Admin\Actions\Action;
use Dcat\Admin\Widgets\Modal;

class AdminSetting extends Action
{
    /**
     * @return string
     */
	protected $title = '网站设置';

    public function render()
    {
        $modal = Modal::make()
            ->id('admin-setting-config') // 导航栏显示弹窗，必须固定ID，随机ID会在刷新后失败
            ->title($this->title())
            ->body(AdminSettingView::make())
            ->lg()
            ->button(
                <<<HTML
<ul class="nav navbar-nav">
    <li>{$this->title}[异步]</li>
</ul> 
HTML
            );

        return $modal->render();
    }
}
