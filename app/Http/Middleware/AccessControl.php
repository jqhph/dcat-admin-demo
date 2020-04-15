<?php

namespace App\Http\Middleware;

use Dcat\Admin\Auth\Permission;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AccessControl
{
    protected $denyMethods = ['POST', 'PUT', 'DELETE'];

    protected $excepts = [
        'POST' => [
            'admin/auth/login',
            'admin/form/step',
            'admin/form',
            'admin/dcat-api/value',
            'admin/helpers/scaffold/table',
        ],
    ];

    public function handle(Request $request, \Closure $next)
    {
        if (! config('app.deny_update')) {
            return $next($request);
        }

        foreach ($this->excepts as $method => $route) {
            if ($request->isMethod($method) && $request->is(...$route)) {
                return $next($request);
            }
        }

        if (in_array($request->getMethod(), $this->denyMethods)) {
            try {
                Permission::error();
            } catch (HttpException $e) {
                return response()->json([
                    'status'  => false,
                    'message' => '对不起，演示站点不支持修改数据。',
                ]);
            }
        }

        return $next($request);
    }

}
