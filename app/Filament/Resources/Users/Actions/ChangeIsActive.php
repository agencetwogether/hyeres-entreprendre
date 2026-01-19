<?php

namespace App\Filament\Resources\Users\Actions;

use App\Filament\Resources\Users\Schemas\Components\UserFields;
use App\Notifications\ChangeIsActiveStatusUser;
use Filament\Actions\Action;
use Illuminate\Database\Eloquent\Model;
use Notification;

class ChangeIsActive extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'changeIsActiveStatus';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(fn (Model $record): string => $record->is_active ? __('app.users.actions.approval.label.deapprove.button') : __('app.users.actions.approval.label.approve.button'));

        $this->successNotificationTitle(fn (Model $record): string => ! $record->is_active ? __('app.users.actions.approval.notification.deapprove.success') : __('app.users.actions.approval.notification.approve.success'));

        $this->failureNotificationTitle(fn (Model $record): string => ! $record->is_active ? __('app.users.actions.approval.notification.deapprove.fail') : __('app.users.actions.approval.notification.approve.fail'));

        $this->color(fn (Model $record): string => $record->is_active ? 'danger' : 'success');

        $this->icon(fn (Model $record): string => $record->is_active ? 'phosphor-x' : 'phosphor-check');

        $this->modalHeading(fn (Model $record): string => $record->is_active ? __('app.users.actions.approval.modal.deapprove.heading') : __('app.users.actions.approval.modal.approve.heading'));

        $this->modalDescription(fn (Model $record): string => $record->is_active ? __('app.users.actions.approval.modal.deapprove.description') : __('app.users.actions.approval.modal.approve.description'));

        $this->modalSubmitActionLabel(fn (Model $record): string => $record->is_active ? __('app.users.actions.approval.label.deapprove.submit') : __('app.users.actions.approval.label.approve.submit'));

        $this->modalSubmitAction(fn (Action $action): Action => $action->color('primary'));

        $this->schema([
            UserFields::getFieldSendEmail()
                ->label(__('app.users.form.label.yes_send_email_after_change_status')),
        ]);

        $this->action(function (Model $record, array $data): void {

            $record->is_active = ! $record->is_active;
            $result = $record->save();

            if ($data['sendEmail']) {
                Notification::send($record, new ChangeIsActiveStatusUser);
            }

            if (! $result) {
                $this->failure();

                return;
            }

            $this->success();
        });

        $this->visible(auth()->user()->can('ChangeActive:User'));
    }
}
