<?php

namespace App\Listeners;

use App\Enums\Role;
use App\Events\SendSupport;
use App\Models\User;
use App\Notifications\ConfirmSupport;
use App\Notifications\NewSupport;
use Illuminate\Support\Facades\Notification;

class SendEmailSupportNotification
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
    public function handle(SendSupport $event): void
    {
        // Send email to SuperAdmin
        $superAdmin = User::role(Role::SUPERADMIN)->first();
        Notification::send($superAdmin, new NewSupport(auth()->user(), $event->data));

        // Send confirmation to asker
        auth()->user()->notify(new ConfirmSupport($event->data));

    }
}
