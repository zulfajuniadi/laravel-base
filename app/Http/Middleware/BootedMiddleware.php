<?php

namespace App\Http\Middleware;

use Closure;

class BootedMiddleware
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
        app('events')->fire('booted');
        return $next($request);
    }
}
