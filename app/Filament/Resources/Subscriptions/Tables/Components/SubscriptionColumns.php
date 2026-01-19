<?php

namespace App\Filament\Resources\Subscriptions\Tables\Components;

use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;

class SubscriptionColumns
{
    public static function getSubscriberName(): TextColumn
    {
        return TextColumn::make('subscriber.name')
            ->label(__('app.subscriptions.table.label.subscriber'))
            ->sortable()
            ->searchable();
    }

    public static function getPlanName(): TextColumn
    {
        return TextColumn::make('plan.name')
            ->label(__('app.subscriptions.table.label.plan'))
            ->sortable()
            ->searchable();
    }

    public static function getActive(): IconColumn
    {
        return IconColumn::make('active')
            ->state(fn (Model $record): bool => $record->active())
            ->boolean()
            ->label(__('app.subscriptions.table.label.active'))
            ->sortable()
            ->searchable();
    }

    public static function getTrialEndsAt(): TextColumn
    {
        return TextColumn::make('trial_ends_at')
            ->label(__('app.subscriptions.table.label.trial_ends_at'))
            ->dateTime()
            ->sortable()
            ->toggleable(isToggledHiddenByDefault: true)
            ->searchable();
    }

    public static function getStartsAt(): TextColumn
    {
        return TextColumn::make('starts_at')
            ->label(__('app.subscriptions.table.label.starts_at'))
            ->dateTime()
            ->sortable()
            ->toggleable(isToggledHiddenByDefault: true)
            ->searchable();
    }

    public static function getEndsAt(): TextColumn
    {
        return TextColumn::make('ends_at')
            ->label(__('app.subscriptions.table.label.ends_at'))
            ->dateTime()
            ->sortable()
            ->toggleable(isToggledHiddenByDefault: true)
            ->searchable();
    }

    public static function getCanceledAt(): TextColumn
    {
        return TextColumn::make('canceled_at')
            ->label(__('app.subscriptions.table.label.canceled_at'))
            ->dateTime()
            ->sortable()
            ->toggleable(isToggledHiddenByDefault: true)
            ->searchable();
    }
}
