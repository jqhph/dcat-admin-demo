<?php

namespace Dcat\Admin\OperationLog\Http\Middleware;

use Dcat\Admin\Admin;
use Dcat\Admin\OperationLog\Models\OperationLog as OperationLogModel;
use Dcat\Admin\OperationLog\OperationLogServiceProvider;
use Dcat\Admin\Support\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LogOperation
{
    protected $secretFields = [
        'password',
        'password_confirmation',
    ];

    protected $except = [
        'dcat-admin.operation-log.*',
    ];

    protected $defaultAllowedMethods = ['GET', 'HEAD', 'POST', 'PUT', 'DELETE', 'CONNECT', 'OPTIONS', 'TRACE', 'PATCH'];

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle(Request $request, \Closure $next)
    {
        if ($this->shouldLogOperation($request)) {
            $user = Admin::user();

            $log = [
                'user_id' => $user ? $user->id : 0,
                'path'    => substr($request->path(), 0, 255),
                'method'  => $request->method(),
                'ip'      => $request->getClientIp(),
                'input'   => $this->formatInput($request->input()),
            ];

            try {
                OperationLogModel::create($log);
            } catch (\Exception $exception) {
                // pass
            }
        }

        return $next($request);
    }

    /**
     * @param array $input
     *
     * @return string
     */
    protected function formatInput(array $input)
    {
        foreach ($this->getSecretFields() as $field) {
            if ($field && ! empty($input[$field])) {
                $input[$field] = Str::limit($input[$field], 3, '******');
            }
        }

        return json_encode($input, JSON_UNESCAPED_UNICODE);
    }

    /**
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    protected function setting($key, $default = null)
    {
        return OperationLogServiceProvider::setting($key, $default);
    }

    /**
     * @param Request $request
     *
     * @return bool
     */
    protected function shouldLogOperation(Request $request)
    {
        return ! $this->inExceptArray($request)
            && $this->inAllowedMethods($request->method());
    }

    /**
     * Whether requests using this method are allowed to be logged.
     *
     * @param string $method
     *
     * @return bool
     */
    protected function inAllowedMethods($method)
    {
        $allowedMethods = collect($this->getAllowedMethods())->filter();

        if ($allowedMethods->isEmpty()) {
            return true;
        }

        return $allowedMethods->map(function ($method) {
            return strtoupper($method);
        })->contains($method);
    }

    /**
     * Determine if the request has a URI that should pass through CSRF verification.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return bool
     */
    protected function inExceptArray($request)
    {
        if ($request->routeIs(admin_api_route_name('value'))) {
            return true;
        }

        foreach ($this->except() as $except) {
            if ($request->routeIs($except)) {
                return true;
            }

            $except = admin_base_path($except);

            if ($except !== '/') {
                $except = trim($except, '/');
            }

            if (Helper::matchRequestPath($except)) {
                return true;
            }
        }

        return false;
    }

    protected function except()
    {
        return array_merge((array) $this->setting('except'), $this->except);
    }

    protected function getSecretFields()
    {
        return array_merge((array) $this->setting('secret_fields'), $this->secretFields);
    }

    protected function getAllowedMethods()
    {
        return (array) ($this->setting('allowed_methods') ?: $this->defaultAllowedMethods);
    }
}
