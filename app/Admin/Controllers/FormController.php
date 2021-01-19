<?php

namespace App\Admin\Controllers;

use App\Admin\Renderable\UserTable;
use App\Http\Controllers\Controller;
use Dcat\Admin\Form\NestedForm;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Models\Administrator;
use Dcat\Admin\Widgets\Box;
use Dcat\Admin\Widgets\Form;
use Dcat\Admin\Widgets\Tab;
use Faker\Factory;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;
use Symfony\Component\VarDumper\VarDumper;

class FormController extends Controller
{
    use PreviewCode;

    public function index(Content $content)
    {
        if (request()->getMethod() == 'POST') {
            $content->row(Box::make('POST', $this->dump(request()->all()))->style('default'));
        }

        $content->row('<div style="margin:5px 0 15px;">'.$this->buildPreviewButton().'</div>');

        $content->row(function (Row $row) {
            $type = request('_t', 1);

            $tab = new Tab();

            if ($type == 1) {
                $tab->add('Form-1', $this->form1());
                $tab->addLink('Form-2', request()->fullUrlWithQuery(['_t' => 2]));
            } else {
                $tab->addLink('Form-1', request()->fullUrlWithQuery(['_t' => 1]));
                $tab->add('Form-2', $this->form2(), true);
            }

            $row->column(12, $tab->withCard());
        });

        return $content
            ->header('Form');
    }

    protected function form1()
    {
        $form = new Form();

        $form->action(request()->fullUrl());

        $form->text('form1.text', 'text')->required();
        $form->password('form1.password', 'password')->required();
        $form->email('form1.email', 'email');
        $form->mobile('form1.mobile', 'mobile');
        $form->url('form1.url', 'url');
        $form->ip('form1.ip', 'ip');

        $form->color('form1.color', 'color');

        $form->divider();

        $form->selectTable('form1.select-table', 'Select Table')
            ->title('User')
            ->from(UserTable::make())
            ->model(Administrator::class, 'id', 'name');

        $form->multipleSelectTable('form1.select-resource-multiple', 'Multiple Select Table')
            ->title('User')
            ->max(4)
            ->from(UserTable::make())
            ->model(Administrator::class, 'id', 'name');

        $form->icon('form1.icon', 'icon');
        $form->rate('form1.rate', 'rate');
        $form->decimal('form1.decimal', 'decimal');
        $form->number('form1.number', 'number');
        $form->currency('form1.currency', 'currency');
        $form->switch('form1.switch', 'switch')->default(1);

        $form->divider();

        $form->date('form1.date', 'date');
        $form->time('form1.time', 'time');
        $form->datetime('form1.datetime', 'datetime');
        $form->dateRange('form1.date-start', 'form1.date-end', 'date range');
        $form->timeRange('form1.time-start', 'form1.time-end', 'time range');
        $form->datetimeRange('form1.datetime-start', 'form1.datetime-end', 'datetime range');

        $form->html(function () {
            return '<b>自定义HTML</b>';
        }, 'html')->help('自定义内容');

        $form->textarea('form1.textarea', 'textarea');

        $form->divider();

        $form->table('table', function (NestedForm $table) {
            $table->text('key');
            $table->text('value');
            $table->text('desc');
        });

        return "<div style='padding:10px 8px'>{$form->render()}</div>";
    }

    protected function form2()
    {
        $form = new Form();

        $form->action(request()->fullUrl());

        $names = $this->createNames();

        $form->tags('form2.tag', 'Tag')->options($names);
        $form->select('form2.select', 'select')->options($names);
        $form->multipleSelect('form2.multiple-select', 'multiple select')->options($names);
        $form->image('form2.image', 'image');
        $form->multipleFile('form2.multiple-file', 'multiple file')->limit(3);
        $form->checkbox('form2.checkbox', 'checkbox')->options(['GET', 'POST', 'PUT', 'DELETE'])->canCheckAll()->default(1);
        $form->radio('form2.radio', 'radio')->options(['GET', 'POST', 'PUT', 'DELETE'])->default(0);

        $menuModel = config('admin.database.menu_model');
        $menuModel = new $menuModel;
        $form->tree('form2.tree', 'tree')
            ->setTitleColumn('title')
            ->nodes($menuModel->allNodes());

        $form->listbox('form2.listbox', 'listbox')->options($names);

        $form->editor('form2.editor', 'editor');

        return "<div style='padding:9px 8px'>{$form->render()}</div>";
    }


    /**
     * 生成随机数据
     *
     * @return array
     */
    protected function createNames()
    {
        if (isset($this->names)) {
            return $this->names;
        }
        $faker = Factory::create();
        $this->names = [];

        for ($i = 0; $i < 15; $i ++) {
            $name = $faker->name;
            $this->names[$name] = $name;
        }

        return $this->names;
    }

    protected function dump($content)
    {
        VarDumper::setHandler(function ($data) {
            $cloner = new VarCloner();
            $dumper = new HtmlDumper();
            $dumper->dump($cloner->cloneVar($data));
        });

        ob_start();
        VarDumper::dump($content);

        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
}
