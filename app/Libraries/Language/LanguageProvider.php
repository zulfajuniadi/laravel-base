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
    }

    public function booted()
    {
        $locale = request()->cookie('locale');
        if($locale) {
            app()->setLocale($locale);
        } else {
            app()->setLocale('en');
            cookie()->queue('locale', 'en', 5 * 365 * 24 * 60 * 60);
        }
    }
}
