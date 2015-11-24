<?php

namespace App\Libraries\Degenerator;

use Illuminate\Console\Command;

class DegeneratorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'erase:module
        {table_name : Database table name. For example: school_grades}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Erases a Laravel Base Scaffold';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        app('laravel-base-generator')->erase(
            $this->argument('table_name')
        );
    }
}
