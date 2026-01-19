<?php

namespace App\Filament\Resources\Posts\Tables\Components;

use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;

class PostColumns
{
    public static function getThumbnail(): SpatieMediaLibraryImageColumn
    {
        return SpatieMediaLibraryImageColumn::make('featured_image')
            ->label(__('app.posts.table.label.featured_image'))
            ->collection('featured_image')
            ->conversion('square')
            ->circular();
    }

    public static function getTitle(): TextColumn
    {
        return TextColumn::make('title')
            ->label(__('app.posts.table.label.title'))
            ->searchable()
            ->sortable();
    }

    public static function getSlug(): TextColumn
    {
        return TextColumn::make('slug')
            ->label(__('app.posts.table.label.slug'))
            ->visible(auth()->user()->isSuperAdmin());
    }

    public static function getExcerpt(): TextColumn
    {
        return TextColumn::make('excerpt')
            ->label(__('app.posts.table.label.excerpt'))
            ->words(10)
            ->toggleable(isToggledHiddenByDefault: true);
    }

    public static function getPublishedAt(): TextColumn
    {
        return TextColumn::make('published_at')
            ->label(__('app.posts.table.label.published_at'))
            ->date(getDisplayDate())
            ->searchable()
            ->sortable()
            ->toggleable(isToggledHiddenByDefault: true);
    }

    public static function getAuthor(): TextColumn
    {
        return TextColumn::make('author.fullname')
            ->label(__('app.posts.table.label.author'))
            ->searchable()
            ->sortable()
            ->toggleable(isToggledHiddenByDefault: true);
    }

    public static function getCategory(): TextColumn
    {
        return TextColumn::make('category.name')
            ->label(__('app.posts.table.label.category'))
            ->searchable()
            ->sortable()
            ->toggleable();
    }
}
