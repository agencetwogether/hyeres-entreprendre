<?php

namespace App\Filament\Pages;

use App\Filament\Forms\Components\SeoTab;
use App\Settings\HomeSettings;
use BackedEnum;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;
use Illuminate\Contracts\Support\Htmlable;

class PageHomeSettings extends SettingsPage
{
    use HasPageShield;

    protected static string $settings = HomeSettings::class;

    protected static string|null|BackedEnum $navigationIcon = 'phosphor-read-cv-logo';

    protected static ?int $navigationSort = 1;

    protected static ?string $slug = 'gestion-page-accueil';

    public static function getNavigationGroup(): ?string
    {
        return __('app.general.navigation.groups.pages');
    }

    public function getTitle(): string|Htmlable
    {
        return __('app.pages.home-page-settings.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('app.pages.home-page-settings.navigation_title');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('home-settings-tabs')
                    ->tabs([
                        SeoTab::make(),
                    ])
                    ->columns()
                    ->columnSpanFull(),
            ]);
    }
}
