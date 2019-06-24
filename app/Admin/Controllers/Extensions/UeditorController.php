<?php

namespace App\Admin\Controllers\Extensions;

use App\Admin\Controllers\PreviewCode;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Widgets\Form;

class UeditorController
{
    use PreviewCode;

    public function index(Content $content)
    {
        return $content
            ->header('UEditor')
            ->description('百度在线编辑器<a href="https://ueditor.baidu.com/website/index.html" target="_blank">https://ueditor.baidu.com/website/index.html</a>')
            ->body($this->buildPreviewButton().$this->newline(2))
            ->body(function (Row $row) {
                $form = new Form();

                $form->ueditor('editor');

                $form->disableSubmitButton();
                $form->disableResetButton();

                $row->column(12, $form);
            });
    }
}
