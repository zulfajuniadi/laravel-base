<?php

namespace App\Libraries\Booted;

use Illuminate\Support\ServiceProvider;

class BootedProvider extends ServiceProvider
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
        app()->singleton('booted', function() {
            return new Booted;
        });
    }
}
