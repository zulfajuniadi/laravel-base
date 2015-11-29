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

    public function doChangePassword($data)
    {
        return [
            'existing_password' => 'required|matchesHashedPassword:' . auth()->user()->password,
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
        ];
    }

    public function doEditProfile($data)
    {
        return [
            'name' => 'required',
            'email' => 'required',
        ];
    }
}