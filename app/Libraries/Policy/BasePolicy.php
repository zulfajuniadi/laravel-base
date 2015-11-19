<?php

namespace App\Libraries\Policy;

use App\User;

class BasePolicy
{
    public function __construct()
    {
        $this->user = app('auth')->user() ?: new User;
    }
}