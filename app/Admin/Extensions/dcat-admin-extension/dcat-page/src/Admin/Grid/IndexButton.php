<?php

namespace Dcat\Page\Admin\Grid;

use Dcat\Admin\Admin;
use Illuminate\Contracts\Support\Renderable;

class IndexButton implements Renderable
{
    public function render()
    {
        $this->setupScript();

        return "<button class='index-app btn btn-outline-primary'><i class='feather icon-server'></i><span class='hidden-xs'>&nbsp; 索引</span></button>&nbsp; ";
    }

    protected function setupScript()
    {
        $url = admin_base_path('dcat-page/index-app');

        Admin::script(
            <<<JS

$('.index-app').on('click', function () {
    var name = $(this).data('app'), self = $(this);
    
    Dcat.loading();
    $.post('$url', {
        _token: Dcat.token,
        name: name,
    }, function (response) {
         Dcat.loading(false);
    
       if (!response.status) {
           Dcat.error(response.message);
       }
       
       $('.content-body').prepend('<div class="row"><div class="col-md-12">'+response.content+'</div></div>');
    });
    
});

JS
        );
    }
}
