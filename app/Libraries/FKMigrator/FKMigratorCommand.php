<?php

namespace App\Libraries\FKMigrator;

use Illuminate\Console\Command;

class FKMigratorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:foreign';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrates Foreign Keys';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        app('fkmigrator')->up();
    }
}
