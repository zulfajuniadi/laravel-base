<?php

namespace App\Libraries\Menu;

use Illuminate\Support\ServiceProvider;
use App\Libraries\Booted\BootedTrait;

class AuthMenuServiceProvider extends ServiceProvider
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

    public function booted()
    {
        app('App\Menus\AuthMenu')->make();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
