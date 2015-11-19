<?php

namespace App\Libraries\Menu;

use Closure;

class Menu
{
    private $menus = [];
    private $registered = [];

    public function handler($name)
    {
        if(!isset($this->menu[$name])) {
            $this->menu[$name] = new MenuHandler();
        }
        return $this->menu[$name];
    }

    public function buildCurrentRouteMenus()
    {
        $route = app()->make('router')->current();
        $currentRoute = $route->getAction()['uses'];
        list($controller, $action) = explode('@', $currentRoute);
        if(isset($this->registered[$controller]) && method_exists($this->registered[$controller], $action)) {
            call_user_func_array([$this->registered[$controller], $action], [$route->parameters()]);
        }
    }

    public function register($controller, $menuClass)
    {
        $this->registered[$controller] = new $menuClass;
    }

}