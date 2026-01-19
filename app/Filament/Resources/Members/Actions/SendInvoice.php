<?php

namespace App\Filament\Resources\Members\Actions;

use App\Mails\SendInvoice as MailSendInvoice;
use App\Models\Member;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Mail;

class SendInvoice extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'sendInvoice';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Envoyer Facture');

        $this->link();

        $this->color('success');

        $this->hidden(fn (Member $record): bool => ! filled($record->onePlanSubscriptions->payment_received_at));

        $this->requiresConfirmation();

        $this->action(function (Member $record) {
            $invoiceExist = $record->onePlanSubscriptions->invoices->where('starts_at', '=', $record->onePlanSubscriptions->starts_at)->first();
            if ($invoiceExist) {
                Mail::to($record->email, $record->firstname.' '.$record->name)
                    ->send(new MailSendInvoice($record, $invoiceExist));

                return Notification::make()
                    ->title(__('notification.send-invoice.success'))
                    ->success()
                    ->send();

            }

            return Notification::make()
                ->title(__('app.general.error_notification_invoice_not_found'))
                ->danger()
                ->send();
        });
    }
}
