<?php

namespace App\Notifications;

use Filament\Auth\Notifications\ResetPassword as BaseNotification;
use Illuminate\Notifications\Messages\MailMessage;

class CustomFilamentResetPasswordNotification extends BaseNotification
{
    protected function buildMailMessage($url)
    {
        return (new MailMessage)
            ->from(getAppEmailFrom(), getAppEmailNameFrom())
            ->subject(__('notification.reset-password.subject'))
            ->greeting(__('notification.reset-password.greeting'))
            ->view(
                'emails.layouts.main',
                [
                    'content' => __('notification.reset-password.content', ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]),
                    'optionalEndText' => __('notification.reset-password.optionalEndText'),
                    'internal' => false,
                    'btnLabel' => __('notification.reset-password.btnLabel'),
                    'btnLink' => $url,

                ]
            );
    }
}
