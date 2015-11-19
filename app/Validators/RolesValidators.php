<?php

namespace App\Validators;

class RolesValidators extends BaseValidator
{
    public function store($data)
    {
        return [
            'name'         => 'required|unique:roles',
            'display_name' => 'required',
            'description' => 'required',
        ];
    }

    public function update($data)
    {
        return [
            'name'         => 'required|unique:roles,id,' . $data['roles']->id,
            'display_name' => 'required',
            'description'  => 'required',
        ];
    }
}