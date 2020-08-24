<?php

namespace App\Admin\Renderable;

use App\Admin\Forms\AdminSetting as AdminSettingForm;
use Dcat\Admin\Support\LazyRenderable;

class AdminSetting extends LazyRenderable
{
    public function render()
    {
        return AdminSettingForm::make();
    }
}
