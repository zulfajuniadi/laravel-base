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

    protected function detectSingularTableName()
    {
        if(str_singular($this->tableName) == $this->tableName) {
            $choice = $this->choice('Singular table name detected.', ['Junction Table', 'Fix: Pluralize', 'Quit'], 1);
            switch ($choice) {
                case 'Junction Table':
                    $this->isJuctionTable = true;
                    $this->line('Junction table chosen. Will only remove migrations.');
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
        $this->tableName = $this->argument('table_name');
        $this->detectSingularTableName();
        app('laravel-base-generator')->erase(
            $this->tableName,
            $this->isJuctionTable
        );
    }
}
