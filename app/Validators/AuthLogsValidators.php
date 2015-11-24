<?php

namespace App\Validators;

class AuthLogsValidators extends BaseValidator
{
    public function store($data)
    {
        return [
            'user_id' => 'required',
            'ip_address' => 'required',
            'action' => 'required',
        ];
    }

    public function update($data)
    {
        return [
            'user_id' => 'required',
            'ip_address' => 'required',
            'action' => 'required',
        ];
    }
}