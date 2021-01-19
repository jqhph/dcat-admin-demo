<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Dcat\Admin\FormStep\Form as StepForm;
use Dcat\Admin\Form;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Widgets\Alert;

class StepFormController extends Controller
{
    use PreviewCode;

    public function index(Content $content)
    {
        return $content
            ->body('<div style="margin:5px 0 15px;">'.$this->buildPreviewButton().'</div>')
            ->body($this->form())
            ->header('Step Form')
            ->description('分步表单DEMO');
    }


    protected function form()
    {
        return new Form(null, function (Form $form) {
            $form->title('分步表单');
            $form->action('form/step');
            $form->disableListButton();

            $form->multipleSteps()
                ->remember()
                ->width('950px')
                ->add('基本信息', function (StepForm $step) {
                    $info = '<i class="fa fa-exclamation-circle"></i> 表单字段支持前端验证和后端验证混用，前端验证支持H5表单验证以及自定义验证。';

                    $step->html(Alert::make($info)->info());

                    $step->text('name', '姓名')->required()->maxLength(20);
                    // h5 表单验证
                    $step->text('age', '年龄')
                        ->required()
                        ->type('number')
                        ->attribute('max', 150)
                        ->help('前端验证');

                    $step->radio('sex', '性别')->options(['未知', '男', '女'])->default(0);

                    // 后端验证
                    $step->text('birthplace', '籍贯')
                        ->rules('required')
                        ->help('演示后端字段验证');

                    $step->url('homepage', '个人主页');

                    $step->textarea('description', '简介');

                })
                ->add('兴趣爱好', function (StepForm $step) {
                    $step->tags('hobbies', '爱好')
                        ->options(['唱', '跳', 'RAP', '踢足球'])
                        ->required();

                    $step->text('books', '书籍');
                    $step->text('music', '音乐');

                    // 事件
                    $step->shown(function () {
                        return <<<JS
    Dcat.info('兴趣爱好');
    console.log('兴趣爱好', args);
JS;
                    });

                })
                ->add('地址', function (StepForm $step) {
                    $step->text('address', '街道地址');
                    $step->text('post_code', '邮政编码');
                    $step->tel('tel', ' 联系电话');
                })
                ->done(function () use ($form) {
                    $resource = $form->resource(0);

                    $data = [
                        'title'       => '操作成功',
                        'description' => '恭喜您成为第10086位用户',
                        'createUrl'   => $resource,
                        'backUrl'     => $resource,
                    ];

                    return view('dcat-admin.form-step::completion-page', $data);
                });
        });
    }

    /**
     * 保存
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function store()
    {
        return $this->form()->saving(function (Form $form) {
            // 清空缓存
            $form->multipleSteps()->flushStash();

            // 拦截保存操作
            return response(
                $form->multipleSteps()
                    ->done()
                    ->render()
            );
        })->store();
    }
}
