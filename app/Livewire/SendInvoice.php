<?php

namespace App\Livewire;

use App\Mails\SendInvoice as MailSendInvoice;
use App\Models\Invoice;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Notifications\Notification;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class SendInvoice extends Component implements HasActions, HasSchemas
{
    use InteractsWithActions;
    use InteractsWithSchemas;

    public Invoice $invoice;

    public function sendAction(): Action
    {
        return Action::make('send')
            ->label('Envoyer Facture')
            ->outlined()
            ->color('success')
            ->link()
            ->requiresConfirmation()
            ->visible(auth()->user()->isAdmin() || auth()->user()->isSuperAdmin())
            ->action(function () {
                Mail::to($this->invoice->subscription->subscriber->email, $this->invoice->subscription->subscriber->firstname.' '.$this->invoice->subscription->subscriber->name)
                    ->send(new MailSendInvoice($this->invoice->subscription->subscriber, $this->invoice));

                return Notification::make()
                    ->title(__('notification.send-invoice.success'))
                    ->success()
                    ->send();

            });
    }

    public function render()
    {
        return view('livewire.send-invoice');
    }
}
