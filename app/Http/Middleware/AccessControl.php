<?php

namespace App\Http\Middleware;

use Dcat\Admin\Auth\Permission;
use Symfony\Component\HttpFoundation\Request;

class AccessControl
{
    protected $denyMethods = ['POST', 'PUT', 'DELETE'];

    protected $excepts = [
        'POST' => [
            'admin/auth/login'
        ],
    ];

    public function handle(Request $request, \Closure $next)
    {
        if (!config('app.deny_update')) {
            return $next($request);
        }

        foreach ($this->excepts as $method => $route) {
            if ($request->isMethod($method) && $request->is(...$route)) {
                return $next($request);
            }
        }

        if (in_array($request->getMethod(), $this->denyMethods)) {
            Permission::error();
        }

        return $next($request);
    }

}
