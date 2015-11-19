<?php

namespace App\Validators;

use App\Exceptions\ValidationRulesDoesNotExists;

class BaseValidator
{
    public function validate($method, $params)
    {
        if(!method_exists($this, $method))
            throw new ValidationRulesDoesNotExists($method, get_class($this));
        $data = app('request')->all() + $params;
        return app('validator')->make($data, $this->{$method}($data));
    }
}