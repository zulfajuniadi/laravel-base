<?php

namespace App\Validators;

class UsersValidators extends BaseValidator
{
    public function store($data)
    {
        return [
            'name' => 'required',
            'email' => 'required',
        ];
    }

    public function update($data)
    {
        return [
            'name' => 'required',
            'email' => 'required',
        ];
    }
}