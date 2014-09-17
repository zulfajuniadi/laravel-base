<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class AppReset extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'app:reset';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Reset app';

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
	public function fire()
	{
		$this->call('dump-autoload');
		$this->call('cache:clear');
		// $this->call('migrate:refresh');
		$this->call('db:seed');
		File::cleanDirectory(public_path() . '/uploads');
		file_put_contents(public_path() . '/uploads/.gitignore' , "*\n!.gitignore");
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			// array('example', InputArgument::REQUIRED, 'An example argument.'),
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
			// array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

}
