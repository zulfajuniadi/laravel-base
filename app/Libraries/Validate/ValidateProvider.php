<?php

namespace App\Libraries\Validate;

use Illuminate\Support\ServiceProvider;
use App\Libraries\Booted\BootedTrait;

class ValidateProvider extends ServiceProvider
{
    use BootedTrait;

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
        app()->singleton('validation', function() {
            return new Validator;
        });
    }

    public function booted()
    {
        app('validator')->extend('matchesHashedPassword', function($attribute, $value, $parameters)
        {
            if(!app('hash')->check($value, $parameters[0]))
            {
                return false;
            }
            return true;
        });
    }
}
