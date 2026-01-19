<?php

namespace App\Filament\Resources\Users\Actions;

use Filament\Actions\Action;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Model;

class RenewPassword extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'renewPasswordBool';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->successNotificationTitle(fn (Model $record): string => ! $record->force_renew_password ? __('app.users.actions.renew-password.notification.deactivated.success') : __('app.users.actions.renew-password.notification.activated.success'));

        $this->failureNotificationTitle(fn (Model $record): string => ! $record->force_renew_password ? __('app.users.actions.renew-password.notification.deactivated.fail') : __('app.users.actions.renew-password.notification.activated.fail'));

        $this->action(function (Model $record): void {
            if (Filament::auth()->user()->is($record)) {
                return;
            }

            $record->force_renew_password = ! $record->force_renew_password;
            $result = $record->save();

            if (! $result) {
                $this->failure();

                return;
            }

            $this->success();
        });

        $this->visible(auth()->user()->isSuperAdmin());
    }
}
