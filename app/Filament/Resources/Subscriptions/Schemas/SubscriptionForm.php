<?php

namespace App\Filament\Resources\Subscriptions\Schemas;

use App\Filament\Resources\Subscriptions\Schemas\Components\SubscriptionFields;
use Filament\Schemas\Schema;

class SubscriptionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('app.subscriptions.form.section.subscriber.title'))
                    ->icon(static::$navigationIcon)
                    ->iconColor('primary')
                    ->description(__('app.subscriptions.form.section.subscriber.description'))
                    ->schema([
                        SubscriptionFields::getName(),
                        SubscriptionFields::getSubscriberType(),
                        SubscriptionFields::getSubscriberId(),
                    ]),
                Section::make(__('app.subscriptions.form.section.plan.title'))
                    ->icon(static::$navigationIcon)
                    ->iconColor('primary')
                    ->description(__('app.subscriptions.form.section.plan.description'))
                    ->schema([
                        SubscriptionFields::getPlanId(),
                        SubscriptionFields::getUseCustomDates(),
                    ]),
                Section::make(__('app.subscriptions.form.section.custom_dates.title'))
                    ->icon(static::$navigationIcon)
                    ->iconColor('primary')
                    ->description(__('app.subscriptions.form.section.custom_dates.description'))
                    ->schema([
                        SubscriptionFields::getTrialEndsAt(),
                        SubscriptionFields::getStartsAt(),
                        SubscriptionFields::getEndsAt(),
                        SubscriptionFields::getCanceledAt(),
                    ]),
            ]);
    }
}
