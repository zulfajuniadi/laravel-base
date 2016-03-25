<?php

namespace App\Libraries\FKMigrator;

use Illuminate\Support\ServiceProvider;

class FKMigratorProvider extends ServiceProvider
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
        app()->singleton('fkmigrator', function() {
            return new FKMigrator;
        });
    }
}
