<?php

namespace App\Validators;

class UsersValidators extends BaseValidator
{
    public function store($data)
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => app('config')->get('auth.password.rules'),
        ];
    }

    public function update($data)
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $data['users']->id,
        ];
    }

    public function doChangePassword($data)
    {
        return [
            'existing_password' => 'required|matchesHashedPassword:' . auth()->user()->password,
            'password' => app('config')->get('auth.password.rules') . '|confirmed',
            'password_confirmation' => 'required',
        ];
    }

    public function doEditProfile($data)
    {
        return [
            'name' => 'required',
            'email' => 'required',
            'avatar_url' => 'url',
        ];
    }
}