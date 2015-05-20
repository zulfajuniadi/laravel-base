<?php

use Symfony\Component\Yaml\Yaml;

class ConfigsController extends \BaseController {


    private function loadYaml($type)
    {
        if(!file_exists($file = app_path() . "/config/{$type}.yaml"))
            throw new Exception("{$file} not found");

        return Yaml::parse(file_get_contents($file));
    }

    public function getShow($type)
    {
        $meta = $this->loadYaml($type);
        Breadcrumbs::push(action('ConfigsController@getShow', $type), $meta['config_title']);
        return View::make('configs.show', [
            'meta'    => $meta,
            'configs' => Config::get($type),
            'type'    => $type
        ]);
    }

    public function getEdit($type)
    {
        $meta = $this->loadYaml($type);
        Breadcrumbs::push(action('ConfigsController@getShow', $type), $meta['config_title']);
        Breadcrumbs::push(action('ConfigsController@getEdit', $type), 'Edit');
        return View::make('configs.edit', [
            'meta'    => $this->loadYaml($type),
            'configs' => Config::get($type),
            'type'    => $type
        ]);

    }

    public function postEdit($type)
    {
        $meta = $this->loadYaml($type);
        $configs = [];

        foreach($meta['sections'] as $section => $fields) {
            $configs[$section] = [];
            foreach ($fields as $name => $values) {
                $configs[$section][$name] = Input::get($name);
            }
        }

        if(!file_exists($file = app_path() . "/config/{$type}.php"))
            throw new Exception("{$file} not found");

        file_put_contents($file, "<?php\n\nreturn " . var_export($configs, true) . ';');

        return Redirect::action('ConfigsController@getShow', $type)
            ->with('notification:success', 'Config Updated');

    }

    public function __construct()
    {
        parent::__construct();
        View::share('controller', 'Config');
        if(!Auth::user()->hasRole('Admin'))
            App::abort(403, 'Unauthorized');
    }

}
