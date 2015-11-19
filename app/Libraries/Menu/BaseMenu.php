<?php

namespace App\Libraries\Menu;

class BaseMenu
{
    public function __construct()
    {
        $this->menu = app('menu');
    }
}