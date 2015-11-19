<?php

namespace App\Libraries\Language;

use App\Libraries\Booted\BootedTrait;
use Illuminate\Support\ServiceProvider;

class LanguageProvider extends ServiceProvider
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
        app('router')->group(['prefix' => 'locale'], function($router){
            $router->get('/set/{locale}', ['as' => 'setlocale', function($locale){
                return redirect()->back()->withCookie(cookie()->forever('locale', $locale));
            }]);
        });

        app('menu')->handler('language')
            ->addItem(route('setlocale', 'en'), 'English')
            ->addItem(route('setlocale', 'ms'), 'Bahasa Melayu');
    }

    public function booted()
    {
        app()->setLocale(request()->cookie('locale') ?: 'en');
    }
}
