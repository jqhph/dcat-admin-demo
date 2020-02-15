<?php

namespace App\Admin\Controllers;

use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Widgets\Card;
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
            ->body($this->grid());
    }

    protected function grid()
    {
        $grid = new Grid();

        $grid->id->code()->sortable();
        $grid->label->explode()->label();
        $grid->progressBar->progressBar()->sortable();
        $grid->expand
            ->display(Factory::create()->name)
            ->expand(function () {
                $faker = Factory::create();

                $card = new Card(null, $faker->text(900));

                return "<div style='padding:10px 10px 0'>$card</div>";
            });
        $grid->select->select(['GET', 'POST', 'PUT', 'DELETE']);
        $grid->switch->switch();
        $grid->switchGroup('Switch Group')
            ->if(function () {
                return $this->id != mt_rand(3, 5);
            })
            ->switchGroup(['is_new', 'is_hot', 'published'], 'purple')
            ->else()
            ->display('<i>None</i>');

        $grid->editable->editable('select', $this->genernateNames());
        $grid->checkbox->checkbox(['GET', 'POST', 'PUT', 'DELETE']);
        $grid->radio
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
        $grid->disableExporter();

        // 设置表格数据
        $grid->model()->setData($this->generate());

        $grid->tools(function (Grid\Tools $tools) {
            $tools->append($this->buildPreviewButton(true));
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
                ->selectResource('auth/users')
                ->options($options)
                ->width('300px');

            $filter->in('users', 'Users')
                ->selectResource('auth/users')
                ->multiple(2)
                ->options($options);
        });

        return $grid;
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
    public function generate() {
        $faker = Factory::create();

        $data = [];

        for ($i = 0; $i < 5; $i++) {
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
