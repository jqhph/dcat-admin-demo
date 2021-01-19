<?php

namespace App\Admin\Controllers;

use Dcat\Admin\Admin;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Widgets\Code;
use Dcat\Admin\Widgets\Tab;

trait PreviewCode
{
    /**
     * Build tab.
     *
     * @param \Closure $callback
     * @return Tab
     */
    protected function buildPreviewTab(\Closure $callback, Content $content = null)
    {
        $tab = Tab::make();

        $preview = request('preview');

        $url = url()->current();

        if ($preview) {
            $tab->addLink('示例', "$url?preview=0");

            $tab->add('代码', $this->code(), true);
        } else {
            $tab->add('示例', $callback($tab, $content));
            $tab->addLink('代码', "$url?preview=1");
        }

        return $tab;
    }

    /**
     * Preview action.
     *
     * @param Content $content
     * @return Content
     */
    public function preview(Content $content)
    {
        return $content->full()->body($this->code());
    }

    /**
     * @return Code
     */
    protected function code()
    {
        $file = (new \ReflectionClass(static::class))->getFileName();

        return Code::make($file, 0, 1000);
    }

    /**
     * @return string
     */
    protected function buildPreviewButton($class = 'btn-white')
    {
        $previewUrl = '/'.request()->path().'/preview';

        Admin::script(
            <<<SCRIPT
$('.preview-code').click(function () {
    layer.open({
        type: 2,
        title: '预览代码',
        area: ['65%', '80%'],
        content: '$previewUrl',
    });
});
SCRIPT

        );

        return "<button class='btn {$class} preview-code'> &nbsp;&nbsp;&nbsp;<i class=' fa  fa-code'></i>&nbsp;预览代码&nbsp;&nbsp;&nbsp; </button>&nbsp;";
    }

    /**
     * @param null $repeat
     * @return string
     */
    protected function newline($repeat = null)
    {
        $value = '<div style="height:15px"></div>';

        if (!$repeat) return $value;

        return str_repeat($value, $repeat);
    }
}
