<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Libraries\Booted\BootedTrait;

class AuthServiceProvider extends ServiceProvider
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
        $menu = app('menu')
            ->handler('auth')
            ->addClass('navbar-right')
            ->addItemIf(auth()->guest(), action('Auth\AuthController@getLogin'), trans('auth.login'))
            ->addItemIf(auth()->guest(), action('Auth\AuthController@getRegister'), trans('auth.register'))
            ->addItemIfNot(auth()->guest(), action('Auth\AuthController@getLogout'), trans('auth.logout'));
        if(!auth()->guest()) {
            $menu->setTitle(auth()->user()->name);
        } else {
            $menu->setType('navbar-inline');
        }
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
