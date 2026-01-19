<?php

namespace App\Filament\Resources\Plans\Schemas;

use App\Filament\Resources\Plans\PlanResource;
use App\Filament\Resources\Plans\Schemas\Components\PlanFields;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PlanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('app.plans.form.section.title'))
                    ->icon(PlanResource::getNavigationIcon())
                    ->iconColor('primary')
                    ->description(__('app.plans.form.section.description'))
                    ->schema([
                        PlanFields::getName(),
                        PlanFields::getDescription(),
                        PlanFields::getCurrency(),
                        PlanFields::getPrice(),
                        PlanFields::getSignupFee(),
                        PlanFields::getInvoiceInterval(),
                        PlanFields::getInvoicePeriod(),
                        PlanFields::getTrialInterval(),
                        PlanFields::getTrialPeriod(),
                        PlanFields::getIsActive(),
                    ])
                    ->columns(),
            ]);
    }
}
