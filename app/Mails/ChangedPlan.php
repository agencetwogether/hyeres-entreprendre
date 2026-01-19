<?php

namespace App\Mails;

use App\Enums\DiscountRate;
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
use Laravelcm\Subscriptions\Models\Plan;

class ChangedPlan extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public Member $record,
        public Plan $newPlan,
        public ?int $newPlanDiscount,
        public Plan $oldPlan,
        public ?int $oldPlanDiscount,
    ) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(getAppEmailFrom(), getAppEmailNameFrom()),
            subject: __('notification.change-plan.subject')
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $oldPlan = $this->oldPlan->name;
        $oldPeriod = $this->record->onePlanSubscriptions->starts_at->format('d/m/Y').' - '.$this->record->onePlanSubscriptions->ends_at->format('d/m/Y');

        $newPlan = $this->newPlan->name;
        $newPeriod = $this->record->onePlanSubscriptions->starts_at->format('d/m/Y').' - '.$this->record->onePlanSubscriptions->ends_at->format('d/m/Y');

        if (filled($this->oldPlanDiscount)) {
            $oldAmount = '<span style="text-decoration-line: line-through;">'.$this->oldPlan->price.' '.$this->oldPlan->currency.'</span> - Réduction de <span style="color: rgb(22,163,74);">'.DiscountRate::tryFrom($this->oldPlanDiscount)->getLabel().'</span>, soit '.$this->oldPlan->price * (1 - $this->oldPlanDiscount / 100).' '.$this->oldPlan->currency;
        } else {
            $oldAmount = $this->oldPlan->price.' '.$this->oldPlan->currency;
        }

        if (filled($this->newPlanDiscount)) {
            $newAmount = '<span style="text-decoration-line: line-through;">'.$this->newPlan->price.' '.$this->newPlan->currency.'</span> - Réduction de <span style="color: rgb(22,163,74);">'.DiscountRate::tryFrom($this->newPlanDiscount)->getLabel().'</span>, soit '.$this->newPlan->price * (1 - $this->newPlanDiscount / 100).' '.$this->newPlan->currency;
        } else {
            $newAmount = $this->newPlan->price.' '.$this->newPlan->currency;
        }

        return new Content(
            view: 'emails.layouts.main',
            with: [
                'greeting' => __('notification.change-plan.greeting', ['name' => $this->record->name, 'firstname' => $this->record->firstname]),
                'content' => new HtmlString(__('notification.change-plan.content', [
                    'organization' => getClientName(),
                    'oldPlan' => $oldPlan,
                    'oldPeriod' => $oldPeriod,
                    'oldAmount' => $oldAmount,
                    'newPlan' => $newPlan,
                    'newPeriod' => $newPeriod,
                    'newAmount' => $newAmount,
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
