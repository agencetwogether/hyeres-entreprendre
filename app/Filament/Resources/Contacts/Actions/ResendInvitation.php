<?php

namespace App\Filament\Resources\Contacts\Actions;

use App\Enums\StatusContact;
use App\Mails\SendDocument as SendDocumentMail;
use App\Models\ContactInvitation;
use Filament\Actions\Action;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class ResendInvitation extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'resendInvitation';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->successNotificationTitle(__('app.actions.resend_invitation.notification.success'));

        $this->failureNotificationTitle(__('app.actions.resend_invitation.notification.failed'));

        $this->label(__('app.actions.resend_invitation.label.button'));

        $this->color('success');

        $this->icon('phosphor-check');

        $this->action(function (Model $record): void {

            $invitation = ContactInvitation::where('contact_id', $record->id)->first();

            if ($invitation) {
                $data = [
                    'subject_email' => $record->response_subject,
                    'content_email' => $record->response_content,
                    'send_link' => true,
                ];

                Mail::to($record->email, $record->firstname.' '.$record->name)
                    ->send(new SendDocumentMail($data, $record, $invitation));

                $this->success();

                $record->update([
                    'response_date' => now(),
                ]);

            } else {
                $this->failure();
            }

        });

        $this->requiresConfirmation();

        $this->modalIcon('phosphor-check');

        $this->modalHeading(fn (Model $record): string => __('app.actions.resend_invitation.modal.heading'));

        $this->modalDescription(__('app.actions.resend_invitation.modal.description'));

        $this->modalSubmitActionLabel(__('app.actions.resend_invitation.label.submit'));

        $this->modalSubmitAction(fn (Action $action): Action => $action->color('success'));

        $this->visible(fn (Model $record) => $record->status == StatusContact::WAITING);
    }
}
