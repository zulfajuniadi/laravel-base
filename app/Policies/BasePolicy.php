<?php

namespace App\Policies;

use App\User;

class BasePolicy
{
    public function __construct()
    {
        $this->user = app('auth')->user() ?: new User;
    }
}