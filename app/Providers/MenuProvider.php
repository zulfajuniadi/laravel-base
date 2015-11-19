<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Libraries\Menu;

class MenuProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        app()->singleton('menu', function(){
            return new Menu;
        });
    }
}
