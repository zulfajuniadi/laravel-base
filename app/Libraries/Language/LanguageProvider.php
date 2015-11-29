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
        foreach (config('locale.languages') as $key => $value) {
            app('menu')->handler('language')->addItem(route('setlocale', $key), $value);
        }
    }

    public function booted()
    {
        app()->setLocale(request()->cookie('locale') ?: 'en');
    }
}
