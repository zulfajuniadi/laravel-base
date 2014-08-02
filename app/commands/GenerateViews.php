<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

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
	protected $description = 'Generate Datatable Views';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	
	private $argname;
	private $argfields;
	private $argparams = [];

	public function fire()
	{
		$this->getArgumentFields();
		$this->getArgumentName();
		$this->makeViewParams();
		$this->makeViewFolder();
		$this->makeViews();
		
		// dd($this->argparams);
	}

	private function makeViews()
	{
		$this->templatepath = app_path() . '/templates/datatables';
		$templates = scandir($this->templatepath);
		foreach ($templates as $template_filename) {
			if(stristr($template_filename, '.txt')) {
				$filestr = file_get_contents($this->templatepath . '/' . $template_filename);
				foreach ($this->argparams as $key => $value) {
					$filestr = str_replace($key, $value, $filestr);
				}
				$newfilename = $this->basepath . '/' . str_replace('.txt', '.blade.php', $template_filename);
				file_put_contents($newfilename, $filestr);
			}
		}
	}

	private function makeViewFolder()
	{
		$this->basepath = app_path() . '/views/' . $this->argparams['$VIEWPATH$'];
		if(file_exists($this->basepath)) {
			if ($this->confirm('Folder '.$this->argparams['$VIEWPATH$'].' exists. Overwrite? [yes|no]'))
			{
				$dir = $this->basepath;
				$files = array_diff(scandir($dir), array('.','..')); 
				foreach ($files as $file) { 
				  (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file"); 
				} 
				rmdir($dir); 
			}
			else
			{
				throw new Exception("View folder exists");
			}
		}
		mkdir($this->basepath);
	}

	private function getArgumentFields()
	{
		$fields = $this->argument('fields');
		$fields = explode(',', $fields);
		$return = [];
		foreach ($fields as $field_str) {
			$field = explode(':', trim($field_str));
			$return[trim($field[0])] = isset($field[1]) ? trim($field[1]) : trim($field[0]);
		}
		$this->argfields = array_filter($return);
	}

	private function makeViewParams()
	{
		$this->argparams['$VIEWPATH$'] = $replaced_ = str_replace('_', '', $this->argname);
		$this->argparams['$RESOURCE$'] = str_singular($replaced_);
		$replaced_sp = str_replace('_', ' ', $this->argname);
		$this->argparams['$TITLES$'] = $ucwords = ucwords($replaced_sp);
		$this->argparams['$TITLE$'] = $titsing = str_singular($ucwords);
		$this->argparams['$MODEL$'] = str_replace(' ', '', $titsing);
		$this->argparams['$FORM$'] = "\n";
		foreach ($this->argfields as $key => $value) {
			$this->argparams['$FORM$'] .= "{{ Former::text('$key')\n";
			$this->argparams['$FORM$'] .= "  ->label('$value')\n";
			$this->argparams['$FORM$'] .= "  ->required() }}\n\n";
		}
		$this->argparams['$THEADS$'] = "\n";
		foreach ($this->argfields as $key => $value) {
			$this->argparams['$THEADS$'] .= "    <th>$value</th>\n";
		}
	}

	private function getArgumentName()
	{
		$this->argname = $this->checkName();
	}

	private function checkName()
	{
		$name = trim($this->argument('name'));
		if($strlen = mb_strlen($name) === 0) {
			throw new Exception("Name length is 0");
		}
		if(mb_strtolower($name) !== $name){
			throw new Exception("Name must not have upper case");	
		}
		if(mb_strlen(preg_filter('/[a-z_]+/','', $name)) > 0){
			throw new Exception("Name must only be of alpha and underscore");	
		};
		if(str_plural($name) !== $name) {
			throw new Exception("Name must be in plural form");	
		}
		return $name;
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('fields', InputArgument::REQUIRED, 'Field names separated in this format: name:Name, '),
			array('name', InputArgument::REQUIRED, 'the name of the views in this format: leave_holidays (plural, lower case, uderscore separated)'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			
		);
	}

}
