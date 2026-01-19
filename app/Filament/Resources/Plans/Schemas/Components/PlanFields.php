<?php

namespace App\Filament\Resources\Plans\Schemas\Components;

use App\Enums\IntervalPeriod;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class PlanFields
{
    public static function getName(): TextInput
    {
        return TextInput::make('name')
            ->label(__('app.plans.form.label.name'))
            ->columnSpanFull()
            ->required();
    }

    public static function getDescription(): RichEditor
    {
        return RichEditor::make('description')
            ->label(__('app.plans.form.label.description'))
            ->customHeight()
            ->columnSpanFull();
    }

    public static function getCurrency(): Hidden
    {
        return Hidden::make('currency')
            ->default('EUR');
    }

    public static function getPrice(): TextInput
    {
        return TextInput::make('price')
            ->default(0)
            ->label(__('app.plans.form.label.price'))
            ->required()
            ->numeric()
            ->suffix('€');
    }

    public static function getSignupFee(): TextInput
    {
        return TextInput::make('signup_fee')
            ->label(__('app.plans.form.label.signup_fee'))
            ->default(0)
            ->numeric()
            ->suffix('€');
    }

    public static function getInvoiceInterval(): Select
    {
        return Select::make('invoice_interval')
            ->native(false)
            ->selectablePlaceholder(false)
            ->default(IntervalPeriod::YEAR->value)
            ->label(__('app.plans.form.label.invoice_interval'))
            ->options([
                IntervalPeriod::DAY->value => __('app.plans.form.label.day'),
                IntervalPeriod::MONTH->value => __('app.plans.form.label.month'),
                IntervalPeriod::YEAR->value => __('app.plans.form.label.year'),
            ])
            ->required();
    }

    public static function getInvoicePeriod(): TextInput
    {
        return TextInput::make('invoice_period')
            ->label(__('app.plans.form.label.invoice_period'))
            ->default(0)
            ->numeric()
            ->required();
    }

    public static function getTrialInterval(): Select
    {
        return Select::make('trial_interval')
            ->native(false)
            ->selectablePlaceholder(false)
            ->default(IntervalPeriod::MONTH->value)
            ->label(__('app.plans.form.label.trial_interval'))
            ->options([
                IntervalPeriod::DAY->value => __('app.plans.form.label.day'),
                IntervalPeriod::MONTH->value => __('app.plans.form.label.month'),
                IntervalPeriod::YEAR->value => __('app.plans.form.label.year'),
            ]);
    }

    public static function getTrialPeriod(): TextInput
    {
        return TextInput::make('trial_period')
            ->label(__('app.plans.form.label.trial_period'))
            ->default(0)
            ->numeric();
    }

    public static function getIsActive(): Toggle
    {
        return Toggle::make('is_active')
            ->label(__('app.plans.form.label.is_active'));
    }
}
