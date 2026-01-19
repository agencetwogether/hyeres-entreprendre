<?php

namespace App\Notifications;

use App\Models\Subscription;
use Filament\Pages\Dashboard;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class SubscriptionIsAboutToExpire extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Subscription $subscription, public int $delta)
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
            ->subject(__('notification.subscription-is-about-to-expire.subject', ['organization' => getClientName(), 'day' => $this->delta]))
            ->greeting(__('notification.subscription-is-about-to-expire.greeting', ['name' => $this->subscription->subscriber->getFullName()]))
            ->view(
                'emails.layouts.main',
                [
                    'content' => new HtmlString(__('notification.subscription-is-about-to-expire.content', [
                        'plan' => $this->subscription->plan->name,
                        'delta' => $this->delta,
                    ])),
                    'optionalEndText' => new HtmlString(__('notification.subscription-is-about-to-expire.optional-end-text', [
                        'starts_at' => $this->subscription->starts_at->format('d/m/Y'),
                        'ends_at' => $this->subscription->ends_at->format('d/m/Y'),
                    ])),
                    'btnLabel' => $this->subscription->subscriber->account_created ? __('notification.subscription-is-about-to-expire.btnLabel') : null,
                    'btnLink' => $this->subscription->subscriber->account_created ? Dashboard::getUrl() : null,
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
