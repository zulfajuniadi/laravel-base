<?php

namespace App\Validators;

class PermissionGroupsValidators extends BaseValidator
{
    public function store($data)
    {
        return [
            'name' => 'required',
        ];
    }

    public function update($data)
    {
        return [
            'name' => 'required',
        ];
    }
}