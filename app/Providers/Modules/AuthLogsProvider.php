<?php

namespace App\Providers\Modules;

use Illuminate\Support\ServiceProvider;
use App\Libraries\Booted\BootedTrait;
use App\AuthLog;

class AuthLogsProvider extends ServiceProvider
{

    use BootedTrait;

    protected $controller = 'App\Http\Controllers\AuthLogsController';

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->bootBootedTrait();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

        // register policies
        app('policy')->register($this->controller, 'App\Policies\AuthLogsPolicy');

        // register validations
        app('validation')->register($this->controller, 'App\Validators\AuthLogsValidators');

        // module routing
        app('router')->group(['namespace' => 'App\Http\Controllers', 'prefix' => 'admin'], function($router){
            $router->bind('auth_logs', function($slug) {
                if(!$authLog = (AuthLog::whereSlug($slug)->first() ?: AuthLog::find($slug)))
                    app()->abort(404);
                return $authLog;
            });
            $router->get('auth-logs/data', 'AuthLogsController@data');
            $router->get('auth-logs/{auth_logs}/duplicate', 'AuthLogsController@duplicate');
            $router->get('auth-logs/{auth_logs}/delete', 'AuthLogsController@delete');
            $router->get('auth-logs/{auth_logs}/revisions', 'AuthLogsController@revisions');
            $router->resource('auth-logs', 'AuthLogsController');
        });
    }

    public function booted()
    {
        // register menus
        app('menu')->register($this->controller, 'App\Menus\AuthLogsMenu');
    }


}
