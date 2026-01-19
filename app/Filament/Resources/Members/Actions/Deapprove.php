<?php

namespace App\Filament\Resources\Members\Actions;

use App\Mails\ConfirmMemberDeleted;
use Filament\Actions\Action;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class Deapprove extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'deapprove';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->successNotificationTitle(__('app.actions.deapprove.notification.success'));

        $this->failureNotificationTitle(__('app.actions.deapprove.notification.failed'));

        $this->label(__('app.actions.deapprove.label.button'));

        $this->color('danger');

        $this->icon('phosphor-hand-palm');

        $this->action(function (Model $record): void {

            $result = $record->delete();

            // send email au membre pour lui dire que son inscription est désapprouvée
            Mail::to($record->email, $record->getFullName())
                ->send(new ConfirmMemberDeleted);

            if (! $result) {
                $this->failure();

                return;
            }
            $this->success();

        });

        $this->requiresConfirmation();

        $this->modalHeading(fn (Model $record): string => __('app.actions.deapprove.modal.heading'));

        $this->modalDescription(__('app.actions.deapprove.modal.description'));

        $this->modalSubmitActionLabel(__('app.actions.deapprove.label.submit'));

        $this->modalSubmitAction(fn (Action $action): Action => $action->color('danger'));
    }
}
