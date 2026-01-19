<?php

namespace App\Filament\Resources\Plans\Tables\Components;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;

class PlanColumns
{
    public static function getName(): TextColumn
    {
        return TextColumn::make('name')
            ->label(__('app.plans.table.label.name'))
            ->sortable()
            ->searchable();
    }

    public static function getPrice(): TextColumn
    {
        return TextColumn::make('price')
            ->label(__('app.plans.table.label.price'))
            ->sortable()
            ->searchable()
            ->money('EUR')
            ->sortable();
    }

    public static function getIsActive(): ToggleColumn
    {
        return ToggleColumn::make('is_active')
            ->label(__('app.plans.table.label.is_active'));
    }
}
