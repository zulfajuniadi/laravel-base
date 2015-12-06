<?php

namespace App\Libraries\Installer;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Contracts\Console\Kernel;

class InstallerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:installer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Installs Laravel Base Application';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Kernel $artisan, Filesystem $filesystem)
    {
        parent::__construct();
        $this->artisan = $artisan;
        $this->filesystem = $filesystem;
        $this->env = base_path('.env');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->setupEnvFile();
        $this->setupEnvironment();
        $this->setupDatabase();
        $this->copyModel();
        $this->createSqlite();
        $this->line('App install successful. Run: php artisan migrate --seed');
    }

    protected function setupEnvFile()
    {
        $this->artisan->call('cache:clear');
        $this->artisan->call('config:clear');
        if(!file_exists($this->env)) {
            $this->filesystem->copy(base_path('.env.example'), $this->env);
            $this->laravel['config']['app.key'] = 'SomeRandomString';
            $this->artisan->call('key:generate');
        } else if($this->confirm('[DANGER] Do you want to remove existing env file?', false)) {
            unlink($this->env);
            $this->filesystem->copy(base_path('.env.example'), $this->env);
            $this->laravel['config']['app.key'] = 'SomeRandomString';
            $this->artisan->call('key:generate');
        }
    }

    protected function setupEnvironment()
    {
        $environment = $this->choice('Current Environment?', ['local', 'production'], 0);
        $this->updateEnv('APP_ENV', $environment);
        if($environment == 'local')
            $this->updateEnv('APP_DEBUG', 'true');
        else
            $this->updateEnv('APP_DEBUG', 'false');
    }

    protected function setupDatabase()
    {
        while (!isset($done)) {
            $dbHost = $this->ask('Database Host?', '127.0.0.1');
            $dbName = $this->ask('Database Name?', 'laravel_base_51');
            $dbUser = $this->ask('Database User?', 'root');
            $dbPass = $this->askOptional('Database Password?');
            if ($this->confirm("Is the following correct?\nDatabase Host: {$dbHost}\nDatabase Name: {$dbName}\nDatabase User: {$dbUser}\nDatabase Password: {$dbPass}\n", true)) {
                $this->updateEnv('DB_HOST', $dbHost);
                $this->updateEnv('DB_DATABASE', $dbName);
                $this->updateEnv('DB_USERNAME', $dbUser);
                $this->updateEnv('DB_PASSWORD', $dbPass);
                $done = true;
            }
        }
        $this->artisan->call('cache:clear');
        $this->artisan->call('config:clear');
    }

    public function copyModel()
    {
        $this->filesystem->copy(app_path('Libraries/Installer/source.mwb'), base_path('database/design.mwb'));
    }

    /* Utilities */

    protected function askOptional($question)
    {
        $answer = $this->ask($question, '(empty)');
        return '(empty)' == $answer ? null : $answer;
    }

    protected function updateEnv($key, $value)
    {
        $content = array_reduce(file($this->env), function($carry, $current) use ($key, $value) {
            if(strpos($current, $key) === 0)
                $current = $key .'=' . $value . "\n";
            return $carry . $current;
        },'');
        file_put_contents($this->env, $content);
    }

    protected function createSqlite()
    {
        $this->filesystem->put(storage_path() . '/database.sqlite', '');
    }
}
