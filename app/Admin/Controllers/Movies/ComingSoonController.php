<?php

namespace App\Admin\Controllers\Movies;

use App\Admin\Controllers\PreviewCode;
use App\Http\Controllers\Controller;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use App\Admin\Repositories\ComingSoon;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Widgets\Navbar;
use Illuminate\Support\Facades\Input;

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
            ->body(function (Row $row) {
                $row->column(5, $this->navbar());
            })
            ->body($this->grid());
    }

    protected function navbar()
    {
        $items = ['广州', '上海', '北京', '深圳', '杭州', '成都'];

        return Navbar::make('#', array_combine($items, $items))
            ->checked(request(Grid\Filter\Scope::QUERY_NAME, '广州'))
            ->click()
            ->map(function ($v) {
                $url = '?'.Grid\Filter\Scope::QUERY_NAME.'='.$v;

                return "<a href='$url'>$v</a>";
            })
            ->style('max-width:500px');
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid($repository = null)
    {
        $grid = new Grid($repository ?: new ComingSoon());

        $grid->wrap(function ($view) {
            return "<div class='card'>$view</div>";
        });

        $grid->number();
        $grid->title;
        $grid->images->first()->image('', 100);
        $grid->year;
        $grid->rating->get('average');
        $grid->directors->pluck('name')->label('primary');
        $grid->casts->pluck('name')->label();
        $grid->genres->label('purple');

        $grid->disableActions();
        $grid->disableBatchDelete();
        $grid->disableExporter();
        $grid->disableCreateButton();
        $grid->disableFilterButton();

        // 开启 responsive 插件，并启用所有字段
        $grid->responsive()->all();

        $grid->tools(function (Grid\Tools $tools) {
            $tools->append($this->buildPreviewButton(true));
        });

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
            if ($v < 3) {
                $style = 'var(--primary-30)';
            } elseif ($v >= 3 && $v < 7) {
                $style = 'var(--primary-70)';
            } elseif ($v >= 7 && $v < 8) {
                $style = 'var(--primary-90)';
            } elseif ($v >= 8 && $v < 9) {
                $style = 'var(--primary)';
            } elseif ($v >= 9) {
                $style = 'var(--primary-dark)';
            }

            return "<span class='badge' style='background:$style'>$v</span>";
        });
    }
}