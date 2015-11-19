<?php

namespace App\Libraries\Policy;

class BasePolicy
{
    public function __construct()
    {
        $this->user = app('auth')->user() ?: (new app('config'))->get('auth.model');
    }
}