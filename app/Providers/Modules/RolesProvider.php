<?php

namespace App\Providers\Modules;

use Illuminate\Support\ServiceProvider;
use App\Libraries\Booted\BootedTrait;
use App\Role;

class RolesProvider extends ServiceProvider
{

    use BootedTrait;

    protected $controller = 'App\Http\Controllers\RolesController';

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
        app('policy')->register($this->controller, 'App\Policies\RolesPolicy');

        // register validations
        app('validation')->register($this->controller, 'App\Validators\RolesValidators');

        // module routing
        app('router')->group(['namespace' => 'App\Http\Controllers', 'prefix' => 'admin'], function($router){
            $router->bind('roles', function($slug) {
                if(!$role = (Role::whereSlug($slug)->first() ?: Role::find($slug)))
                    app()->abort(404);
                return $role;
            });
            $router->get('roles/data', 'RolesController@data');
            $router->get('roles/{roles}/duplicate', 'RolesController@duplicate');
            $router->get('roles/{roles}/delete', 'RolesController@delete');
            $router->get('roles/{roles}/revisions', 'RolesController@revisions');
            $router->resource('roles', 'RolesController');
        });
    }

    public function booted()
    {
        // register menus
        app('menu')->register($this->controller, 'App\Menus\RolesMenu');
    }


}
