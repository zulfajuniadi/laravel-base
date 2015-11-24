<?php

namespace App\Policies;

use App\PermissionGroup;
use App\Libraries\Policy\BasePolicy;

class PermissionGroupsPolicy extends BasePolicy
{
    public function index()
    {
        return $this->user->ability(['Admin'], ['PermissionGroup:List']);
    }

    public function data()
    {
        return $this->index();
    }

    public function show()
    {
        return false;
    }

    public function create()
    {
        return false;
    }

    public function store()
    {
        return false;
    }

    public function edit(PermissionGroup $permissionGroup)
    {
        return false;
    }

    public function update(PermissionGroup $permissionGroup)
    {
        return false;
    }

    public function duplicate(PermissionGroup $permissionGroup)
    {
        return false;
    }

    public function revisions(PermissionGroup $permissionGroup)
    {
        return false;
    }

    public function destroy(PermissionGroup $permissionGroup)
    {
        return false;
    }

    public function delete(PermissionGroup $permissionGroup)
    {
        return false;
    }
}