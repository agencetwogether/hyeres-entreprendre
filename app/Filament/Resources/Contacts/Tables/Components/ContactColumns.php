<?php

namespace App\Filament\Resources\Contacts\Tables\Components;

use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Ysfkaya\FilamentPhoneInput\Tables\PhoneColumn;

class ContactColumns
{
    public static function getStatus(): TextColumn
    {
        return TextColumn::make('status')
            ->label(__('app.contacts.table.label.status'))
            ->badge();
    }

    public static function getCompleteName(): TextColumn
    {
        return TextColumn::make('complete_name')
            ->label(__('app.contacts.table.label.name'))
            ->html()
            ->searchable(query: function (Builder $query, string $search): Builder {
                return $query
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('firstname', 'like', "%{$search}%");
            })
            ->state(fn (Model $record): string => $record->firstname.' '.$record->name)
            ->sortable();
    }

    public static function getEmail(): TextColumn
    {
        return TextColumn::make('email')
            ->label(__('app.contacts.table.label.email'))
            ->copyable()
            ->copyMessage(__('app.general.copy_email'))
            ->searchable()
            ->sortable();
    }

    public static function getPhone(): PhoneColumn
    {
        return PhoneColumn::make('phone')
            ->label(__('app.contacts.table.label.phone'));
    }

    public static function getCreatedAt(): TextColumn
    {
        return TextColumn::make('created_at')
            ->label(__('app.contacts.table.label.created_at'))
            ->date('l j F Y')
            ->badge()
            ->color(fn ($state): string => $state <= now()->subMonth() ? 'warning' : 'success')
            ->sortable();
    }
}
