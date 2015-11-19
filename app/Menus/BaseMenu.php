<?php

namespace App\Menus;

class BaseMenu
{
    public function __construct()
    {
        $this->menu = app('menu');
    }
}