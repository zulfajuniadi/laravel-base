<?php

namespace App\Policies;

use App\User;
use App\UserBlacklist;
use App\Libraries\Policy\BasePolicy;

class UserBlacklistsPolicy extends BasePolicy
{
    public function index()
    {
        return $this->user->ability(['Admin'], ['UserBlacklist:List']);
    }

    public function data()
    {
        return $this->index();
    }

    public function show()
    {
        return $this->user->ability(['Admin'], ['UserBlacklist:Show']);
    }

    public function create()
    {
        return $this->user->ability(['Admin'], ['UserBlacklist:Create']);
    }

    public function store()
    {
        return $this->create();
    }

    public function edit(User $user, UserBlacklist $userBlacklist)
    {
        return $this->user->ability(['Admin'], ['UserBlacklist:Update']);
    }

    public function update(User $user, UserBlacklist $userBlacklist)
    {
        return $this->edit($user, $userBlacklist);
    }

    public function duplicate(User $user, UserBlacklist $userBlacklist)
    {
        return $this->user->ability(['Admin'], ['UserBlacklist:Duplicate']);
    }

    public function revisions(User $user, UserBlacklist $userBlacklist)
    {
        return $this->user->ability(['Admin'], ['UserBlacklist:Revisions']);
    }

    public function destroy(UserBlacklist $userBlacklist)
    {
        return $this->user->ability(['Admin'], ['UserBlacklist:Delete']);
    }

    public function delete(User $user, UserBlacklist $userBlacklist)
    {
        return $this->destroy($userBlacklist);
    }
}