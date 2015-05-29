<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class DestroyViews extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'destroy:datatable';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Destroy Datatable Views. Usage: destroy:datatable todos';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */

    private $argname;
    private $argparams   = [];

    public function fire() {
        $this->getArgumentName();
        $this->makeViewParams();
        $this->cleanupFiles();
    }

    private function getArgumentName() {
        $name = trim($this->argument('name'));
        if ($strlen = mb_strlen($name) === 0) {
            throw new Exception("Name length is 0");
        }
        if (mb_strtolower($name) !== $name) {
            throw new Exception("Name must not have upper case");
        }
        if (mb_strlen(preg_filter('/[a-z_]+/', '', $name)) > 0) {
            throw new Exception("Name must only be of alpha and underscore");
        };
        if (str_plural($name) !== $name) {
            throw new Exception("Name must be in plural form");
        }
        return $this->argname = $name;
    }

    private function makeViewParams() {

        $this->argparams['$VIEWPATH$']        = str_replace('_', '', $this->argname);
        $this->argparams['$CONTROLLER_FILE$'] = str_replace(' ', '', ucwords(str_replace('_', ' ', $this->argname))) . 'Controller';
        $this->argparams['$MODEL_FILE$']      = str_singular(str_replace('Controller', '', $this->argparams['$CONTROLLER_FILE$'])) . '.php';
        $this->argparams['$SEED_FILE$']       = str_replace('Controller', 'TableSeeder', $this->argparams['$CONTROLLER_FILE$']) . '.php';
        $this->argparams['$CONTROLLER_FILE$'] = $this->argparams['$CONTROLLER_FILE$'] . '.php';

    }

    private function cleanupFiles() {
        $modelFile = app_path('models').'/'.$this->argparams['$MODEL_FILE$'];
        if (file_exists($modelFile)) {
            unlink($modelFile);
            echo $modelFile . ' file deleted!' . "\n";
        }

        $controllerFile = app_path('controllers') . '/' . $this->argparams['$CONTROLLER_FILE$'];
        if (file_exists($controllerFile)) {
            unlink($controllerFile);
            echo $controllerFile . ' file deleted!' . "\n";
        }

        $viewDir = app_path('views').'/'.$this->argparams['$VIEWPATH$'];
        if (is_dir($viewDir)) {
            File::deleteDirectory($viewDir);
            echo $viewDir . ' directory deleted!' . "\n";
        }

        $seedFile = app_path('database/seeds').'/'.$this->argparams['$SEED_FILE$'];
        if (file_exists($seedFile)) {
            unlink($seedFile);
            echo $seedFile . ' file deleted!' . "\n";
        }

        $roleSeedFile = app_path('database/seeds').'/roles/Role'.$this->argparams['$SEED_FILE$'];
        if (file_exists($roleSeedFile)) {
            unlink($roleSeedFile);
            echo $roleSeedFile . ' file deleted!' . "\n";
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments() {
        return array(
            array('name', InputArgument::REQUIRED, 'the name of the views in this format: leave_holidays (plural, lower case, underscore separated)'),
        );
    }

}
