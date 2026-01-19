<?php

namespace App\Filament\Pages;

use App\Filament\Forms\Components\HeaderFormComponents;
use App\Filament\Forms\Components\SeoTab;
use App\Services\RichEditorService;
use App\Settings\PolicySettings;
use BackedEnum;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Forms\Components\RichEditor;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Illuminate\Contracts\Support\Htmlable;

class PagePolicySettings extends SettingsPage
{
    use HasPageShield;

    protected static string $settings = PolicySettings::class;

    protected static string|null|BackedEnum $navigationIcon = 'phosphor-read-cv-logo';

    protected static ?int $navigationSort = 7;

    protected static ?string $slug = 'gestion-page-politique-de-confidentialite';

    public static function getNavigationGroup(): ?string
    {
        return __('app.general.navigation.groups.pages');
    }

    public function getTitle(): string|Htmlable
    {
        return __('app.pages.policy-page-settings.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('app.pages.policy-page-settings.navigation_title');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('policy-settings-tabs')
                    ->tabs([
                        Tab::make(__('app.pages.policy-page-settings.form.tabs.general.title'))
                            ->icon('phosphor-gear-six')
                            ->schema([
                                HeaderFormComponents::getHeaderSection(),
                                Section::make(__('app.pages.policy-page-settings.form.tabs.general.section.content.title'))
                                    ->description(__('app.pages.policy-page-settings.form.tabs.general.section.content.description'))
                                    ->icon('phosphor-article')
                                    ->iconColor('primary')
                                    ->schema([
                                        RichEditor::make('content.content')
                                            ->label(__('app.pages.policy-page-settings.form.tabs.general.content'))
                                            ->maxHeight()
                                            ->toolbarButtons(fn (RichEditorService $editorService) => $editorService->getToolbarButtonsEditorSimpleWithHeading())
                                            ->hiddenLabel()
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
