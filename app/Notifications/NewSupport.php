<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class NewSupport extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public User $user, public array $data) {}

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
            ->replyTo($this->user->email, $this->user->getFilamentName())
            ->from(getAppEmailFrom(), getAppEmailNameFrom())
            ->subject(__('notification.new-support.subject'))
            ->greeting(__('notification.new-support.greeting', ['name' => $notifiable->getFilamentName()]))
            ->view(
                'emails.layouts.main',
                [
                    'content' => new HtmlString(__('notification.new-support.content', [
                        'askerName' => $this->user->getFilamentName(),
                        'subject' => $this->data['subject'],
                        'message' => $this->data['content'],
                    ])),
                    'internal' => true,
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
