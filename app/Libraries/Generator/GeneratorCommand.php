<?php

namespace App\Libraries\Generator;

use Illuminate\Console\Command;

class GeneratorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module
        {table_name : Database table name. For example: user_tasks}
        {fields : Field definitions separated by "|". For example: name:Name:string|completed_at:Completed At:dateTime|is_completed:Is Completed:boolean}
        {relationships? : Model relationships separated by "|". For example: belongsTo:Country:countries:country_id|belongsToMany:Role:roles:user_roles:user_id:role_id|hasMany:Children:children:parent_id|hasOne:Profile:user_profile:profile_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scaffolds a Laravel Base module';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        app('laravel-base-generator')->make(
            $this->argument('table_name'),
            array_map(function($params){
                return explode(':', $params);
            }, explode('|', $this->argument('fields'))),
            array_map(function($params){
                return explode(':', $params);
            }, explode('|', $this->argument('relationships')))
        );
    }
}
