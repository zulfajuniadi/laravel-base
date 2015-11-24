<?php

namespace App\Validators;

class UserBlacklistsValidators extends BaseValidator
{
    public function store($data)
    {
        return [
            'until' => 'required',
            'name' => 'required',
        ];
    }

    public function update($data)
    {
        return [
            'until' => 'required',
            'name' => 'required',
        ];
    }
}