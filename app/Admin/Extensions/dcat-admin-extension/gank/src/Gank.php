<?php

namespace Dcat\Admin\Extension\Gank;

use Dcat\Admin\Extension;
use Dcat\Admin\Grid;
use Dcat\Admin\Widgets\Navbar;

class Gank extends Extension
{
    const NAME = 'gank';

    protected $serviceProvider = GankServiceProvider::class;

    protected $assets = __DIR__.'/../resources/assets';

    protected $composer = __DIR__.'/../composer.json';

    public static $categoryColorsMap = [
        'App'      => 'var(--purple)',
        '前端'     => 'var(--primary)',
        '拓展资源' => 'var(--primary-dark)',
        '瞎推荐'   => 'var(--blue)',
        '福利'     => 'var(--danger)',
        'Android'  => 'var(--purple-dark)',
        'iOS'      => 'var(--info)',
        '休息视频' => 'var(--warning)',
    ];

    public static function navbar()
    {
        $items = array_keys(self::$categoryColorsMap);
        array_unshift($items, '全部');

        return Navbar::make('#', array_combine($items, $items))
            ->checked(request(Grid\Filter\Scope::QUERY_NAME, '全部'))
            ->click()
            ->map(function ($v) {
                if ($v == '全部') {
                    $url = '?';
                } else {
                    $url = '?'.Grid\Filter\Scope::QUERY_NAME.'='.$v;
                }

                return "<a href='$url'>$v</a>";
            })
            ->style('max-width:705px');
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    public static function grid($repository = null)
    {
        static::defineGridColumn();

        $grid = new Grid($repository);

        $grid->wrap(function ($view) {
            return "<div class='card'>$view</div>";
        });

        $grid->number();
        $grid->desc('描述')->width('300px');
        $grid->images('图片')->image(150);
        $grid->type('类别');
        $grid->who('作者')->label();
        $grid->publishedAt('发布于');

        $grid->disableActions();
        $grid->disableBatchDelete();
        $grid->disableCreateButton();
        $grid->disableFilterButton();

        return $grid;
    }

    public static function defineGridColumn()
    {
        Grid\Column::define('desc', function ($v, $column) {
            if ($this->type == '福利') {
                $width = '150';
                $height = '200';
                return "<img data-init='preview' src='{$this->url}' style='max-width:{$width}px;max-height:{$height}px;cursor:pointer' class='img img-thumbnail' />";
            }

            return sprintf('<a href="%s" target="_blank">%s</a>', $this->url, $v);
        });

        Grid\Column::define('publishedAt', function ($v) {
            return date('Y-m-d', strtotime($v));
        });
        Grid\Column::define('datetime', function ($v) {
            return date('Y-m-d H:i:s', strtotime($v));
        });

        Grid\Column::define('type', function ($v) {
            $map = Gank::$categoryColorsMap;

            return "<span class='label' style='background:{$map[$v]}'>$v</span>";
        });
    }
}
