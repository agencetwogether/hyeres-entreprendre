<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;

class HeaderFormComponents
{
    public static function getTitle(): TextInput
    {
        return TextInput::make('header.title')
            ->label(__('app.general.header-settings.form.label.title'));
    }

    public static function getDescription(): TextInput
    {
        return TextInput::make('header.description')
            ->label(__('app.general.header-settings.form.label.description'));
    }

    public static function getBanner(): FileUpload
    {
        return FileUpload::make('header.banner')
            ->label(__('app.general.header-settings.form.label.banner'))
            ->directory('banner-page')
            ->image()
            ->optimize('webp')
            ->imageAspectRatio('16:9')
            ->automaticallyOpenImageEditorForAspectRatio()
            ->automaticallyCropImagesToAspectRatio()
            ->automaticallyResizeImagesMode('cover')
            ->automaticallyResizeImagesToWidth('1920')
            ->automaticallyResizeImagesToHeight('1080');
    }

    public static function getShowDefaultBanner(): Toggle
    {
        return Toggle::make('header.show_default_banner')
            ->label(__('app.general.header-settings.form.label.show_default_banner'))
            ->onColor('success')
            ->visible(fn (Get $get): bool => blank($get('header.banner')))
            ->columnSpanFull();
    }

    public static function getHeaderSection(): Section
    {
        return Section::make(__('app.general.header-settings.form.section.title'))
            ->description(__('app.general.header-settings.form.section.description'))
            ->icon('phosphor-subtitles')
            ->iconColor('primary')
            ->schema([
                Grid::make()
                    ->schema([
                        Group::make()
                            ->schema([
                                static::getBanner(),
                                static::getShowDefaultBanner(),
                            ])
                            ->columnSpan(1),

                        Group::make()
                            ->schema([
                                static::getTitle(),
                                static::getDescription(),
                            ])
                            ->columnSpan(1),
                    ])
                    ->columns(),

            ]);
    }
}
