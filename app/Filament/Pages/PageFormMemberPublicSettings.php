<?php

namespace App\Filament\Pages;

use App\Filament\Forms\Components\SeoTab;
use App\Services\RichEditorService;
use App\Settings\FormMemberPublicSettings;
use BackedEnum;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Illuminate\Contracts\Support\Htmlable;

class PageFormMemberPublicSettings extends SettingsPage
{
    use HasPageShield;

    protected static string $settings = FormMemberPublicSettings::class;

    protected static string|null|BackedEnum $navigationIcon = 'phosphor-read-cv-logo';

    protected static ?int $navigationSort = 8;

    protected static ?string $slug = 'gestion-page-formulaire-creation-membre-publique';

    public static function getNavigationGroup(): ?string
    {
        return __('app.general.navigation.groups.pages');
    }

    public function getTitle(): string|Htmlable
    {
        return __('app.pages.form-member-public-page-settings.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('app.pages.form-member-public-page-settings.navigation_title');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('form-member-settings-tabs')
                    ->tabs([
                        Tab::make(__('app.pages.form-member-public-page-settings.form.tabs.general.title'))
                            ->icon('phosphor-gear-six')
                            ->schema([
                                Section::make(__('app.pages.form-member-public-page-settings.form.tabs.general.section.content.title'))
                                    ->description(__('app.pages.form-member-public-page-settings.form.tabs.general.section.content.description'))
                                    ->icon('phosphor-text-aa')
                                    ->iconColor('primary')
                                    ->schema([
                                        TextInput::make('content.title')
                                            ->label(__('app.pages.form-member-public-page-settings.form.tabs.general.page_title')),
                                        RichEditor::make('content.text')
                                            ->label(__('app.pages.form-member-public-page-settings.form.tabs.general.text'))
                                            ->textColors(fn (RichEditorService $editorService): array => $editorService->getColors())
                                            ->toolbarButtons(fn (RichEditorService $editorService): array => $editorService->getToolbarButtonsEditorSimpleWithColor())
                                            ->customHeight(),
                                        TextInput::make('content.disclaimer')
                                            ->label(__('app.pages.form-member-public-page-settings.form.tabs.general.disclaimer')),
                                    ]),
                                Section::make(__('app.pages.form-member-public-page-settings.form.tabs.general.section.thank_you.title'))
                                    ->description(__('app.pages.form-member-public-page-settings.form.tabs.general.section.thank_you.description'))
                                    ->icon('phosphor-hands-praying')
                                    ->iconColor('primary')
                                    ->schema([
                                        TextInput::make('content.thanks.title')
                                            ->label(__('app.pages.form-member-public-page-settings.form.tabs.general.page_title')),
                                        RichEditor::make('content.thanks.text')
                                            ->label(__('app.pages.form-member-public-page-settings.form.tabs.general.text'))
                                            ->textColors(fn (RichEditorService $editorService): array => $editorService->getColors())
                                            ->toolbarButtons(fn (RichEditorService $editorService): array => $editorService->getToolbarButtonsEditorSimpleWithColor())
                                            ->customHeight(),
                                    ]),
                            ]),
                        SeoTab::make(),
                    ])
                    ->columns()
                    ->columnSpanFull(),
            ]);
    }
}
