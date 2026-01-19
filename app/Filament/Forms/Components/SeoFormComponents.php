<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Str;

class SeoFormComponents
{
    public static function getTitle(): TextInput
    {
        return TextInput::make('seo.title')
            ->label(__('app.general.seo.form.label.title'))
            ->hint(function (?string $state): string {
                return (string) Str::of(strlen($state))
                    ->append(' / ')
                    ->append(60 .' ')
                    ->append(__('app.general.characters'));
            })
            ->maxLength(60)
            ->live();
    }

    public static function getAuthor(): TextInput
    {
        return TextInput::make('seo.author')
            ->label(__('app.general.seo.form.label.author'));
    }

    public static function getDescription(): Textarea
    {
        return Textarea::make('seo.description')
            ->label(__('app.general.seo.form.label.description'))
            ->hint(function (?string $state): string {
                return (string) Str::of(strlen($state))
                    ->append(' / ')
                    ->append(160 .' ')
                    ->append(__('app.general.characters'));
            })
            ->maxLength(160)
            ->live();
    }

    public static function getRobots(): Select
    {
        return Select::make('seo.robots')
            ->label(__('app.general.seo.form.label.robots'))
            ->native(false)
            ->selectablePlaceholder(false)
            ->options([
                'index, follow' => 'Index, Follow',
                'index, nofollow' => 'Index, Nofollow',
                'noindex, follow' => 'Noindex, Follow',
                'noindex, nofollow' => 'Noindex, Nofollow',
            ]);
    }
}
