<?php

namespace App\Libraries\Policy;

class Policy
{

    protected $policies = [];
    private $cached = [];

    public function check($controller, $action, $parameters = [])
    {
        //  Handle null parameters
        $parameters = $parameters ?: [];

        if(!isset($this->policies[$controller]))
            throw new Exceptions\PolicyDoesNotExists($controller);

        $handler = $this->getPolicy($controller);
        if(!method_exists($handler, $action))
            throw new Exceptions\PolicyMethodDoesNotExists($controller, $action);

        return call_user_func_array([$handler, $action], $parameters);
    }

    public function checkCurrentRoute()
    {
        $route = app()->make('router')->current();
        list($controller, $action) = explode('@', $route->getAction()['uses']);
        return $this->check($controller, $action, $route->parameters());
    }

    public function register($controller, $handler)
    {
        $this->policies[$controller] = $handler;
    }

    protected function getPolicy($controller)
    {
        if(!isset($this->cached[$controller]))
            $this->cached[$controller] = new $this->policies[$controller];
        return $this->cached[$controller];
    }

}