<?php

namespace App\Admin\Forms;

use Dcat\Admin\Contracts\LazyRenderable;
use Dcat\Admin\Traits\LazyWidget;
use Dcat\Admin\Widgets\Form;
use Illuminate\Support\Arr;

class AdminSetting extends Form implements LazyRenderable
{
    use LazyWidget;

    /**
     * 主题颜色.
     *
     * @var array
     */
    protected $colors = [
        'default'    => '深蓝',
        'blue'       => '蓝',
//        'blue-light' => '浅蓝',
//        'blue-dark'  => '深蓝',
        'green'      => '绿',
    ];

    /**
     * 处理表单请求.
     *
     * @param array $input
     *
     * @return mixed
     */
    public function handle(array $input)
    {
        $input['layout']['horizontal_menu'] = in_array('horizontal_menu', $input['layout']['body_class'], true);

        foreach (Arr::dot($input) as $k => $v) {
            $this->update($k, $v);
        }

        return $this->response()->success('设置成功');
    }

    /**
     * 构建表单.
     */
    public function form()
    {
        $this->text('name')->required()->help('网站名称');
        $this->text('logo')->required()->help('logo设置');
        $this->text('logo-mini', 'Logo mini')->required();
        $this->radio('lang', '语言')->required()->options(['en' => 'English', 'zh_CN' => '简体中文']);
        $this->radio('layout.color', '主题')
            ->required()
            ->help('主题颜色，支持自定义！')
            ->options($this->colors);

        $this->radio('layout.sidebar_style', '菜单样式')
            ->options(['light' => 'Light', 'primary' => 'Primary'])
            ->help('切换菜单栏样式');

        $this->checkbox('layout.body_class', '菜单布局')
            ->options([
                'horizontal_menu' => '水平 (Horizontal)',
                'sidebar-separate' => 'sidebar-separate',
            ])
            ->help('切换菜单布局');
//        $this->switch('https', '启用HTTPS');
        $this->switch('helpers.enable', '开发工具');
    }

    /**
     * 设置接口保存成功后的回调JS代码.
     *
     * 1.2秒后刷新整个页面.
     *
     * @return string|void
     */
    public function savedScript()
    {
        return <<<'JS'
    if (data.status) {
        setTimeout(function () {
          location.reload()  
        }, 1200);
    }
JS;
    }

    /**
     * 返回表单数据.
     *
     * @return array
     */
    public function default()
    {
        return user_admin_config();
    }

    /**
     * 更新配置.
     *
     * @param string $key
     * @param string $value
     */
    protected function update($key, $value)
    {
        user_admin_config([$key => $value]);
    }
}
