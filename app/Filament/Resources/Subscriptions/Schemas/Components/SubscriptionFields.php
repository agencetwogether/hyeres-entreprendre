<?php

namespace App\Filament\Resources\Subscriptions\Schemas\Components;

use App\Models\Member;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Laravelcm\Subscriptions\Models\Plan;

class SubscriptionFields
{
    public static function getName(): Hidden
    {
        return Hidden::make('name');
    }

    public static function getSubscriberType(): Select
    {
        return Select::make('subscriber_type')
            ->label(__('app.subscriptions.form.label.subscriber_type'))
            ->options([Member::class => __('app.subscriptions.form.label.members')])
            ->afterStateUpdated(fn (Get $get, Set $set) => $set('subscriber_id', null))
            ->preload()
            ->live()
            ->searchable();
    }

    public static function getSubscriberId(): Select
    {
        return Select::make('subscriber_id')
            ->label(__('app.subscriptions.form.label.subscriber'))
            ->options(fn (Get $get): array => $get('subscriber_type') ? $get('subscriber_type')::pluck('name', 'id')->toArray() : [])
            ->searchable();
    }

    public static function getPlanId(): Select
    {
        return Select::make('plan_id')
            ->columnSpanFull()
            ->searchable()
            ->label(__('app.subscriptions.form.label.plan'))
            ->options(fn (): array => once(fn () => Plan::query()->where('is_active', 1)->pluck('name', 'id')->toArray()))
            ->afterStateUpdated(function (Get $get, Set $set) {
                $set('name', $get('plan_id') ? Plan::find($get('plan_id'))->name : null);
            })
            ->required();
    }

    public static function getUseCustomDates(): Toggle
    {
        return Toggle::make('use_custom_dates')
            ->columnSpanFull()
            ->label(__('app.subscriptions.form.label.use_custom_dates'))
            ->live()
            ->required();
    }

    public static function getTrialEndsAt(): DatePicker
    {
        return DatePicker::make('trial_ends_at')
            ->label(__('app.subscriptions.form.label.trial_ends_at'))
            ->visible(fn (Get $get): bool => filled($get('use_custom_dates')))
            ->required(fn (Get $get): bool => filled($get('use_custom_dates')));
    }

    public static function getStartsAt(): DatePicker
    {
        return DatePicker::make('starts_at')
            ->label(__('app.subscriptions.form.label.starts_at'))
            ->visible(fn (Get $get): bool => filled($get('use_custom_dates')))
            ->required(fn (Get $get): bool => filled($get('use_custom_dates')));
    }

    public static function getEndsAt(): DatePicker
    {
        return DatePicker::make('ends_at')
            ->label(__('app.subscriptions.form.label.ends_at'))
            ->visible(fn (Get $get): bool => filled($get('use_custom_dates')))
            ->required(fn (Get $get): bool => filled($get('use_custom_dates')));
    }

    public static function getCanceledAt(): DatePicker
    {
        return DatePicker::make('canceled_at')
            ->label(__('app.subscriptions.form.label.canceled_at'))
            ->visible(fn (Get $get): bool => filled($get('use_custom_dates')))
            ->required(fn (Get $get): bool => filled($get('use_custom_dates')));
    }
}
