<?php

namespace App\Providers\Modules;

use Illuminate\Support\ServiceProvider;
use App\Libraries\Booted\BootedTrait;
use App\ModelName;

class ModelNamesProvider extends ServiceProvider
{

    use BootedTrait;

    protected $controller = 'App\Http\Controllers\ModelNamesController';

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
        app('policy')->register($this->controller, 'App\Policies\ModelNamesPolicy');

        // register validations
        app('validation')->register($this->controller, 'App\Validators\ModelNamesValidators');

        // module routing
        app('router')->group(['namespace' => 'App\Http\Controllers'], function($router){
            $router->bind('model_names', function($slug) {
                if(!$modelName = (ModelName::whereSlug($slug)->first() ?: ModelName::find($slug)))
                    app()->abort(404);
                return $modelName;
            });
            $router->get('parent-names/{parent_names}/model-names/data', 'ModelNamesController@data');
            $router->get('parent-names/{parent_names}/model-names/{model_names}/duplicate', 'ModelNamesController@duplicate');
            $router->get('parent-names/{parent_names}/model-names/{model_names}/delete', 'ModelNamesController@delete');
            $router->get('parent-names/{parent_names}/model-names/{model_names}/revisions', 'ModelNamesController@revisions');
            $router->resource('parent-names/{parent_names}/model-names', 'ModelNamesController');
        });
    }

    public function booted()
    {
        // register menus
        app('menu')->register($this->controller, 'App\Menus\ModelNamesMenu');
    }


}
