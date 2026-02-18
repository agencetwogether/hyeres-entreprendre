<?php

namespace App\Filament\Pages\Auth;

use App\Filament\Resources\Users\Schemas\Components\UserFields;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Actions\Action;
use Filament\Auth\Pages\EditProfile as BaseEditProfile;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Schema;
use Filament\Support\Exceptions\Halt;
use Illuminate\Contracts\Support\Htmlable;
use Livewire\Attributes\On;

class EditProfile extends BaseEditProfile
{
    use HasPageShield;

    protected string $view = 'filament.pages.auth.edit-profile';

    public function getTitle(): string|Htmlable
    {
        return __('app.pages.auth.edit_profile.title');
    }

    protected static ?string $slug = 'profil';

    protected static bool $shouldRegisterNavigation = false;

    public ?array $profileData = [];

    public ?array $passwordData = [];

    public function mount(): void
    {
        $this->getUser()->loadMissing(['roles']);
        $this->fillForms();
    }

    protected function getForms(): array
    {
        return [
            'editProfileForm',
            'editPasswordForm',
        ];
    }

    public function editProfileForm(Schema $schema): Schema
    {
        return $schema
            ->components([
                UserFields::getAvatar()
                    ->columnSpan(1),
                Group::make()
                    ->schema([
                        UserFields::getFirstname(),
                        UserFields::getName(),
                    ])
                    ->columnSpan(3),

                UserFields::getEmail()
                    ->columnSpan(2),
                UserFields::getPhone()
                    ->columnSpan(2),
                UserFields::getWantNotify(),
            ])
            ->columns(4)
            ->model($this->getUser())
            ->statePath('profileData');
    }

    public function editPasswordForm(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make([
                    UserFields::getFieldCurrentPassword(),
                    UserFields::getFieldNewPassword(),
                    UserFields::getFieldPasswordConfirmation(),
                ])
                    ->columns(),
            ])
            ->model($this->getUser())
            ->statePath('passwordData');
    }

    public function updateProfile(): void
    {
        try {
            $data = $this->editProfileForm->getState();

            $this->handleRecordUpdate($this->getUser(), $data);
        } catch (Halt $exception) {
            return;
        }

        $this->sendSuccessNotification(__('app.pages.auth.edit_profile.notification.information_title'));

        $this->dispatch('refresh-topbar');
    }

    public function updatePassword(): void
    {
        try {
            $data = $this->editPasswordForm->getState();

            $this->handleRecordUpdate($this->getUser(), $data);
        } catch (Halt $exception) {
            return;
        }

        if (request()->hasSession() && array_key_exists('password', $data)) {
            request()->session()->put([
                'password_hash_'.Filament::getAuthGuard() => $data['password'],
            ]);
        }

        $this->data['password'] = null;
        $this->data['passwordConfirmation'] = null;

        $this->editPasswordForm->fill();

        $this->sendSuccessNotification(__('app.pages.auth.edit_profile.notification.password_title'));
    }

    protected function getUpdateProfileFormAction(): Action
    {
        return Action::make('updateProfileAction')
            ->label(__('app.pages.auth.edit_profile.action.label.save'))
            ->submit('editProfileForm');
    }

    protected function getUpdatePasswordFormAction(): Action
    {
        return Action::make('updatePasswordAction')
            ->label(__('app.pages.auth.edit_profile.action.label.save'))
            ->submit('editPasswordForm');
    }

    protected function fillForms(): void
    {
        $data = $this->getUser()->attributesToArray();

        $this->editProfileForm->fill($data);
        $this->editPasswordForm->fill();
    }

    private function sendSuccessNotification(?string $title = null): void
    {
        Notification::make()
            ->success()
            ->title($title)
            ->send();
    }

    #[On('refresh-edit-profile')]
    public function refresh(): void
    {
        $this->fillForms();
    }
}
