<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Report;
use App\Http\Controllers\Controller;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Widgets\Callout;

class FixedController extends Controller
{
    use PreviewCode;

    public function index(Content $content)
    {
        return $content
            ->header('Fixed Column')
            ->description('表格固定列功能示例')
//            ->body(Callout::make('即将在下个版本发布，敬请期待~'))
            ->body($this->grid());
    }

    protected function grid()
    {
        return new Grid(new Report(), function (Grid $grid) {
            $grid->showColumnSelector();

            $grid->column('name');
            $grid->column('content')->limit(50);
            $grid->column('cost')->sortable();
            $grid->column('avgQuarterCost')->setHeaderAttributes(['style' => 'color:#5b69bc']);
            $grid->column('avgYearCost');
            $grid->column('avgMonthVist');
            $grid->column('avgQuarterVist');
            $grid->column('avgYearVist');
            $grid->column('incrs');
            $grid->column('avgVists');
            $grid->column('date')->sortable();
            $grid->column('created_at');
            $grid->column('updated_at');

            $grid->tools($this->buildPreviewButton());

            // 启用边框模式
//            $grid->withBorder();

            $grid->fixColumns(2);

            $grid->disableActions();
            $grid->disableBatchDelete();
            $grid->disableCreateButton();
            $grid->disableCreateButton();
        });
    }
}
