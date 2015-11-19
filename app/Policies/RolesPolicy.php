<?php

namespace App\Policies;

use App\Role;
use App\Libraries\Policy\BasePolicy;

class RolesPolicy extends BasePolicy
{
    public function index()
    {
        return $this->user->ability(['Admin'], ['Role:List']);
    }

    public function data()
    {
        return $this->index();
    }

    public function show()
    {
        return $this->user->ability(['Admin'], ['Role:Show']);
    }

    public function create()
    {
        return $this->user->ability(['Admin'], ['Role:Create']);
    }

    public function store()
    {
        return $this->create();
    }

    public function edit(Role $role)
    {
        return $this->user->ability(['Admin'], ['Role:Update']) && $role->name != 'Admin';
    }

    public function update(Role $role)
    {
        return $this->edit($role);
    }

    public function duplicate(Role $role)
    {
        return $this->user->ability(['Admin'], ['Role:Duplicate']);
    }

    public function revisions(Role $role)
    {
        return $this->user->ability(['Admin'], ['Role:Revisions']);
    }

    public function destroy(Role $role)
    {
        return $this->user->ability(['Admin'], ['Role:Delete']) && $role->name != 'Admin';
    }

    public function delete(Role $role)
    {
        return $this->destroy($role);
    }
}