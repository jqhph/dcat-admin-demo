<?php

namespace Dcat\Page\Admin\Controllers;

use Dcat\Admin\Widgets\Card;
use DcatPage;
use Illuminate\Routing\Controller;
use Dcat\Page\Admin\Grid\CompileButton;
use Dcat\Page\Admin\Grid\CreateAppButton;
use Dcat\Page\Admin\Grid\IndexButton;
use Dcat\Page\Admin\Repositories\App;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Widgets\Box;
use Dcat\Admin\Widgets\Terminal;
use Dcat\Admin\Widgets\Table;

class AdminController extends Controller
{
    /**
     * 应用管理页面
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('Dcat Page')
            ->description('一个简单易用的静态站点构建工具')
            ->body($this->grid());
    }

    /**
     * 构建应用列表
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new App());

        $grid->disableCreateButton();
        $grid->disableBatchDelete();
        $grid->disableActions();
        $grid->disablePagination();

        $grid->number();
        $grid->app('应用')->label('primary');
        $grid->column('description', '描述')->width('360px');
        $grid->homepage('主页')->display(function ($value) {
            if (!$value) return;

            return "<a href='$value' target='_blank'></a>";
        });
        $grid->authors('开发者')->display(function ($v) {
            if (!$v) return;

            foreach ($v as &$item) {
                $item = "<span class='bold text-80'>{$item['name']}</span> <<code>{$item['email']}</code>>";
            }

            return join('<br/>', $v);
        });

        $self = $this;
        $grid->config('配置')->display('详细')->expand(function () use ($self) {
            if (!$this->config) return;

            return $self->formatConfigData((array)$this->config);
        });

        $grid->action('操作')->display(function () {
            $preview = DcatPage\url('/', $this->app);

            return <<<HTML
<a href="$preview" target="_blank">预览</a> |
<a class="compile-app" data-app="{$this->app}" href="javascript:void(0)" >编译</a> | 
<a class="index-app" data-app="{$this->app}" href="javascript:void(0)" >索引</a> 
HTML;
        });

        $grid->tools(function (Grid\Tools $tools) {
            $tools->append(new CompileButton());
            $tools->append(new IndexButton());
            $tools->append(new CreateAppButton());
        });

        return $grid;
    }

    /**
     * 创建应用接口
     *
     * @return mixed
     */
    public function createApp()
    {
        $name = request('name');

        $box = Box::make("<span>DcatPage:create <small>$name</small></span>")
            ->content(Terminal::call('dcatpage:create', ['name' => $name]));

        return response()->json(['status' => true, 'content' => $box->render()]);
    }

    /**
     * 编译应用接口
     *
     * @return mixed
     */
    public function compileApp()
    {
        $name = request('name');
        $dir  = request('dir');

        $title = '';
        if ($dir) {
            $title = "--dir=$dir";
        }

        $box = Box::make("<span>DcatPage:compile <small>$name $title</small></span>")
            ->content(Terminal::call('dcatpage:compile', ['name' => $name, '--dir' => $dir]));

        return response()->json(['status' => true, 'content' => $box->render()]);
    }

    /**
     * 生成索引接口
     *
     * @return mixed
     */
    public function indexApp()
    {
        $name = request('name');

        $box = Box::make("<span>DcatPage:index <small>$name</small></span>")
            ->content(Terminal::call('dcatpage:index', ['name' => $name]));

        return response()->json(['status' => true, 'content' => $box->render()]);
    }

    /**
     * @param array $data
     * @return Table
     */
    protected function formatConfigData(array $data)
    {
        $data = json_encode($data, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);

        return Card::make("<pre>$data</pre>")->class('mb-0', true);
    }
}
