<?php

namespace App\Policies;

use App\Permission;
use App\Libraries\Policy\BasePolicy;

class PermissionsPolicy extends BasePolicy
{
    public function index()
    {
        return $this->user->ability(['Admin'], ['Permission:List']);
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

    public function edit(Permission $permission)
    {
        return false;
    }

    public function update(Permission $permission)
    {
        return false;
    }

    public function duplicate(Permission $permission)
    {
        return false;
    }

    public function revisions(Permission $permission)
    {
        return false;
    }

    public function destroy(Permission $permission)
    {
        return false;
    }

    public function delete(Permission $permission)
    {
        return false;
    }
}