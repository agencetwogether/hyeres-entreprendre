<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Filament\Resources\Users\Schemas\Components\UserFields;
use Filament\Facades\Filament;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('app.users.form.section.role_title'))
                    ->description(__('app.users.form.section.role_description'))
                    ->icon('phosphor-key')
                    ->iconColor('danger')
                    ->schema([
                        UserFields::getFieldRoles(),
                    ])
                    ->columnSpan(fn () => auth()->user()->isSuperAdmin() ? 1 : 2),
                Section::make(__('app.users.form.section.parameter_title'))
                    ->description(__('app.users.form.section.parameter_description'))
                    ->icon('phosphor-gear-six')
                    ->iconColor('warning')
                    ->schema([
                        UserFields::getFieldIsActive(),
                    ])
                    ->visible(auth()->user()->isSuperAdmin())
                    ->columnSpan(1),

                Section::make(__('app.users.form.section.information_title'))
                    ->description(__('app.users.form.section.information_description'))
                    ->icon('phosphor-identification-card')
                    ->iconColor('success')
                    ->schema([
                        UserFields::getAvatar(),
                        UserFields::getName()
                            ->columnSpan(1)
                            ->columnStart(1),
                        UserFields::getEmail(),
                        UserFields::getFirstname(),
                        UserFields::getPhone(),
                        UserFields::getFieldPassword()
                            ->visible(fn (Model $record): bool => Filament::auth()->user()->id !== $record->id),
                    ])
                    ->columns(),
            ]);
    }
}
