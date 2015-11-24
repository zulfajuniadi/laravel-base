<?php

namespace App\Handlers\Events;

use App\Events\Event;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Repositories\AuthLogsRepository;

class AuthEventHandler
{
    /**
     * Create the event handler.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function handleLogin($user)
    {
        AuthLogsRepository::log($user, 'login');
    }

    public function handleLogout($user)
    {
        AuthLogsRepository::log($user, 'logout');
    }

}
