<?php

namespace App\Http\Middleware;

use Closure;

class MenuMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        app('menu')->buildCurrentRouteMenus();
        return $next($request);
    }
}
