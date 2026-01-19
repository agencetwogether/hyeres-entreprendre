<?php

namespace App\Mails;

use App\Models\User;
use Filament\Pages\Dashboard;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\HtmlString;

class MemberInvitationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    private User $user;

    private string $password;

    public function __construct(
        User $user,
        string $password
    ) {
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(getAppEmailFrom(), getAppEmailNameFrom()),
            subject: __('notification.member-invitation.subject', ['organization' => getClientName()]),
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
                'greeting' => __('notification.member-invitation.greeting', ['organization' => getClientName()]),
                'content' => new HtmlString(__('notification.member-invitation.content')),
                'optionalEndText' => new HtmlString(__('notification.member-invitation.optional-end-text', ['organization' => getClientName(), 'email' => $this->user->email, 'password' => $this->password])),
                'internal' => false,
                'btnLabel' => __('notification.member-invitation.btnLabel'),
                'btnLink' => Dashboard::getUrl(),

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
