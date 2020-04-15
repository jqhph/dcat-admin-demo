<?php

namespace Dcat\Admin\Extension\GridSortable;

use Dcat\Admin\Admin;
use Dcat\Admin\Grid\Displayers\AbstractDisplayer;

class SortableDisplay extends AbstractDisplayer
{
    protected static $js = [
        'vendor/dcat-admin-extensions/grid-sortable/sortable.min.js',
    ];

    protected function script()
    {
        $id = $this->grid->tableId();

        $script = <<<JS
new Sortable($("#{$id} tbody")[0], {
    handle: '.grid-sortable-handle', // handle's class
    animation: 150,
    onUpdate: function () {
        var sorts = [], tb = $('#{$id}');
        tb.find('.grid-sortable-handle').each(function () {
            sorts.push($(this).data());
        });
        tb.closest('.row').first().find('.grid-save-order-btn').data('sort', sorts).show();
    },
});
JS;

        Admin::script($script);
    }

    protected function getRowSort($sortName)
    {
        return $this->row->{$sortName};
    }

    public function display($sortName = null)
    {
        $this->script();

        $key  = $this->key();
        $sort = $this->getRowSort($sortName);

        return <<<HTML
<a class="grid-sortable-handle" style="cursor:move;" data-key="{$key}" data-sort="{$sort}">
   <i class="fa fa-ellipsis-v"></i>
   <i class="fa fa-ellipsis-v"></i>
</a>
HTML;
    }
}
