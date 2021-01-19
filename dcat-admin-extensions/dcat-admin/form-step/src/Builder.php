<?php

namespace Dcat\Admin\FormStep;

use Closure;
use Dcat\Admin\Form as ParentForm;
use Dcat\Admin\Http\JsonResponse;
use Dcat\Admin\FormStep\Form;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class Builder
{
    const CURRENT_VALIDATION_STEP = 'CURRENT_VALIDATION_STEP';
    const ALL_STEPS = 'ALL_STEPS';

    /**
     * @var ParentForm
     */
    protected $form;

    /**
     * @var Form[]
     */
    protected $FormSteps = [];

    /**
     * @var CompletionPage
     */
    protected $completionPage;

    /**
     * @var array
     */
    protected $options = [
        'selected' => 0,
        'width'    => '1000px',
        'padding'  => '30px 18px 30px',
        'remember' => false,
        'shown'    => [],
        'leaving'  => [],
    ];

    public function __construct(ParentForm $form)
    {
        $this->form = $form;

        $this->initForm();
    }

    /**
     * @param string|Form|Form[] $title
     * @param \Closure|null      $callback
     *
     * @return $this
     */
    public function add($title, ?\Closure $callback = null)
    {
        if (is_array($title)) {
            foreach ($title as $key => $form) {
                $this->addForm($form, $callback);
            }

            return $this;
        }

        $form = $title instanceof Form ? $title : new Form($this->form, $title);

        $this->addForm($form, $callback);

        return $this;
    }

    /**
     * @param Form          $form
     * @param \Closure|null $callback
     *
     * @return void
     */
    protected function addForm(Form $form, ?\Closure $callback = null)
    {
        $form->setIndex(count($this->FormSteps));

        $this->FormSteps[] = $form;

        if ($callback) {
            $callback($form);
        }
    }

    /**
     * Get all step forms.
     *
     * @return Form[]
     */
    public function all()
    {
        return $this->FormSteps;
    }

    /**
     * @return ParentForm\Field[]|Collection
     */
    public function fields()
    {
        $fields = new Collection();

        foreach ($this->all() as $form) {
            $fields = $fields->merge($form->fields());
        }

        return $fields;
    }

    /**
     * Counts all step forms.
     *
     * @return int
     */
    public function count()
    {
        return count($this->FormSteps);
    }

    /**
     * Set options.
     *
     * @param string|array $key
     * @param mixed        $value
     *
     * @return $this
     */
    public function option($key, $value = null)
    {
        if (is_array($key)) {
            $this->options = array_merge($this->options, $key);
        } else {
            $this->options[$key] = $value;
        }

        return $this;
    }

    /**
     * Get options.
     *
     * @param string|null $key
     * @param null        $default
     *
     * @return array|mixed|null
     */
    public function getOption($key = null, $default = null)
    {
        if ($key === null) {
            return $this->options;
        }

        return $this->options[$key] ?? $default;
    }

    /**
     * @param int $index
     *
     * @return $this
     */
    public function select(int $index)
    {
        return $this->option('selected', $index);
    }

    /**
     * Set padding for container.
     *
     * @param string $padding
     *
     * @return $this
     */
    public function padding(string $padding)
    {
        return $this->option('padding', $padding);
    }

    /**
     * Set max width for container.
     *
     * @param string $width
     *
     * @return $this
     */
    public function width(string $width)
    {
        return $this->option('width', $width);
    }

    /**
     * Remember input data.
     *
     * @param bool $value
     *
     * @return $this
     */
    public function remember(bool $value = true)
    {
        return $this->option('remember', $value);
    }

    /**
     * @param string|Closure $title
     * @param Closure|null   $callback
     *
     * @return $this|CompletionPage
     */
    public function done($title = null, Closure $callback = null)
    {
        if ($title === null && $callback === null) {
            if (! $this->completionPage) {
                $this->makeDefaultCompletionPage();
            }

            return $this->completionPage;
        }

        if ($title instanceof Closure) {
            $callback = $title;
            $title = trans('admin.done');
        }

        $this->completionPage = new CompletionPage($this->form, $title, $callback);

        return $this;
    }

    /**
     * @return void
     */
    protected function makeDefaultCompletionPage()
    {
        $this->done(function () {
            $resource = $this->form->resource(0);

            $data = [
                'title'       => trans('admin.save_succeeded'),
                'description' => '',
                'createUrl'   => $resource.'/create',
                'backUrl'     => $resource,
            ];

            return view('dcat-admin.form-step::completion-page', $data);
        });
    }

    /**
     * Stash input data.
     *
     * @param array $data
     * @param bool  $merge
     *
     * @return void
     */
    public function stash(array $data, bool $merge = false)
    {
        if (! $this->options['remember']) {
            return;
        }

        if ($merge) {
            $data = array_merge($this->fetchStash(), $data);
        }

        session()->put($this->getStashKey(), $data);
    }

    /**
     * Fetch input data.
     *
     * @return array
     */
    public function fetchStash()
    {
        if (! $this->options['remember']) {
            return [];
        }

        return session()->get($this->getStashKey()) ?: [];
    }

    /**
     * Flush input data.
     *
     * @return void
     */
    public function flushStash()
    {
        if (! $this->options['remember']) {
            return;
        }

        session()->remove($this->getStashKey());
    }

    /**
     * Forget input data by keys.
     *
     * @param string|array $keys
     *
     * @return void
     */
    public function forgetStash($keys)
    {
        $data = $this->fetchStash();

        Arr::forget($data, $keys);

        $this->stash($data);
    }

    /**
     * @param string|\Dcat\Admin\Form\Field $field
     *
     * @return void
     */
    public function stashIndexByField($field)
    {
        if (! $this->options['remember']) {
            return;
        }

        $data = $this->fetchStash();

        $data[self::CURRENT_VALIDATION_STEP] = ($this->fieldIndex($field) ?: 0) - 1;

        unset($data[self::ALL_STEPS]);

        $this->stash($data);
    }

    /**
     * @return string
     */
    protected function getStashKey()
    {
        return 'step-form-input:'.admin_controller_slug();
    }

    /**
     * @return void
     */
    protected function selectStep()
    {
        if (! $this->options['remember'] || ! $input = $this->fetchStash()) {
            return;
        }

        $current = $input[static::CURRENT_VALIDATION_STEP] ?? null;
        $allStep = $input[static::ALL_STEPS] ?? null;

        unset($input[static::CURRENT_VALIDATION_STEP], $input[static::ALL_STEPS]);

        if ($current !== null && $current !== '' && ! empty($input)) {
            $this->select((int) ($current + 1));
        }

        if (! empty($allStep) && ! empty($input)) {
            $this->select($this->count() - 1);
        }
    }

    /**
     * @return string
     */
    public function build()
    {
        $this->selectStep();

        $this->prepareForm();

        return $this->renderFields();
    }

    /**
     * @return void
     */
    protected function prepareForm()
    {
        foreach ($this->FormSteps as $step) {
            $step->action($this->form->action());

            foreach ($step->fields() as $field) {
                $field->setForm($this->form);
            }
        }
    }

    /**
     * @return string
     */
    public function renderFields()
    {
        $html = '';

        foreach ($this->FormSteps as $step) {
            $html .= (string) $step->render();
        }

        return $html;
    }

    /**
     * Register the "showStep" event listener.
     *
     * @param string $script
     *
     * @return $this
     */
    public function shown($script)
    {
        $script = value($script);

        $this->options['shown'][] = <<<JS
function (args) {
    {$script}
}
JS;

        return $this;
    }

    /**
     * Register the "leaveStep" event listener.
     *
     * @param string $script
     *
     * @return $this
     */
    public function leaving($script)
    {
        $script = value($script);

        $this->options['leaving'][] = <<<JS
function (args) {
    {$script}
}
JS;

        return $this;
    }

    /**
     * @param string|\Dcat\Admin\Form\Field $column
     *
     * @return false|int
     */
    public function fieldIndex($column)
    {
        foreach ($this->FormSteps as $index => $form) {
            if ($form->field($column)) {
                return $index;
            }
        }

        return false;
    }

    /**
     * 初始化
     */
    protected function initForm()
    {
        $this->form->builder()->view('dcat-admin.form-step::steps');

        $this->form->builder()->addVariables(['steps' => $this]);

        $self = $this;
        $this->form->submitted(function ($form) use ($self) {
            $self->prepareFormStepFields($form->input());

            // Validate step form.
            if ($self->isFormStepValidationRequest()) {
                return $self->validateFormStep($form->input());
            }
        });

        $this->form->saved(function () use ($self) {
            $self->flushStash();

            return $self->responseCompletionPage();
        });

        $this->form->fileDeleted(function ($form, $field) use ($self) {
            // 移除暂存数据
            $self->stashIndexByField($field->column());
            $self->forgetStash($field->column());
        });
    }

    /**
     * @param array $input
     *
     * @return void
     */
    protected function prepareFormStepFields(array $input)
    {
        if (
            empty($this->count())
            || (! isset($input[static::ALL_STEPS]) && ! $this->isFormStepValidationRequest())
        ) {
            return;
        }

        $steps = $this->all();

        if ($this->isFormStepValidationRequest()) {
            $currentIndex = $input[static::CURRENT_VALIDATION_STEP];

            if (empty($steps[$currentIndex])) {
                return;
            }

            foreach ($steps[$currentIndex]->fields() as $field) {
                $this->form->pushField($field);
            }

            return;
        }

        if (! empty($input[static::ALL_STEPS])) {
            foreach ($steps as $FormStep) {
                foreach ($FormStep->fields() as $field) {
                    $this->form->pushField($field);
                }
            }
        }
    }

    /**
     * @return bool
     */
    protected function isFormStepValidationRequest()
    {
        $index = request(static::CURRENT_VALIDATION_STEP);

        return $index !== '' && $index !== null;
    }

    /**
     * Validate step form.
     *
     * @param array $input
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function validateFormStep(array $input)
    {
        // Handle validation errors.
        if ($validationMessages = $this->form->validationMessages($input)) {
            return $this->form->validationErrorsResponse($validationMessages);
        }

        // Stash input data.
        $this->stash($input);

        return JsonResponse::make()
            ->success('Success')
            ->send();
    }

    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|void
     */
    protected function responseCompletionPage()
    {
        return response($this->done()->render());
    }
}
