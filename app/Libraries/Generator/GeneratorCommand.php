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
        {relationships? : Model relationships separated by "|". For example: belongsTo:Country:countries:country_id|hasMany:Children:children:parent_id|hasOne:Profile:user_profile:profile_id}
        {--nesting= : Route nesting configuration following ModelName:foreign_key:route-binding. For example: UserBlacklists:user_blacklist_id:user-blacklists}
        ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scaffolds a Laravel Base module';

    protected function detectSingularTableName()
    {
        if(str_singular($this->tableName) == $this->tableName) {
            $choice = $this->choice('Singular table name detected.', ['Junction Table', 'Fix: Pluralize', 'Quit'], 1);
            switch ($choice) {
                case 'Junction Table':
                    $this->isJuctionTable = true;
                    $this->line('Junction table chosen. Will only generate migrations.');
                    break;
                case 'Fix: Pluralize':
                    $this->tableName = str_plural($this->tableName);
                    $this->line('Table name updated to: ' . $this->tableName);
                    break;
                case 'Quit':
                default:
                    $this->line('Exiting.');
                    exit(0);
                    break;
            }
        }
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->isJuctionTable = false;
        $this->nesting = false;
        if($this->option('nesting')) {
            $this->nesting = explode(':', $this->option('nesting'));
        }
        $this->tableName = $this->argument('table_name');
        $this->detectSingularTableName();
        $relationships = [];
        if($str = $this->argument('relationships')) {
            $relationships = array_map(function($params){
                return explode(':', $params);
            }, explode('|', $str));
        }
        app('laravel-base-generator')->make(
            $this->tableName,
            array_map(function($params){
                return explode(':', $params);
            }, explode('|', $this->argument('fields'))),
            $relationships,
            $this->isJuctionTable,
            $this->nesting
        );
    }
}
