<?php

namespace Dcat\Page\Http\Middleware;

use Dcat\Page\DcatPage;
use Illuminate\Http\Request;

class Initialization
{
    /**
     * @param Request  $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle($request, $next)
    {
        DcatPage::init(
            $request->route()->parameter('app')
        );

        return $next($request);
    }
}
