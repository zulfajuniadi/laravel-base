<?php

namespace App\Policies;

use App\AuthLog;
use App\Libraries\Policy\BasePolicy;

class AuthLogsPolicy extends BasePolicy
{
    public function index()
    {
        return $this->user->ability(['Admin'], ['AuthLog:List']);
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

    public function edit(AuthLog $authLog)
    {
        return false;
    }

    public function update(AuthLog $authLog)
    {
        return false;
    }

    public function duplicate(AuthLog $authLog)
    {
        return false;
    }

    public function revisions(AuthLog $authLog)
    {
        return false;
    }

    public function destroy(AuthLog $authLog)
    {
        return false;
    }

    public function delete(AuthLog $authLog)
    {
        return false;
    }
}