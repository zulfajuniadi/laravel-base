<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Libraries\Booted;

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
