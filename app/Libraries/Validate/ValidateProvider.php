<?php

namespace App\Libraries\Validate;

use Illuminate\Support\ServiceProvider;

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
