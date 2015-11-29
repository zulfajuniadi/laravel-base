<?php

namespace App\Policies;

use App\User;
use App\Libraries\Policy\BasePolicy;

class UsersPolicy extends BasePolicy
{
    public function index()
    {
        return $this->user->ability(['Admin'], ['User:List']);
    }

    public function data()
    {
        return $this->index();
    }

    public function show()
    {
        return $this->user->ability(['Admin'], ['User:Show']);
    }

    public function create()
    {
        return $this->user->ability(['Admin'], ['User:Create']);
    }

    public function store()
    {
        return $this->create();
    }

    public function edit(User $user)
    {
        return $this->user->ability(['Admin'], ['User:Update']);
    }

    public function update(User $user)
    {
        return $this->edit($user);
    }

    public function duplicate(User $user)
    {
        return $this->user->ability(['Admin'], ['User:Duplicate']);
    }

    public function revisions(User $user)
    {
        return $this->user->ability(['Admin'], ['User:Revisions']);
    }

    public function destroy(User $user)
    {
        return $this->user->ability(['Admin'], ['User:Delete']);
    }

    public function assume(User $user)
    {
        return $this->user->ability(['Admin'], ['User:Assume']) && $this->user->id != $user->id;
    }

    public function activate(User $user)
    {
        return $this->user->ability(['Admin'], ['User:Activate']);
    }

    public function deactivate(User $user)
    {
        return $this->user->ability(['Admin'], ['User:Activate']);
    }

    public function resume()
    {
        return app('session')->has('original_user');
    }

    public function delete(User $user)
    {
        return $this->destroy($user);
    }

    public function profile()
    {
        return app('auth')->check();
    }

    public function editProfile()
    {
        return app('auth')->check();
    }

    public function doEditProfile()
    {
        return $this->editProfile();
    }

    public function changePassword()
    {
        return app('auth')->check();
    }

    public function doChangePassword()
    {
        return $this->changePassword();
    }
}