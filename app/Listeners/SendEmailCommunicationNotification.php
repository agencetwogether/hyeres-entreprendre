<?php

namespace App\Listeners;

use App\Events\SendCommunication;
use App\Models\Member;
use App\Models\User;
use App\Notifications\NewCommunication;
use Illuminate\Support\Facades\Notification;

class SendEmailCommunicationNotification
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
    public function handle(SendCommunication $event): void
    {
        // Build emails array
        $data = $event->data;
        $model = $data['data']['model'];
        $recipients = $data['data']['recipients'];
        $recipientsArray = [];

        if ($model === 'member') {
            $recipientsArray = Member::query()
                ->whereIn('id', $recipients)
                ->get()
                ->mapWithKeys(function (Member $member) {
                    return [$member['email'] => $member->getFullName()];
                })
                ->toArray();
        }

        if ($model === 'user') {
            $recipientsArray = User::query()
                ->whereIn('id', $recipients)
                ->get()
                ->mapWithKeys(function (User $user) {
                    return [$user['email'] => $user->getFilamentName()];
                })
                ->toArray();
        }

        if (! empty($recipientsArray)) {

            foreach ($recipientsArray as $email => $name) {

                Notification::route(
                    'mail',
                    [
                        $email => $name,
                    ]
                )->notify(new NewCommunication($data, $name));
            }
        }

    }
}
