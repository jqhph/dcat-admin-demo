<?php

namespace App\Admin\Controllers;

use App\Admin\Metrics\Examples\NewDevices;
use App\Admin\Metrics\Examples\NewUsers;
use App\Admin\Metrics\Examples\TotalUsers;
use App\Admin\Renderable\PostTable;
use App\Admin\Renderable\UserTable;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Models\Administrator;
use Faker\Factory;
use Illuminate\Routing\Controller;

class GridController extends Controller
{
    use PreviewCode;

    public function index(Content $content)
    {
        return $content
            ->header('表格')
            ->description('表格功能展示')
            ->body(function (Row $row) {
                $row->column(4, new TotalUsers());
                $row->column(4, new NewUsers());
                $row->column(4, new NewDevices());
            })
            ->body($this->grid());
    }

    protected function grid()
    {
        return new Grid(null, function (Grid $grid) {
            $grid->number();
            $grid->column('id')->code()->sortable();
            $grid->column('label')->explode()->label();
            $grid->column('progressBar')->progressBar()->sortable();
            $grid->column('expand')
                ->display(Factory::create()->name)
                ->expand(PostTable::make());
            $grid->column('select')->select(['GET', 'POST', 'PUT', 'DELETE']);
            $grid->column('switch')->switch();
            $grid->column('switchGroup', 'Switch Group')
                ->if(function () {
                    return $this->id != mt_rand(3, 5);
                })
                ->switchGroup(['is_new', 'is_hot', 'published'])
                ->else()
                ->display('<i>None</i>');

            $grid->column('checkbox')->checkbox(['GET', 'POST', 'PUT', 'DELETE']);
            $grid->column('radio')
                ->if(function () {
                    return $this->id != mt_rand(3, 5);
                })
                ->radio(['PHP', 'JAVA', 'GO', 'C'])
                ->else()
                ->display('<i>None</i>');

            $grid->disableCreateButton();
            $grid->disableActions();
            $grid->disableBatchDelete();
            $grid->disablePagination();

            // 设置表格数据
            $grid->model()->setData($this->generate());

            $grid->tools(function (Grid\Tools $tools) {
                $tools->append($this->buildPreviewButton());
            });

            // 过滤器
            $grid->filter(function (Grid\Filter $filter) {
                $group = function (Grid\Filter\Group $group) {
                    $group->equal('等于');
                    $group->gt('大于');
                    $group->lt('小于');
                    $group->nlt('大于等于');
                    $group->ngt('小于等于');
                    $group->like('包含');
                    $group->startWith('包含（起始）');
                    $group->endWith('包含（结束）');
                    $group->match('正则');
                };

                $filter->group('id', $group)->width('350px');
                $filter->group('date', $group)->date()->width('350px');

                $filter->equal('select')->select(range(1, 10));
                $filter->in('multiple', 'Multiple Select')->multipleSelect(range(1, 10));
                $filter->between('between', 'Between')->datetime();

                $options = function ($keys) {
                    if (!$keys) return $keys;
                    $userModel = config('admin.database.users_model');

                    return $userModel::findOrFail($keys)->pluck('name', 'id');
                };

                $filter->equal('user', 'User')
                    ->selectTable(UserTable::make())
                    ->title('User')
                    ->model(Administrator::class)
                    ->width('300px');
            });
        });
    }

    public function update()
    {
        return [
            'status' => true,
            'message' => '修改成功',
        ];
    }

    /**
     * 生成假数据
     *
     * @return array
     */
    public function generate()
    {
        $faker = Factory::create();

        $data = [];

        for ($i = 0; $i < 10; $i++) {
            $data[] = [
                'id' => $i+1,
                'label' => str_repeat($faker->name().',', mt_rand(1, 2)),
                'progressBar' => mt_rand(1, 100),
                'switch' => mt_rand(0, 1),
                'editable' => mt_rand(0, 14),
                'checkbox' => value(function () use ($faker) {
                    $values = [];
                    for ($i = 0; $i < mt_rand(1, 4); $i++) {
                        $values[] = mt_rand(0, 3);
                    }
                    return join(',', $values);
                }),
                'radio' => mt_rand(0, 3),
                'is_new' => mt_rand(0, 1),
                'is_hot' => mt_rand(0, 1),
                'published' => mt_rand(0, 1),
            ];
        }

        return $data;
    }

    /**
     * 生成假数据
     *
     * @return array
     */
    protected function genernateNames()
    {
        $faker = Factory::create();

        $data = [];
        for ($i = 0; $i < 15; $i++) {
            $data[] = $faker->name;
        }
        return $data;
    }
}
