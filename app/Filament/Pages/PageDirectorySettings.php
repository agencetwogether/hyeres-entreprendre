<?php

namespace App\Filament\Pages;

use App\Filament\Forms\Components\HeaderFormComponents;
use App\Filament\Forms\Components\SeoTab;
use App\Settings\DirectorySettings;
use BackedEnum;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Forms\Components\Slider;
use Filament\Forms\Components\Slider\Enums\PipsMode;
use Filament\Forms\Components\Toggle;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Illuminate\Contracts\Support\Htmlable;

class PageDirectorySettings extends SettingsPage
{
    use HasPageShield;

    protected static string $settings = DirectorySettings::class;

    protected static string|null|BackedEnum $navigationIcon = 'phosphor-read-cv-logo';

    protected static ?int $navigationSort = 2;

    protected static ?string $slug = 'gestion-page-annuaire';

    public static function getNavigationGroup(): ?string
    {
        return __('app.general.navigation.groups.pages');
    }

    public function getTitle(): string|Htmlable
    {
        return __('app.pages.directory-page-settings.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('app.pages.directory-page-settings.navigation_title');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('directory-settings-tabs')
                    ->tabs([
                        Tab::make(__('app.pages.directory-page-settings.form.tabs.general.title'))
                            ->icon('phosphor-gear-six')
                            ->schema([
                                HeaderFormComponents::getHeaderSection(),
                                Section::make(__('app.pages.directory-page-settings.form.tabs.general.section.parameters.title'))
                                    ->description(__('app.pages.directory-page-settings.form.tabs.general.section.parameters.description'))
                                    ->icon('phosphor-sliders')
                                    ->iconColor('primary')
                                    ->schema([
                                        Group::make()
                                            ->schema([
                                                Slider::make('general.item_per_page')
                                                    ->label(__('app.pages.directory-page-settings.form.tabs.general.item_per_page'))
                                                    ->range(minValue: 0, maxValue: 15)
                                                    ->step(3)
                                                    ->rangePadding(3)
                                                    ->pips(PipsMode::Steps),
                                            ])
                                            ->columnSpan(1),
                                        Group::make()
                                            ->schema([
                                                Toggle::make('general.show_filter_member_type')
                                                    ->label(__('app.pages.directory-page-settings.form.tabs.general.show_filter_member_type')),
                                                Toggle::make('general.show_filter_search')
                                                    ->label(__('app.pages.directory-page-settings.form.tabs.general.show_filter_search')),
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
