<?php

namespace App\Filament\Resources\Members\Actions;

use App\Enums\PaymentMethod;
use App\Models\Invoice;
use App\Models\Member;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Filament\Forms\Components\RichEditor\RichContentRenderer;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Blade;

class DownloadInvoice extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'currentInvoice';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Facture');

        $this->action(function (Member $record) {
            $invoiceExist = $record->onePlanSubscriptions->invoices->where('starts_at', '=', $record->onePlanSubscriptions->starts_at)->first();
            if ($invoiceExist) {
                return $this->download($invoiceExist);
            } elseif ($record->onePlanSubscriptions->active()) {
                $createInvoice = $record->onePlanSubscriptions->invoices()->create([
                    'amount' => $record->onePlanSubscriptions->plan->price,
                    'discount_rate' => $record->onePlanSubscriptions->discount_rate,
                    'payment_received_at' => $record->onePlanSubscriptions->payment_received_at,
                    'payment_mode' => PaymentMethod::NC,
                    'starts_at' => $record->onePlanSubscriptions->starts_at,
                    'ends_at' => $record->onePlanSubscriptions->ends_at,
                ]);

                if ($createInvoice) {
                    return $this->download($createInvoice);
                }

                return $this->sendNotificationError();

            }

            return $this->sendNotificationError();
        });

        $this->hidden(fn (Member $record): bool => ! filled($record->onePlanSubscriptions->payment_received_at));
    }

    protected function download(Invoice $invoice)
    {
        $filename = 'facture_'.$invoice->subscription->subscriber->name.'_'.$invoice->starts_at->format('d_m_Y').'.pdf';

        return response()->streamDownload(function () use ($invoice) {
            echo Pdf::loadHtml(
                Blade::render(
                    'layouts.pdf.invoice',
                    [
                        'invoice' => $invoice,
                        'planDescription' => RichContentRenderer::make($invoice->subscription->plan->description),
                    ]
                )
            )->stream();
        }, $filename);
    }

    protected function sendNotificationError(): Notification
    {
        return Notification::make()
            ->title(__('app.general.error_notification_invoice_not_found'))
            ->danger()
            ->send();
    }
}
