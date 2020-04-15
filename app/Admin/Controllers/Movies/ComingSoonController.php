<?php

namespace App\Admin\Controllers\Movies;

use App\Admin\Controllers\PreviewCode;
use App\Http\Controllers\Controller;
use Dcat\Admin\Admin;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use App\Admin\Repositories\ComingSoon;

class ComingSoonController extends Controller
{
    use PreviewCode;

    protected $header = '即将上映';

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index(Content $content)
    {
        $this->define();

        return $content->header($this->header)
            ->body($this->grid());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid($repository = null)
    {
        $grid = new Grid($repository ?: new ComingSoon());

        $grid->number();
        $grid->title;
        $grid->images->first()->image('', 100);
        $grid->year;
        $grid->rating->get('average');
        $grid->directors->pluck('name')->label('primary');
        $grid->casts->pluck('name')->label('primary');
        $grid->genres->label('success');

        $grid->disableActions();
        $grid->disableBatchDelete();
        $grid->disableCreateButton();
        $grid->disableFilterButton();

        // 开启 responsive 插件，并启用所有字段
        $grid->responsive()->all();

        $grid->tools($this->buildPreviewButton());

//        $grid->filter(function (Grid\Filter $filter) {
//            $cities = ['广州', '上海', '北京', '深圳', '杭州', '成都'];
//
//            collect($cities)->each(function ($v) use ($filter) {
//                $filter->scope($v, $v);
//            });
//
//            // 默认选中“广州”
//            if (!Input::has(Grid\Filter\Scope::QUERY_NAME)) {
//                Input::replace([Grid\Filter\Scope::QUERY_NAME => '广州']);
//            }
//
//        });

        return $grid;
    }

    protected function define()
    {
        Grid\Column::define('title', function ($v) {
            return sprintf('<a href="%s" target="_blank"><i>《%s》</i></a>', $this->alt, $v);
        });

        Grid\Column::define('rating', function ($v) {
            $style = '';
            $color = Admin::color();

            if ($v < 3) {
                $style = $color->alpha('primary', 0.4);
            } elseif ($v >= 3 && $v < 7) {
                $style = $color->alpha('primary', 0.6);
            } elseif ($v >= 7 && $v < 8) {
                $style = $color->alpha('primary', 0.8);
            } elseif ($v >= 8 && $v < 9) {
                $style = $color->primary();
            } elseif ($v >= 9) {
                $style = $color->primaryDarker();
            }

            return "<span class='badge' style='background:$style;color:#fff'>$v</span>";
        });
    }
}