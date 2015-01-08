<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class GenerateViews extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'generate:datatable';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Datatable Views. Usage: generate:datatable --fields="Name:name:varchar, Is Done:is_done:boolean" todos true';

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
    private $argfields;
    private $argparams   = [];
    private $no_migration = false;
    private $nesting;

    public function fire() {
        if ($this->argument('no_migration')) {
            $this->no_migration = true;
        } else {
            $this->call('migrate:reset');
        }
        if($this->argument('nesting')) {
            $this->nesting = $this->argument('nesting');
        }
        $this->call('dump-autoload');
        $this->getArgumentFields();
        $this->getGeneratorFields();
        $this->getArgumentName();
        $this->makeViewParams();
        $this->cleanupFiles();
        $this->createRoleSeeder();
        $this->callWayGenerators();
        $this->makeViewFolder();
        $this->makeViews();
        $this->updateController();
        $this->updateModel();
        $this->updateRoleSeeds();
        $this->info("Update your DatabaseSeeder.php file to call the new seeds. Update your routes.php to reflect new routes");
    }

    private function createRoleSeeder() {
        $this->call('generate:seed', array('tableName' => $this->argname, '--templatePath' => app_path('templates').'/datatable-classes/acl_seed.txt'));
        rename($this->seed_file, $this->role_seed_file);
    }

    private function getArgumentFields() {
        $fields = $this->option('fields');
        $fields = explode(',', $fields);
        $return = [];
        foreach ($fields as $field_str) {
            $field                   = explode(':', trim($field_str));
            $return[trim($field[1])] = trim($field[0]);
        }
        $this->argfields = array_filter($return);
    }

    private function getGeneratorFields() {
        $fields = $this->option('fields');
        $fields = explode(',', $fields);
        $return = [];
        foreach ($fields as $field_str) {
            $field = explode(':', trim($field_str));
            array_shift($field);
            $return[] = implode(':', $field);
        }
        $this->genfields = implode(', ', array_filter($return));
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

    private function getNestingModel()
    {
        // trim off _id;
        if($this->nesting){
            $model = substr($this->nesting, 0, (strlen($this->nesting) - 3));
            $model = str_replace('_', ' ', $model);
            $model = ucwords($model);
            return str_replace(' ', '', $model);
        }
        return false;
    }

    private function makeViewParams() {

        /*
        $VIEWPATH$ = 'leaveholidays'
        $MODEL$ = 'LeaveHoliday'
        $RESOURCE$ = 'leaveholiday'
        $TITLE$ = 'Leave Holiday'
        $TITLES$ = 'Leave Holidays'
        $SEED_FILE$ = 'LeaveHolidaysTableSeeder.php'
        $CONTROLLER$ = 'LeaveHolidaysController'
        $CONTROLLER_FILE$ = 'LeaveHolidaysController.php'
        $MODEL_FILE$ = 'LeaveHoliday.php'
        $FORM$ = {{Former::text('name')
        ->required()}}
        $THEADS$ = '<th>field</th>'
        $CONTROLLER_COLUMNS$ = 'leave_holidays.column',\n (4 tab)
        $MODEL_FILLEABLE$ = 'column',\n (2 tab)
        $MODEL_VALIDATION$ = 'column' => 'required',\n (3 tab)
         */

        $table_name                              = $this->argname;
        $this->argparams['$TABLE_NAME$']         = $table_name;
        $this->argparams['$VIEWPATH$']           = $replaced_           = str_replace('_', '', $this->argname);
        $this->argparams['$RESOURCE$']           = str_singular($replaced_);
        $replaced_sp                             = str_replace('_', ' ', $this->argname);
        $this->argparams['$TITLES$']             = $title_case             = ucwords($replaced_sp);
        $this->argparams['$SEED_FILE$']          = str_replace(' ', '', $this->argparams['$TITLES$']).'TableSeeder.php';
        $this->argparams['$CONTROLLER$']         = str_replace(' ', '', $this->argparams['$TITLES$']).'Controller';
        $this->argparams['$CONTROLLER_FILE$']    = str_replace(' ', '', $this->argparams['$CONTROLLER$']).'.php';
        $this->argparams['$TITLE$']              = $title_string              = str_singular($title_case);
        $this->argparams['$MODEL$']              = str_replace(' ', '', $title_string);
        $this->argparams['$MODEL2$']              = $this->argparams['$MODEL$']; // used for controller generation, clashing with way\generators
        $this->argparams['$MODEL_FILE$']         = str_replace(' ', '', $this->argparams['$MODEL$']).'.php';
        $this->argparams['$NESTINGCOL$']         = $this->nesting;
        $this->argparams['$NESTINGMODEL$']       = $this->getNestingModel();
        $this->argparams['$FORM$']               = "\n";
        $this->argparams['$CONTROLLER_COLUMNS$'] = "\n";
        $this->argparams['$MODEL_FILLEABLE$']    = "\n";
        $this->argparams['$MODEL_VALIDATION$']   = "\n";
        $this->argparams['$THEADS$'] = "\n";
        foreach ($this->argfields as $key => $value) {
            if($key !== $this->nesting) {
                $this->argparams['$FORM$'] .= "{{ Former::text('$key')\n";
                $this->argparams['$FORM$'] .= "    ->label('$value')\n";
                $this->argparams['$FORM$'] .= "    ->required() }}\n";
                $this->argparams['$CONTROLLER_COLUMNS$'] .= "                '$table_name.$key',\n";
                $this->argparams['$MODEL_VALIDATION$'] .= "            '$key' => 'required',\n";
                $this->argparams['$THEADS$'] .= "                <th>$value</th>\n";
            }
            $this->argparams['$MODEL_FILLEABLE$'] .= "        '$key',\n";
        }
        foreach ($this->argfields as $key => $value) {
        }
    }

    private function cleanupFiles() {
        $this->model_file = app_path('models').'/'.$this->argparams['$MODEL_FILE$'];
        if (file_exists($this->model_file) && $this->confirm('Model file '.$this->argparams['$MODEL_FILE$'].' exists. Delete? [yes|no]')) {
            unlink($this->model_file);
        }
        $this->controller_file = app_path('controllers').'/'.$this->argparams['$CONTROLLER_FILE$'];
        if (file_exists($this->controller_file) && $this->confirm('Controller file '.$this->argparams['$CONTROLLER_FILE$'].' exists. Delete? [yes|no]')) {
            unlink($this->controller_file);
        }
        $this->view_dir = app_path('views').'/'.$this->argparams['$VIEWPATH$'];
        if (is_dir($this->view_dir) && $this->confirm('View directory '.$this->argparams['$VIEWPATH$'].' exists. Delete? [yes|no]')) {
            $dir   = $this->view_dir;
            $files = array_diff(scandir($dir), array('.', '..'));
            foreach ($files as $file) {
                (is_dir("$dir/$file"))?delTree("$dir/$file"):unlink("$dir/$file");
            }
            rmdir($dir);
        }
        $this->seed_file = app_path('database/seeds').'/'.$this->argparams['$SEED_FILE$'];
        if (file_exists($this->seed_file) && $this->confirm('Seed file '.$this->argparams['$SEED_FILE$'].' exists. Delete? [yes|no]')) {
            unlink($this->seed_file);
        }
        $this->role_seed_file = app_path('database/seeds').'/roles/Role'.$this->argparams['$SEED_FILE$'];
        if (file_exists($this->role_seed_file) && $this->confirm('Role seed file Role'.$this->argparams['$SEED_FILE$'].' exists. Delete? [yes|no]')) {
            unlink($this->role_seed_file);
        }
        if (!$this->no_migration) {
            $this->migration_dir = app_path('database/migrations');
            $migration_files     = scandir($this->migration_dir);
            foreach ($migration_files as $name) {
                if (stristr($name, $this->argname) && $this->confirm('Migration file '.$name.' exists. Delete? [yes|no]')) {
                    unlink($this->migration_dir.'/'.$name);
                }
            }
        }
    }

    private function callWayGenerators() {
        $this->call('generate:seed', ['tableName' => $this->argparams['$TABLE_NAME$']]);
        $this->call('generate:model', ['modelName' => $this->argparams['$MODEL$'], '--templatePath' => app_path('/templates/datatable-classes/model.txt')]);
        if($this->nesting) {
            $this->call('generate:controller', ['controllerName' => $this->argparams['$CONTROLLER$'], '--templatePath' => app_path('/templates/datatable-classes/controller-nested.txt')]);
        } else {
            $this->call('generate:controller', ['controllerName' => $this->argparams['$CONTROLLER$'], '--templatePath' => app_path('/templates/datatable-classes/controller-top.txt')]);
        }
        if (!$this->no_migration) {
            $this->call('generate:migration', ['migrationName' => 'create_'.$this->argparams['$VIEWPATH$'].'_table', '--fields' => $this->genfields]);
        }
    }

    private function makeViewFolder() {
        if (file_exists($this->view_dir)) {
            $dir   = $this->view_dir;
            $files = array_diff(scandir($dir), array('.', '..'));
            foreach ($files as $file) {
                (is_dir("$dir/$file"))?delTree("$dir/$file"):unlink("$dir/$file");
            }
            rmdir($dir);
        }
        mkdir($this->view_dir);
    }

    private function makeViews() {
        if($this->nesting) {
            $this->templatepath = app_path().'/templates/datatables-nested';
        } else {
            $this->templatepath = app_path().'/templates/datatables-top';
        }
        $templates          = scandir($this->templatepath);
        foreach ($templates as $template_filename) {
            if (stristr($template_filename, '.txt')) {
                $filestr = file_get_contents($this->templatepath.'/'.$template_filename);
                foreach ($this->argparams as $key => $value) {
                    $filestr = str_replace($key, $value, $filestr);
                }
                $newfilename = $this->view_dir.'/'.str_replace('.txt', '.blade.php', $template_filename);
                file_put_contents($newfilename, $filestr);
            }
        }
    }

    private function updateController() {
        $controller_contents = file_get_contents($this->controller_file);
        foreach ($this->argparams as $key => $value) {
            $controller_contents = str_replace($key, $value, $controller_contents);
        }
        file_put_contents($this->controller_file, $controller_contents);
    }

    private function updateModel() {
        $model_contents = file_get_contents($this->model_file);
        foreach ($this->argparams as $key => $value) {
            $model_contents = str_replace($key, $value, $model_contents);
        }
        file_put_contents($this->model_file, $model_contents);
    }

    private function updateRoleSeeds() {
        $role_seed_contents = file_get_contents($this->role_seed_file);
        foreach ($this->argparams as $key => $value) {
            $role_seed_contents = str_replace($key, $value, $role_seed_contents);
        }
        file_put_contents($this->role_seed_file, $role_seed_contents);
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments() {
        return array(
            array('name', InputArgument::REQUIRED, 'the name of the views in this format: leave_holidays (plural, lower case, uderscore separated)'),
            array('no_migration', InputArgument::OPTIONAL, 'If true, will not generate migrations'),
            array('nesting', InputArgument::OPTIONAL, 'Foreign Key column for nestng in this format: leave_holiday_id'),
        );
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions() {
        return array(
            array('fields', null, InputOption::VALUE_REQUIRED, 'Field names separated in this format: Name:name:string, ', 'Name:name:string'),
        );
    }

}
