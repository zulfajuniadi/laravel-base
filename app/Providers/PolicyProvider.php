<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Libraries\Policy;

class PolicyProvider extends ServiceProvider
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
        app()->singleton('policy', function(){
            return new Policy();
        });
    }
}
