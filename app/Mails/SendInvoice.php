<?php

namespace App\Mails;

use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Forms\Components\RichEditor\RichContentRenderer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\HtmlString;

class SendInvoice extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public Model $record,
        private readonly Invoice $invoice
    ) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(getAppEmailFrom(), getAppEmailNameFrom()),
            subject: __('notification.send-invoice.subject')
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.layouts.main',
            with: [
                'greeting' => __('notification.send-invoice.greeting', ['name' => $this->record->name, 'firstname' => $this->record->firstname]),
                'content' => new HtmlString(__('notification.send-invoice.content', ['organization' => getClientName()])),
                'internal' => false,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        $filename = 'facture_'.$this->record->name.'_'.$this->invoice->starts_at->format('d_m_Y').'.pdf';

        $pdf = PDF::loadView(
            'layouts.pdf.invoice',
            [
                'invoice' => $this->invoice,
                'planDescription' => filled($this->invoice->subscription->plan->description) ? RichContentRenderer::make($this->invoice->subscription->plan->description) : '',
            ]
        );

        return [
            Attachment::fromData(fn () => $pdf->output(), $filename)
                ->withMime('application/pdf'),
        ];

    }
}
