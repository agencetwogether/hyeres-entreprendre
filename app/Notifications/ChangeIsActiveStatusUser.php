<?php

namespace App\Notifications;

use Filament\Pages\Dashboard;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class ChangeIsActiveStatusUser extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $verb = $notifiable->is_active ? 'activate' : 'deactivate';

        return (new MailMessage)
            ->from(getAppEmailFrom(), getAppEmailNameFrom())
            ->replyTo(getGeneratorSupportEmail(), getGeneratorSupportName())
            ->subject(__("notification.change-is-active-status-user.{$verb}.subject"))
            ->greeting(__("notification.change-is-active-status-user.{$verb}.greeting", ['name' => $notifiable->getFilamentName()]))
            ->view(
                'emails.layouts.main',
                [
                    'content' => new HtmlString(__("notification.change-is-active-status-user.{$verb}.content", [
                        'organization' => getClientName(),
                    ])),
                    'btnLabel' => $notifiable->is_active ? __("notification.change-is-active-status-user.{$verb}.btnLabel") : false,
                    'btnLink' => Dashboard::getUrl(),
                    'internal' => false,
                ]
            );
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
