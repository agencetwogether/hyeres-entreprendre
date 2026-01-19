<?php

namespace App\Filament\Pages;

use App\Filament\Forms\Components\HeaderFormComponents;
use App\Filament\Forms\Components\SeoTab;
use App\Services\RichEditorService;
use App\Settings\LegalSettings;
use BackedEnum;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Forms\Components\RichEditor;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Illuminate\Contracts\Support\Htmlable;

class PageLegalSettings extends SettingsPage
{
    use HasPageShield;

    protected static string $settings = LegalSettings::class;

    protected static string|null|BackedEnum $navigationIcon = 'phosphor-read-cv-logo';

    protected static ?int $navigationSort = 6;

    protected static ?string $slug = 'gestion-page-mentions-legales';

    public static function getNavigationGroup(): ?string
    {
        return __('app.general.navigation.groups.pages');
    }

    public function getTitle(): string|Htmlable
    {
        return __('app.pages.legal-page-settings.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('app.pages.legal-page-settings.navigation_title');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('legal-settings-tabs')
                    ->tabs([
                        Tab::make(__('app.pages.legal-page-settings.form.tabs.general.title'))
                            ->icon('phosphor-gear-six')
                            ->schema([
                                HeaderFormComponents::getHeaderSection(),
                                Section::make(__('app.pages.legal-page-settings.form.tabs.general.section.content.title'))
                                    ->description(__('app.pages.legal-page-settings.form.tabs.general.section.content.description'))
                                    ->icon('phosphor-article')
                                    ->iconColor('primary')
                                    ->schema([
                                        RichEditor::make('content.content')
                                            ->label(__('app.pages.legal-page-settings.form.tabs.general.content'))
                                            ->hiddenLabel()
                                            ->maxHeight()
                                            ->toolbarButtons(fn (RichEditorService $editorService) => $editorService->getToolbarButtonsEditorSimpleWithHeading())
                                            ->required(),
                                    ]),
                            ]),
                        SeoTab::make(),
                    ])
                    ->columns()
                    ->columnSpanFull(),
            ]);
    }
}
