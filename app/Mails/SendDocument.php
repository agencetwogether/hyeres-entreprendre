<?php

namespace App\Mails;

use App\Models\ContactInvitation;
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
use Illuminate\Support\Facades\URL;

class SendDocument extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public array $data,
        public Model $record,
        private readonly ContactInvitation $invitation
    ) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(getAppEmailFrom(), getAppEmailNameFrom()),
            subject: $this->data['subject_email']
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
                'greeting' => __('app.general.greeting', ['name' => $this->record->name, 'firstname' => $this->record->firstname]),
                'content' => RichContentRenderer::make($this->data['content_email']),
                'btnLabel' => $this->data['send_link'] ? __('notification.response-to-contact.btnLabel') : null,
                'btnLink' => $this->data['send_link'] ? URL::signedRoute(
                    'contact.invitation.accept',
                    ['invitation' => $this->invitation]
                ) : null,
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
        return [];
    }
}
