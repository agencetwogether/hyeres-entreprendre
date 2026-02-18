<?php

namespace App\Filament\Resources\Members\Actions;

use App\Mails\MemberInvitationMail;
use Filament\Actions\Action;
use Filament\Support\Enums\Width;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ResendCredentials extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'resendCredentials';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->successNotificationTitle(fn (Model $record): string => __('app.actions.resend_credentials.notification.success', ['member' => $record->getFullName()]));

        $this->failureNotificationTitle(__('app.actions.resend_credentials.notification.failed'));

        $this->label(__('app.actions.resend_credentials.label.button'));

        $this->color('warning');

        $this->requiresConfirmation();

        $this->modalIcon('phosphor-key');

        $this->icon('phosphor-key');

        $this->modalWidth(Width::ExtraLarge);

        $this->action(function (array $data, Model $record): void {
            $password = app()->isLocal() ? 'password' : Str::password(12);

            $user = $record->user;

            $result = $user->update([
                'password' => bcrypt($password),
                'force_renew_password' => true,
            ]);

            Mail::to($user->email, $user->getFilamentName())
                ->send(new MemberInvitationMail($user, $password));

            if (! $result) {
                $this->failure();

                return;
            }
            $this->success();
        });

        $this->modalHeading(fn (Model $record): string => __('app.actions.resend_credentials.modal.heading', ['member' => $record->getFullName()]));

        $this->modalDescription(__('app.actions.resend_credentials.modal.description'));

        $this->modalSubmitActionLabel(__('app.actions.resend_credentials.label.submit'));

        $this->modalSubmitAction(fn (Action $action): Action => $action->color('warning'));

        $this->visible(function (Model $record): bool {

            if ($record->user) {

                if (auth()->user()->id == $record->user->id) {
                    return false;

                }

                /*if ($record->user->last_logged_at != null) {

                    return false;
                }*/

                return true;
            }

            return false;
        });
    }
}
