<?php

namespace App\Libraries\Menu;

class BaseMenu
{

    public function check($action, $params = [])
    {
        return app('policy')->check($this->controller, $action, $params);
    }

    public function __construct()
    {
        $this->menu = app('menu');
    }
}