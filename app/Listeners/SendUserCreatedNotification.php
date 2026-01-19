<?php

namespace App\Listeners;

use App\Events\CreateUser;
use App\Notifications\NewUser;
use Illuminate\Support\Facades\Notification;

class SendUserCreatedNotification
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
    public function handle(CreateUser $event): void
    {
        Notification::route(
            'mail',
            [
                $event->user->email => $event->user->getFilamentName(),
            ]
        )->notify(new NewUser($event->user, $event->password));
    }
}
