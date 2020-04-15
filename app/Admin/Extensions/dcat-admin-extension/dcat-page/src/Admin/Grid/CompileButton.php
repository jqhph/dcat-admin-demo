<?php

namespace Dcat\Page\Admin\Grid;

use Dcat\Admin\Admin;
use Illuminate\Contracts\Support\Renderable;

class CompileButton implements Renderable
{
    public function render()
    {
        $this->setupScript();

        return "<button class='compile-app btn btn-outline-primary'><i class='feather icon-edit-1'></i><span class='hidden-xs'>&nbsp; 编译</span></button>&nbsp; ";
    }

    protected function setupScript()
    {
        $submit = trans('admin.submit');

        $url = admin_base_path('dcat-page/compile-app');

        Admin::html(
            <<<HTML
<template id="compile-app-input">
    <div class="filter-input col-sm-12 mt-1" style="">
        <div class="form-group">
            <error></error>
            <div class="input-group input-group-sm">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-white"><i class="feather icon-edit-2"></i></span>
                </div>
                <input type="text" class="form-control" placeholder="Dir" name="dir" value="">
                &nbsp;&nbsp; <span id="submit-create"  class="btn btn-primary btn-sm waves-effect waves-light">{$submit}</span>
            </div>
        </div>
    </div>
</template>
HTML
        );

        Admin::script(
            <<<JS
            
$('.compile-app').popover({
    html: true,
    placement: 'bottom',
    content: $($('#compile-app-input').html())
});

$('.compile-app').on('shown.bs.popover', function () {
    var errTpl = '<label class="control-label"><i class="fa fa-times-circle-o"></i> {msg}</label>';
    var name = $(this).data('app');
    
    $('#submit-create').click(function () {
        var _dir = $('input[name="dir"]'),
            dir = _dir.val();
        
        if (dir && (!isValid(dir) || dir.indexOf('/') !== -1)) {
            return displayError(_dir, 'The "'+dir+'" is not a valid dir name, please input a name like "dcat-page".');
        }
        removeError(_dir);
        
        $('.popover').loading();
        $.post('$url', {
            _token: Dcat.token,
            dir: dir,
            name: name,
        }, function (response) {
            $('.popover').loading(false);
        
           if (!response.status) {
               Dcat.error(response.message);
           } else {
               $('.compile-app').popover('hide');
           }
           
           $('.content-body').prepend('<div class="row"><div class="col-md-12">'+response.content+'</div></div>');
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
