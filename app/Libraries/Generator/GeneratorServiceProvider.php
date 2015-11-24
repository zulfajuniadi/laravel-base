<?php

namespace App\Libraries\Generator;

use Illuminate\Support\ServiceProvider;
use App\Libraries\Generator\Fields\Form;

class GeneratorServiceProvider extends ServiceProvider
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
        app()->singleton('laravel-base-generator', function(){
            return new Generator;
        });
        app()->bind('laravel-base-generator.form', function(){
            return new Fields\Form();
        });
        app()->bind('laravel-base-generator.show', function(){
            return new Fields\Show();
        });
        app()->bind('laravel-base-generator.lang', function(){
            return new Fields\Lang();
        });
        app()->bind('laravel-base-generator.index', function(){
            return new Fields\Index();
        });
        app()->bind('laravel-base-generator.migration', function(){
            return new Fields\Migration();
        });
        app()->bind('laravel-base-generator.fillable', function(){
            return new Fields\Fillable();
        });
        app()->bind('laravel-base-generator.migrationfkup', function(){
            return new Fields\MigrationFkUp();
        });
        app()->bind('laravel-base-generator.migrationfkdown', function(){
            return new Fields\MigrationFkDown();
        });
        app()->bind('laravel-base-generator.modelfkmethods', function(){
            return new Fields\ModelFkMethods();
        });
        app()->bind('laravel-base-generator.validation', function(){
            return new Fields\Validation();
        });
        app()->bind('laravel-base-generator.migrationmanytomanyup', function(){
            return new Fields\MigratonManyToManyUp();
        });
        app()->bind('laravel-base-generator.migrationmanytomanydown', function(){
            return new Fields\MigratonManyToManyDown();
        });
        app()->bind('laravel-base-generator.revisionablename', function(){
            return new Fields\RevisionableName();
        });
        app()->bind('laravel-base-generator.revisionablevalue', function(){
            return new Fields\RevisionableValue();
        });
    }
}
