<?php

namespace App\Mails;

use App\Filament\Resources\Contacts\Pages\ListContacts;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\HtmlString;

class ContactForm extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public array $data
    ) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(getAppEmailFrom(), getAppEmailNameFrom()),
            subject: __('notification.front-contact.subject', ['organization' => getClientName()]),
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
                'greeting' => __('notification.front-contact.greeting', ['asker' => $this->data['firstname'].' '.$this->data['name']]),
                'content' => new HtmlString(__('notification.front-contact.content', [
                    'content' => $this->data['content'],
                    'fullname' => $this->data['firstname'].' '.$this->data['name'],
                    'email' => $this->data['email'],
                    'phone' => $this->data['phone'],
                ])),
                'optionalEndText' => new HtmlString(__('notification.front-contact.optional-end-text', ['interested' => $this->data['interested'] ? __('Yes') : __('No')])),
                'btnLabel' => __('notification.front-contact.btnLabel'),
                'btnLink' => ListContacts::getUrl(),
                'internal' => true,
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
