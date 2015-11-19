<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Libraries\Validator;

class ValidateProvider extends ServiceProvider
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
        app()->singleton('validation', function() {
            return new Validator;
        });
    }
}
