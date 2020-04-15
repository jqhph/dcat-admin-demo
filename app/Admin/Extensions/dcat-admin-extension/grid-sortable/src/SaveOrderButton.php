<?php

namespace Dcat\Admin\Extension\GridSortable;

use Dcat\Admin\Admin;
use Dcat\Admin\Grid\Tools\AbstractTool;

class SaveOrderButton extends AbstractTool
{
    protected $sortColumn;

    public function __construct($column)
    {
        $this->sortColumn = $column;
    }

    protected function script()
    {
        $route = admin_base_path('extension/grid-sort');
        $class = $this->parent->model()->getRepository()->getOriginalClassName();
        $class = str_replace('\\', '\\\\', $class);

        return <<<JS
$('.grid-save-order-btn').click(function () {
    $.post('{$route}', {
        _token: LA.token,
        _model: '{$class}',
        _sort: $(this).data('sort'),
        _column: '{$this->sortColumn}',
    },
    function(data){
    
        if (data.status) {
            LA.success(data.message);
            LA.reload();
        } else {
            LA.error(data.message);
        }
    });
});
JS;
    }

    public function render()
    {
        Admin::script($this->script());

        $text = admin_trans_label('Save order');

        return <<<HTML
<button type="button" class="btn btn-sm btn-custom grid-save-order-btn" style="margin-left:8px;display:none;">
    <i class="fa fa-save"></i><span class="hidden-xs">&nbsp;&nbsp;{$text}</span>
</button>
HTML;
    }
}

