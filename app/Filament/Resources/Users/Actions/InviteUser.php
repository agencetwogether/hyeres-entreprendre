<?php

namespace App\Filament\Resources\Users\Actions;

use App\Filament\Resources\Users\Schemas\Components\UserFields;
use App\Mails\MemberInvitationMail;
use App\Models\User;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role as RoleModel;

class InviteUser extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'inviteUser';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('app.users.actions.invite-user.label.button'));

        $this->icon('phosphor-paper-plane-tilt');

        $this->schema([
            UserFields::getName(),
            UserFields::getFieldEmailInvite(),
            UserFields::getFieldRoleId(),
        ]);

        $this->modalContent(view('filament.resources.users.permissions.modal-content'));

        $this->modalSubmitActionLabel(__('app.users.actions.invite-user.label.submit'));

        $this->action(function (array $data): void {

            $password = app()->isLocal() ? 'password' : Str::password(12);

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'force_renew_password' => true,
                'password' => bcrypt($password),
            ]);

            $user->assignRole(RoleModel::find($data['role_id']));

            Mail::to($user->email)
                ->send(new MemberInvitationMail($user, $password));

            $this->success();
        });

        $this->successNotificationTitle(fn (?array $data): string => __('app.users.actions.invite-user.notification.success', ['email' => $data['email']]));

        $this->visible(auth()->user()->can('InviteUser:User'));

    }
}
