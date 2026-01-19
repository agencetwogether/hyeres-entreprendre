<?php

namespace App\Filament\Resources\Users\Schemas\Components;

use App\Enums\Role;
use App\Enums\Role as RoleEnum;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;

class UserFields
{
    public static function getAvatar(): SpatieMediaLibraryFileUpload
    {
        return SpatieMediaLibraryFileUpload::make('avatar')
            // ->label(__('app.pages.auth.edit_profile.form.label.avatar'))
            ->label(__('app.users.form.label.avatar'))
            ->collection('avatar')
            ->avatar()
            ->disk('public')
            ->visibility('public')
            ->imageAspectRatio('1:1')
            ->automaticallyOpenImageEditorForAspectRatio()
            ->automaticallyCropImagesToAspectRatio()
            ->automaticallyResizeImagesMode('cover')
            ->automaticallyResizeImagesToWidth('400')
            ->automaticallyResizeImagesToHeight('400');
    }

    public static function getFirstname(): TextInput
    {
        return TextInput::make('firstname')
            // ->label(__('app.pages.auth.edit_profile.form.label.firstname'))
            ->label(__('app.users.form.label.firstname'))
            ->required()
            ->dehydrateStateUsing(fn (string $state): string => Str::title($state))
            ->columnSpan(1);
    }

    public static function getName(): TextInput
    {
        return TextInput::make('name')
            // ->label(__('app.pages.auth.edit_profile.form.label.name'))
            ->label(__('app.users.form.label.name'))
            ->required()
            ->dehydrateStateUsing(fn (string $state): string => Str::title($state))
            ->columnSpan(1);
    }

    public static function getEmail(): TextInput
    {
        return TextInput::make('email')
            // ->label(__('app.pages.auth.edit_profile.form.label.email'))
            ->label(__('app.users.form.label.email'))
            ->email()
            ->unique(ignoreRecord: true)
            ->rules(['email:rfc,dns'])
            ->required();
    }

    public static function getPhone(): PhoneInput
    {
        return PhoneInput::make('phone')
            // ->label(__('app.pages.auth.edit_profile.form.label.phone'))
            ->label(__('app.users.form.label.phone'))
            ->required()
            ->columnSpan(1);
    }

    public static function getWantNotify(): Toggle
    {
        return Toggle::make('want_notify')
            ->label(__('app.pages.auth.edit_profile.form.label.want_notify'))
            ->helperText(__('app.pages.auth.edit_profile.form.placeholder.want_notify_hint'))
            ->onColor('success')
            ->default(true)
            ->columnSpanFull();
    }

    public static function getFieldPassword(): TextInput
    {
        return TextInput::make('password')
            ->label(__('app.users.form.label.password'))
            ->password()
            ->revealable()
            ->autocomplete('new-password')
            ->rule(Password::defaults())
            ->dehydrated(fn (?string $state): bool => filled($state))
            ->required(fn (string $context): bool => $context === 'create')
            ->maxLength(255)
            ->columnSpanFull();
    }

    public static function getFieldCurrentPassword(): TextInput
    {
        return TextInput::make('current_password')
            ->label(__('app.pages.auth.edit_profile.form.label.current_password'))
            ->password()
            ->revealable()
            ->required()
            ->autocomplete('current-password')
            ->currentPassword()
            ->columnSpan(1);
    }

    public static function getFieldNewPassword(): TextInput
    {
        return TextInput::make('password')
            ->label(__('app.pages.auth.edit_profile.form.label.new_password'))
            ->password()
            ->revealable()
            ->required()
            ->rule(Password::defaults())
            ->autocomplete('new-password')
            ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
            ->live(debounce: 500)
            ->same('passwordConfirmation')
            ->columnStart(1)
            ->columnSpan(1);
    }

    public static function getFieldPasswordConfirmation(): TextInput
    {
        return TextInput::make('passwordConfirmation')
            ->label(__('app.pages.auth.edit_profile.form.label.confirmation_new_password'))
            ->password()
            ->revealable()
            ->required()
            ->dehydrated(false)
            ->columnSpan(1);
    }

    public static function getFieldSendEmail(): Toggle
    {
        return Toggle::make('sendEmail');
    }

    public static function getFieldEmailInvite(): TextInput
    {
        return TextInput::make('email')
            ->label(__('app.users.form.label.email'))
            ->email()
            ->unique(table: User::class)
            ->rules(['email:rfc,dns'])
            ->required();
    }

    public static function getFieldRoleId(): Select
    {
        return Select::make('role_id')
            ->label(__('app.users.form.label.role'))
            ->relationship(
                name: 'roles',
                titleAttribute: 'name',
                modifyQueryUsing: function (Builder $query): Builder {
                    if (auth()->user()->isSuperAdmin()) {
                        return $query->whereNotIn('name', [Role::SUPERADMIN]);
                    }

                    // remove super_admin & admin roles
                    return $query->whereNotIn('name', [Role::SUPERADMIN, Role::ADMIN]);
                })
            ->preload()
            ->native(false)
            ->getOptionLabelFromRecordUsing(fn (?Model $record): string => $record?->name->getLabel())
            ->placeholder(__('app.users.form.placeholder.role'))
            ->required();
    }

    public static function getFieldRoles(): Select
    {
        return Select::make('roles')
            ->hiddenLabel()
            ->relationship('roles', 'name', function (Builder $query): Builder {
                if (auth()->user()->isSuperAdmin()) {
                    return $query;
                }

                return $query->whereNot(function (Builder $query) {
                    $query->where('name', RoleEnum::SUPERADMIN)
                        ->orWhere('name', RoleEnum::ADMIN);
                });
            })
            ->getOptionLabelFromRecordUsing(fn (?Model $record): string => $record?->name->getLabel())
            ->placeholder(__('app.users.form.placeholder.roles'))
            ->multiple()
            ->preload()
            ->minItems(1)
            ->live();
    }

    public static function getFieldIsActive(): Toggle
    {
        return Toggle::make('is_active')
            ->label(__('app.users.form.label.is_active'))
            ->default(true)
            ->inline()
            ->onColor('success')
            ->offColor('danger');
    }
}
