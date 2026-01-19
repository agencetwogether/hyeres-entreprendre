<?php

namespace App\Filament\Resources\Events\Tables\Components;

use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;

class EventColumns
{
    public static function getThumbnail(): SpatieMediaLibraryImageColumn
    {
        return SpatieMediaLibraryImageColumn::make('featured_image')
            ->label(__('app.events.table.label.featured_image'))
            ->collection('banner')
            ->conversion('square')
            ->circular();
    }

    public static function getTitle(): TextColumn
    {
        return TextColumn::make('title')
            ->label(__('app.events.table.label.title'))
            ->searchable()
            ->sortable();
    }

    public static function getSlug(): TextColumn
    {
        return TextColumn::make('slug')
            ->label(__('app.events.table.label.slug'))
            ->visible(auth()->user()->isSuperAdmin());
    }

    public static function getExcerpt(): TextColumn
    {
        return TextColumn::make('excerpt')
            ->label(__('app.events.table.label.excerpt'))
            ->words(10)
            ->toggleable(isToggledHiddenByDefault: true);
    }

    public static function getDateStart(): TextColumn
    {
        return TextColumn::make('date_start')
            ->label(__('app.events.table.label.date_start'))
            ->date(getDisplayDate().' H:i')
            ->searchable()
            ->sortable();
    }

    public static function getDateEnd(): TextColumn
    {
        return TextColumn::make('date_end')
            ->label(__('app.events.table.label.date_end'))
            ->date(getDisplayDate().' H:i')
            ->searchable()
            ->toggleable(isToggledHiddenByDefault: true)
            ->sortable();
    }

    public static function getPublishedAt(): TextColumn
    {
        return TextColumn::make('published_at')
            ->label(__('app.events.table.label.published_at'))
            ->date(getDisplayDate())
            ->searchable()
            ->toggleable(isToggledHiddenByDefault: true)
            ->sortable();
    }

    public static function getLocation(): TextColumn
    {
        return TextColumn::make('location')
            ->label(__('app.events.table.label.location'))
            ->searchable()
            ->toggleable()
            ->sortable();
    }

    public static function getPrice(): TextColumn
    {
        return TextColumn::make('price')
            ->label(__('app.events.table.label.price'))
            ->searchable()
            ->toggleable(isToggledHiddenByDefault: true)
            ->sortable();
    }
}
