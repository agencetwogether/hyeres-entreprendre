<?php

namespace App\Filament\Resources\Categories\Schemas\Components;

use App\Models\Category;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CategoryFields
{
    public static function getName(): TextInput
    {
        return TextInput::make('name')
            ->label(__('app.categories.form.label.name'))
            ->live(onBlur: true)
            ->afterStateUpdated(function (Get $get, Set $set, ?string $old, ?string $state) {
                if (($get('slug') ?? '') !== Str::slug($old)) {
                    return;
                }

                $set('slug', Str::slug($state));
            })
            ->required()
            ->columnSpanFull();
    }

    public static function getSlug(): TextInput
    {
        return TextInput::make('slug')
            ->label(__('app.categories.form.label.slug'))
            ->required()
            ->unique(Category::class, 'slug', fn (?Model $record) => $record)
            ->readOnly()
            ->columnSpanFull();
    }

    public static function getDescription(): Textarea
    {
        return Textarea::make('description')
            ->label(__('app.categories.form.label.description'))
            ->rows(3)
            ->columnSpanFull();
    }

    public static function getIsVisible(): Toggle
    {
        return Toggle::make('is_visible')
            ->label(__('app.categories.form.label.is_visible'))
            ->default(true)
            ->columnSpanFull();
    }
}
