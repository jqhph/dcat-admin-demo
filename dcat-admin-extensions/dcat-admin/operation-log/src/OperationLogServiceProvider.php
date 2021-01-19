<?php

namespace Dcat\Admin\OperationLog;

use Dcat\Admin\Extend\ServiceProvider;
use Dcat\Admin\OperationLog\Http\Middleware\LogOperation;

class OperationLogServiceProvider extends ServiceProvider
{
    protected $middleware = [
        'middle' => [
            LogOperation::class,
        ],
    ];

    protected $menu = [
        [
            'title' => 'Operation Log',
            'uri'   => 'auth/operation-logs',
        ],
    ];

    public function settingForm()
    {
        return new Setting($this);
    }
}
