<?php

namespace App\Notifications;

use App\Models\User;
use Filament\Pages\Dashboard;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class NewUser extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public User $user, public string $password)
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
        return (new MailMessage)
            ->from(getAppEmailFrom(), getAppEmailNameFrom())
            ->subject(__('notification.new-user.subject', ['organization' => getClientName()]))
            ->greeting(__('notification.new-user.greeting', ['name' => $this->user->getFilamentName()]))
            ->view(
                'emails.layouts.main',
                [
                    'content' => new HtmlString(__('notification.new-user.content', [
                        'organization' => getClientName(),
                        'email' => $this->user->email,
                        'password' => $this->password,
                    ])),
                    'btnLabel' => __('notification.new-user.btnLabel'),
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
