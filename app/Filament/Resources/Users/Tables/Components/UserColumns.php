<?php

namespace App\Filament\Resources\Users\Tables\Components;

use App\Filament\Resources\Users\Actions\ChangeIsActive;
use App\Filament\Resources\Users\Actions\RenewPassword;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class UserColumns
{
    public static function getTableAvatar(): SpatieMediaLibraryImageColumn
    {
        return SpatieMediaLibraryImageColumn::make('avatar')
            ->label('')
            ->collection('avatar')
            ->conversion('webp')
            ->defaultImageUrl(getFallbackAvatar())
            ->circular();
    }

    public static function getTableCompleteName(): TextColumn
    {
        return TextColumn::make('complete_name')
            ->label(__('app.users.table.label.name'))
            ->state(fn (Model $record): string => $record->getFilamentName())
            ->searchable(query: function (Builder $query, string $search): Builder {
                return $query
                    ->where('name', 'like', "%{$search}%")
                    ->where('firstname', 'like', "%{$search}%");
            });
    }

    public static function getTableEmail(): TextColumn
    {
        return TextColumn::make('email')
            ->label(__('app.users.table.label.email'))
            ->copyable()
            ->copyMessage(__('app.general.copy_email'))
            ->searchable()
            ->toggleable();
    }

    public static function getTableRole(): TextColumn
    {
        return TextColumn::make('roles.name')
            ->label(__('app.users.table.label.role'))
            ->badge()
            ->searchable()
            ->toggleable();
    }

    public static function getTableIsActive(): IconColumn
    {
        return IconColumn::make('is_active')
            ->label(__('app.users.table.label.is_active'))
            ->boolean()
            ->action(ChangeIsActive::make())
            ->visible(auth()->user()->isSuperAdmin())
            ->toggleable();
    }

    public static function getTableForceRenewPassword(): IconColumn
    {
        return IconColumn::make('force_renew_password')
            ->label(__('app.users.table.label.force_renew_password'))
            ->headerTooltip(__('app.users.table.label.force_renew_password_abbr'))
            ->boolean()
            ->action(RenewPassword::make())
            ->visible(auth()->user()->isSuperAdmin())
            ->toggleable(isToggledHiddenByDefault: true);
    }
}
