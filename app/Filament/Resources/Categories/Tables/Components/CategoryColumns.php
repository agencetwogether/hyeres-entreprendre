<?php

namespace App\Filament\Resources\Categories\Tables\Components;

use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;

class CategoryColumns
{
    public static function getName(): TextColumn
    {
        return TextColumn::make('name')
            ->label(__('app.categories.table.label.name'))
            ->searchable()
            ->sortable();
    }

    public static function getSlug(): TextColumn
    {
        return TextColumn::make('slug')
            ->label(__('app.categories.table.label.slug'));
    }

    public static function getDescription(): TextColumn
    {
        return TextColumn::make('description')
            ->label(__('app.categories.table.label.description'))
            ->words(10)
            ->visible(auth()->user()->isSuperAdmin());
    }

    public static function getIsVisible(): IconColumn
    {
        return IconColumn::make('is_visible')
            ->label(__('app.categories.table.label.is_visible'))
            ->boolean();
    }
}
