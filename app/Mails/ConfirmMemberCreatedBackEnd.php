<?php

namespace App\Mails;

use App\Models\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\HtmlString;

class ConfirmMemberCreatedBackEnd extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public array $data,
        public Member $record
    ) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(getAppEmailFrom(), getAppEmailNameFrom()),
            subject: __('notification.confirm-member-created-backend.subject'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        if ($this->record->onePlanSubscriptions->discount_rate) {
            $amount = '<span style="text-decoration-line: line-through;">'.$this->record->onePlanSubscriptions->plan->price.' '.$this->record->onePlanSubscriptions->plan->currency.'</span> - Réduction de <span style="color: rgb(22,163,74);">'.$this->record->onePlanSubscriptions->discount_rate->getLabel().'</span>, soit '.$this->record->onePlanSubscriptions->plan->price * (1 - $this->record->onePlanSubscriptions->discount_rate->value / 100).' '.$this->record->onePlanSubscriptions->plan->currency;
        } else {
            $amount = $this->record->onePlanSubscriptions->plan->price.' '.$this->record->onePlanSubscriptions->plan->currency;
        }

        return new Content(
            view: 'emails.layouts.main',
            with: [
                'greeting' => __('notification.confirm-member-created-backend.greeting'),
                'content' => new HtmlString(__('notification.confirm-member-created-backend.content', [
                    'organization' => getClientName(),
                    'plan' => $this->record->onePlanSubscriptions->plan->name,
                    'amount' => $amount,
                    'period' => $this->record->onePlanSubscriptions->starts_at->format('d/m/Y').' - '.$this->record->onePlanSubscriptions->ends_at->format('d/m/Y'),
                ])),
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
        if (getMembership()['document_for_email']) {
            return [
                Attachment::fromStorageDisk('public', getMembership()['document_for_email'])
                    ->as('rib_association_hyeres_entreprendre.pdf')
                    ->withMime('application/pdf'),
            ];
        }

        return [];
    }
}
