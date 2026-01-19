<?php

namespace App\Filament\Pages;

use App\Filament\Forms\Components\HeaderFormComponents;
use App\Filament\Forms\Components\SeoTab;
use App\Services\RichEditorService;
use App\Settings\ContactSettings;
use BackedEnum;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Toggle;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Illuminate\Contracts\Support\Htmlable;

class PageContactSettings extends SettingsPage
{
    use HasPageShield;

    protected static string $settings = ContactSettings::class;

    protected static string|null|BackedEnum $navigationIcon = 'phosphor-read-cv-logo';

    protected static ?int $navigationSort = 5;

    protected static ?string $slug = 'gestion-page-contact';

    public static function getNavigationGroup(): ?string
    {
        return __('app.general.navigation.groups.pages');
    }

    public function getTitle(): string|Htmlable
    {
        return __('app.pages.contact-page-settings.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('app.pages.contact-page-settings.navigation_title');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('contact-settings-tabs')
                    ->tabs([
                        Tab::make(__('app.pages.contact-page-settings.form.tabs.general.title'))
                            ->icon('phosphor-gear-six')
                            ->schema([
                                HeaderFormComponents::getHeaderSection(),
                                Section::make(__('app.pages.contact-page-settings.form.tabs.general.section.content.title'))
                                    ->icon('phosphor-article')
                                    ->iconColor('primary')
                                    ->schema([
                                        FileUpload::make('content.presentation.image')
                                            ->label(__('app.pages.contact-page-settings.form.tabs.general.image'))
                                            ->image()
                                            ->optimize('webp')
                                            ->imageAspectRatio('1:1')
                                            ->automaticallyOpenImageEditorForAspectRatio()
                                            ->automaticallyCropImagesToAspectRatio()
                                            ->automaticallyResizeImagesMode('cover')
                                            ->automaticallyResizeImagesToWidth('800')
                                            ->automaticallyResizeImagesToHeight('800')
                                            ->columnSpan(1),
                                        RichEditor::make('content.presentation.text')
                                            ->label(__('app.pages.contact-page-settings.form.tabs.general.presentation_text'))
                                            ->textColors(fn (RichEditorService $editorService): array => $editorService->getColors())
                                            ->toolbarButtons(fn (RichEditorService $editorService): array => $editorService->getToolbarButtonsEditorSimpleWithColor())
                                            ->customHeight()
                                            ->columnSpan(3),
                                        Group::make()
                                            ->schema([
                                                Toggle::make('content.show_postal_address')
                                                    ->label(__('app.pages.contact-page-settings.form.tabs.general.show_postal_address'))
                                                    ->onColor('success'),
                                                Toggle::make('content.show_phone')
                                                    ->label(__('app.pages.contact-page-settings.form.tabs.general.show_phone'))
                                                    ->onColor('success'),
                                                Toggle::make('content.show_email')
                                                    ->label(__('app.pages.contact-page-settings.form.tabs.general.show_email'))
                                                    ->onColor('success'),
                                                Toggle::make('content.show_map')
                                                    ->label(__('app.pages.contact-page-settings.form.tabs.general.show_map'))
                                                    ->onColor('success')
                                                    ->visible(auth()->user()->isSuperAdmin()),
                                            ])
                                            ->columnSpanFull(),

                                    ])
                                    ->columns(4),
                                Section::make(__('app.pages.contact-page-settings.form.tabs.general.section.legal_form.title'))
                                    ->icon('phosphor-text-aa')
                                    ->iconColor('primary')
                                    ->schema([
                                        RichEditor::make('content.form.text_legal')
                                            ->label(__('app.pages.contact-page-settings.form.tabs.general.text_legal_below_form'))
                                            ->helperText(__('app.pages.contact-page-settings.form.tabs.general.text_legal_below_form_hint'))
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
