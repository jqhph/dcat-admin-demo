<?php

namespace Dcat\Page\Admin\Grid;

use Dcat\Admin\Admin;
use Illuminate\Contracts\Support\Renderable;

class CreateAppButton implements Renderable
{
    public function render()
    {
        $this->setupScript();

        $label = '创建应用';

        $submit = trans('admin.submit');

        return <<<HTML
<button id='create-cms-app' class='btn btn-outline-success'><i class="feather icon-plus"></i><span class='hidden-xs'> &nbsp;$label</span></button>
<template id="create-app-input">
    <div class="filter-input col-sm-12 mt-1" style="">
        <div class="form-group">
            <error></error>
            <div class="input-group input-group-sm">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-white"><i class="feather icon-edit-2"></i></span>
                </div>
                <input type="text" class="form-control" placeholder="Application Name" name="name" value="">
                &nbsp;&nbsp; <span id="submit-create"  class="btn btn-primary btn-sm waves-effect waves-light">{$submit}</span>
            </div>
        </div>
    </div>
</template>
HTML;
    }

    protected function setupScript()
    {
        $url = admin_base_path('dcat-page/create-app');

        Admin::script(
            <<<JS
            
$('#create-cms-app').popover({
    html: true,
    content: $($('#create-app-input').html())
});

$('#create-cms-app').on('shown.bs.popover', function () {
    var errTpl = '<label class="control-label"><i class="fa fa-times-circle-o"></i> {msg}</label>';
    $('#submit-create').click(function () {
        var _name = $('input[name="name"]'),
            name = _name.val();
        
        if (!name) {
            return displayError(_name, 'The application name is required.');
        }
        if (!isValid(name) || name.indexOf('/') !== -1) {
            return displayError(_name, 'The "'+name+'" is not a valid application name, please input a name like "dcat-page".');
        }
        removeError(_name);
        
        $('.popover').loading();
        $.post('$url', {
            _token: Dcat.token,
            name: name,
        }, function (response) {
            $('.popover').loading(false);
        
           if (!response.status) {
               Dcat.error(response.message);
           } else {
               $('#create-cms-app').popover('hide');
           }
           
           Dcat.onPjaxComplete(function () { // 跳转新页面时移除弹窗
                $('.content-body').prepend('<div class="row"><div class="col-md-12">'+response.content+'</div></div>');
           });
           Dcat.reload();
           
        });
        
    });
    
    function displayError(obj, msg) {
        obj.parents('.form-group').addClass('has-error');
        obj.parents('.form-group').find('error').html(errTpl.replace('{msg}', msg));
    }
    
    function removeError(obj) {
        obj.parents('.form-group').removeClass('has-error');
        obj.parents('.form-group').find('error').html('');
    }
    
    function isValid(str) { 
        return /^[\w-\/\\\\]+$/.test(str); 
    }
    
});

JS
        );
    }
}
