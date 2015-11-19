<?php

namespace App\Http\Middleware;

use Closure;

class ValidationMiddleware
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
        $validation = app()->make('validation')->checkCurrentRoute();
        if ($validation && $validation->fails()) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($validation)
                ->with('warning', trans('validation.error'));
        }
        return $next($request);
    }
}
