<?php

namespace App\Filament\Resources\Categories\Schemas;

use App\Filament\Resources\Categories\CategoryResource;
use App\Filament\Resources\Categories\Schemas\Components\CategoryFields;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('app.categories.form.section.category.title'))
                    ->icon(CategoryResource::getNavigationIcon())
                    ->iconColor('primary')
                    ->description(__('app.categories.form.section.category.description'))
                    ->schema([
                        CategoryFields::getName(),
                        CategoryFields::getSlug(),
                        CategoryFields::getDescription(),
                        CategoryFields::getIsVisible(),
                    ])
                    ->columns(),
            ]);
    }
}
