<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class LicenceIsAboutToExpire extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public int $day)
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
            ->replyTo(getGeneratorEmail(), getGeneratorNameEmail())
            ->subject(__('notification.licence-is-about-to-expire.subject', ['organization' => getClientName(), 'day' => $this->day]))
            ->greeting(__('notification.licence-is-about-to-expire.greeting', ['name' => getLicenceInvoiceContactName()]))
            ->view(
                'emails.layouts.main',
                [
                    'content' => new HtmlString(__('notification.licence-is-about-to-expire.content', [
                        'organization' => getClientName(),
                        'starts_at' => getLicenceStartsAt()->translatedFormat('l j F Y'),
                        'ends_at' => getLicenceEndsAt()->translatedFormat('l j F Y'),
                        'duration' => getLicenceFormatDuration(),
                        'price' => getLicencePriceContract(),
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
