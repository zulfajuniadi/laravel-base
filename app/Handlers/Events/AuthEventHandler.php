<?php

namespace App\Handlers\Events;

use App\Events\Event;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

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

    }

    public function handleLogout($user)
    {

    }

}
