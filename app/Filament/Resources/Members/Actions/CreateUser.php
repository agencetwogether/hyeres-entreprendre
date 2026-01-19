<?php

namespace App\Filament\Resources\Members\Actions;

use App\Enums\Role;
use App\Mails\MemberInvitationMail;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Support\Enums\Width;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CreateUser extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'createUser';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->successNotificationTitle(__('app.actions.create_user.notification.success'));

        $this->failureNotificationTitle(__('app.actions.create_user.notification.failed'));

        $this->label(__('app.actions.create_user.label.button'));

        $this->color('info');

        $this->icon('phosphor-user-plus');

        $this->action(function (array $data, Model $record): void {
            $password = app()->isLocal() ? 'password' : Str::password(12);

            $user = User::create([
                'firstname' => $record->firstname,
                'name' => $record->name,
                'phone' => $record->phone,
                'email' => $record->email,
                'force_renew_password' => true,
                'password' => bcrypt($password),
            ]);

            $result = $record->update([
                'account_created' => true,
                'user_id' => $user->id,
            ]);

            $user->assignRole(Role::MEMBER);

            Mail::to($user->email, $user->getFilamentName())
                ->send(new MemberInvitationMail($user, $password));

            if (! $result) {
                $this->failure();

                return;
            }
            $this->success();
        });

        $this->requiresConfirmation();

        $this->modalHeading(fn (Model $record): string => __('app.actions.create_user.modal.heading', ['member' => $record->name]));

        $this->modalDescription(__('app.actions.create_user.modal.description'));

        $this->modalSubmitActionLabel(__('app.actions.create_user.label.submit'));

        $this->modalSubmitAction(fn (Action $action): Action => $action->color('info'));

        $this->modalAutofocus(false);

        $this->modalWidth(Width::Large);

        $this->visible(function (Model $record): bool {

            if ($record->is_draft) {
                return false;
            }

            if (! filled($record->company_name)) {
                return false;
            }

            if (! $record->account_created) {
                return true;
            }

            return false;
        });
    }
}
