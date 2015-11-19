<?php

namespace App\Libraries\Validate;

class Validator
{

    private $validators = [];
    private $cached = [];

    public function register($namespace, $class)
    {
        $this->validators[$namespace] = $class;
    }

    public function check($controller, $action, $parameters = [])
    {
        //  Handle null parameters
        $parameters = $parameters ?: [];

        if(!isset($this->validators[$controller]))
            throw new Exceptions\ValidationDoesNotExists($controller);

        $handler = $this->getValidationRules($controller);
        if(!method_exists($handler, $action))
            return;

        return call_user_func_array([$handler, 'validate'], [$action, $parameters]);
    }

    public function checkCurrentRoute()
    {
        $route = app()->make('router')->current();
        list($controller, $action) = explode('@', $route->getAction()['uses']);
        return $this->check($controller, $action, $route->parameters());
    }

    protected function getValidationRules($controller)
    {
        if(!isset($this->cached[$controller]))
            $this->cached[$controller] = new $this->validators[$controller];
        return $this->cached[$controller];
    }
}