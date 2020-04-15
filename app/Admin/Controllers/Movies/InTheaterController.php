<?php

namespace App\Admin\Controllers\Movies;

use App\Admin\Controllers\PreviewCode;
use Dcat\Admin\Controllers\HasResourceActions;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use App\Admin\Repositories\InTheater;
use Dcat\Admin\Layout\Row;

class InTheaterController extends ComingSoonController
{
    use HasResourceActions, PreviewCode;

    protected $header = '正在上映的电影';

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index(Content $content)
    {
        $this->define();

        return $content
            ->header($this->header)
            ->body($this->grid());
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content->header($this->header)->body($this->form()->edit($id));
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid($repository = null)
    {
        $grid = parent::grid(new InTheater());

        $grid->disableActions(false);
        $grid->disableViewButton();
        $grid->showQuickEditButton();

        return $grid;
    }

    protected function form()
    {
        $form = new Form(new InTheater());

        $form->display('id', 'ID');
        $form->text('title')->rules('required');
        $form->text('original_title');
        $form->textarea('summary');
        $form->url('alt');
        $form->url('mobile_url');
        $form->url('share_url');
        $form->tags('countries');
        $form->tags('genres');
        $form->tags('aka');
        $form->year('year');

        $form->disableViewButton();
        $form->disableViewCheck();

        return $form;
    }
}
