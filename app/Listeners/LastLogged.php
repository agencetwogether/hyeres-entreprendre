<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;

class LastLogged
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        if ($user = $event->user) {
            $user->touch('last_logged_at');
        }

    }
}
