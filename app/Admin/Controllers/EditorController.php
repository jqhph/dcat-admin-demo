<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Widgets\Card;
use Dcat\Admin\Widgets\Form;

class EditorController extends Controller
{
    use PreviewCode;

    public function tinymce(Content $content)
    {
        return $content
            ->title('TinyMCE编辑器')
            ->body($this->buildPreviewButton())
            ->body($this->newline())
            ->body(function (Row $row) {
                $form = Form::make();

                $form->editor('content', '内容');

                $form->disableSubmitButton();
                $form->disableResetButton();

                $row->column(12, Card::make($form));
            });
    }

    public function markdown(Content $content)
    {
        return $content
            ->title('Markdown编辑器')
            ->body($this->buildPreviewButton())
            ->body($this->newline())
            ->body(function (Row $row) {
                $form = Form::make();

                $form->markdown('content', '内容');

                $form->disableSubmitButton();
                $form->disableResetButton();

                $row->column(12, Card::make($form));
            });
    }
}
