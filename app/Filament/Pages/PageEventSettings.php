<?php

namespace App\Filament\Pages;

use App\Filament\Forms\Components\HeaderFormComponents;
use App\Filament\Forms\Components\SeoTab;
use App\Settings\EventSettings;
use BackedEnum;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Forms\Components\Slider;
use Filament\Forms\Components\Slider\Enums\PipsMode;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Illuminate\Contracts\Support\Htmlable;

class PageEventSettings extends SettingsPage
{
    use HasPageShield;

    protected static string $settings = EventSettings::class;

    protected static string|null|BackedEnum $navigationIcon = 'phosphor-read-cv-logo';

    protected static ?int $navigationSort = 4;

    protected static ?string $slug = 'gestion-page-evenements';

    public static function getNavigationGroup(): ?string
    {
        return __('app.general.navigation.groups.pages');
    }

    public function getTitle(): string|Htmlable
    {
        return __('app.pages.event-page-settings.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('app.pages.event-page-settings.navigation_title');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('event-settings-tabs')
                    ->tabs([
                        Tab::make(__('app.pages.event-page-settings.form.tabs.general.title'))
                            ->icon('phosphor-gear-six')
                            ->schema([
                                HeaderFormComponents::getHeaderSection(),
                                Section::make(__('app.pages.event-page-settings.form.tabs.general.section.parameters.title'))
                                    ->description(__('app.pages.event-page-settings.form.tabs.general.section.parameters.description'))
                                    ->icon('phosphor-sliders')
                                    ->iconColor('primary')
                                    ->schema([
                                        Group::make()
                                            ->schema([
                                                Slider::make('general.event_per_page')
                                                    ->label(__('app.pages.event-page-settings.form.tabs.general.event_per_page'))
                                                    ->range(minValue: 0, maxValue: 12)
                                                    ->step(2)
                                                    ->rangePadding(2)
                                                    ->pips(PipsMode::Steps),
                                            ])
                                            ->columnSpan(1),
                                        Group::make()
                                            ->schema([
                                                Slider::make('general.event_per_loading')
                                                    ->label(__('app.pages.event-page-settings.form.tabs.general.event_per_loading'))
                                                    ->range(minValue: 0, maxValue: 12)
                                                    ->step(2)
                                                    ->rangePadding(2)
                                                    ->pips(PipsMode::Steps),
                                            ])
                                            ->columnSpan(1),
                                    ])
                                    ->columns(),
                            ]),
                        SeoTab::make(),
                    ])
                    ->columns()
                    ->columnSpanFull(),
            ]);
    }
}
