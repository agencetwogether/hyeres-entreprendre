<?php

namespace App\Listeners;

use Illuminate\Auth\Events\PasswordReset;

class ResetForceRenewPassword
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
    public function handle(PasswordReset $event): void
    {
        if ($event->user->force_renew_password) {
            $event->user->force_renew_password = false;
            $event->user->save();
        }
    }
}
