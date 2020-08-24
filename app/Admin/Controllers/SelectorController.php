<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\TeaTable;
use App\Http\Controllers\Controller;
use Dcat\Admin\Admin;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;

class SelectorController extends Controller
{
    use PreviewCode;

    public function index(Content $content)
    {
        return $content
            ->body($this->grid())
            ->header('表格筛选器')
            ->description('筛选器示例');
    }

    protected function grid()
    {
        return Grid::make(new TeaTable(), function (Grid $grid) {
            $grid->id('ID')->bold();
            $grid->name('名称');
            $grid->norms('规格');
            $grid->category('类别')->label('default');
            $grid->price('售价')->display(function ($value) {
                return number_format($value / 1000, 2);
            });
            $grid->shop_name('店铺')->link();
            $grid->brand('品牌')->link();
            $grid->state('上架?')->switch();
            $grid->added_at('上架时间');

            $grid->disableCreateButton();
            $grid->disableActions();

            $grid->tools(function (Grid\Tools $tools) {
                $tools->append($this->buildPreviewButton('btn-primary'));
            });

            $grid->selector(function (Grid\Tools\Selector $selector) {
                $selector->select('brand', '品牌', ['AiW', '全有家居', 'YaLM', '甜梦', '饭爱家具', '偶堂家私']);
                $selector->select('category', '类别', ['茶几', '地柜式', '边几', '布艺沙发', '茶台', '炕几']);
                $selector->select('style', '风格', ['现代简约', '新中式', '田园风', '明清古典', '北欧', '轻奢', '古典']);

                $selector->selectOne('price', '售价', ['0-599', '600-1999', '1999-4999', '5000+']);
            });
        });
    }
}
