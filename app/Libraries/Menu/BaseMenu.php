<?php

namespace App\Libraries\Menu;

class BaseMenu
{

    public function check($action, $params = [], $controller = null)
    {
        $controller = $controller ?: $this->controller;
        return app('policy')->check($controller, $action, $params);
    }

    public function __construct()
    {
        $this->menu = app('menu');
    }
}