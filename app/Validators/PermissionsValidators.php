<?php

namespace App\Validators;

class PermissionsValidators extends BaseValidator
{
    public function store($data)
    {
        return [
            'permission_group_id' => 'required',
            'name' => 'required',
            'display_name' => 'required',
        ];
    }

    public function update($data)
    {
        return [
            'permission_group_id' => 'required',
            'name' => 'required',
            'display_name' => 'required',
        ];
    }
}