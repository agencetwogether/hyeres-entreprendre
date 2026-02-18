<?php

namespace App\Filament\Pages;

use App\Enums\SocialNetwork;
use App\Settings\GeneralSettings;
use Asmit\FilamentUpload\Forms\Components\AdvancedFileUpload;
use BackedEnum;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Callout;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;

class ManageGeneralSettings extends SettingsPage
{
    use HasPageShield;

    protected static string $settings = GeneralSettings::class;

    protected static string|null|BackedEnum $navigationIcon = 'heroicon-o-cog-6-tooth';

    public static function getNavigationGroup(): ?string
    {
        return __('app.general.navigation.groups.settings');
    }

    public function getTitle(): string|Htmlable
    {
        return __('app.pages.manage-settings.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('app.pages.manage-settings.navigation_title');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('settings-tabs')
                    ->tabs([
                        Tab::make(__('app.pages.manage-settings.form.tabs.general'))
                            ->icon('phosphor-gear-six')
                            ->schema([
                                FileUpload::make('fallback_avatar')
                                    ->label(__('app.pages.manage-settings.form.label.fallback_avatar'))
                                    ->directory('default')
                                    ->image()
                                    ->optimize('webp')
                                    ->imageAspectRatio('1:1')
                                    ->automaticallyOpenImageEditorForAspectRatio()
                                    ->automaticallyCropImagesToAspectRatio()
                                    ->automaticallyResizeImagesMode('cover')
                                    ->automaticallyResizeImagesToWidth('400')
                                    ->automaticallyResizeImagesToHeight('400'),
                                FileUpload::make('fallback_logo')
                                    ->label(__('app.pages.manage-settings.form.label.fallback_logo'))
                                    ->directory('default')
                                    ->image()
                                    ->optimize('webp')
                                    ->imageAspectRatio('16:9')
                                    ->automaticallyOpenImageEditorForAspectRatio()
                                    ->automaticallyCropImagesToAspectRatio()
                                    ->automaticallyResizeImagesMode('cover')
                                    ->automaticallyResizeImagesToWidth('200')
                                    ->automaticallyResizeImagesToHeight('113'),
                                TextInput::make('display_date')
                                    ->label(__('app.pages.manage-settings.form.label.display_date')),
                            ])
                            ->visible(auth()->user()->isSuperAdmin()),
                        Tab::make(auth()->user()->isAdmin() ? __('app.pages.manage-settings.form.tabs.client_admin') : __('app.pages.manage-settings.form.tabs.client'))
                            ->icon('phosphor-identification-card')
                            ->schema([
                                FileUpload::make('client_logo')
                                    ->label(__('app.pages.manage-settings.form.label.client_logo'))
                                    ->directory('client')
                                    ->image()
                                    ->optimize('webp')
                                    ->imageAspectRatio('16:9')
                                    ->automaticallyOpenImageEditorForAspectRatio()
                                    ->automaticallyCropImagesToAspectRatio()
                                    ->automaticallyResizeImagesMode('cover')
                                    ->automaticallyResizeImagesToWidth('200')
                                    ->automaticallyResizeImagesToHeight('113'),
                                FileUpload::make('client_logo_dark')
                                    ->label(__('app.pages.manage-settings.form.label.client_logo_dark'))
                                    ->directory('client')
                                    ->image()
                                    ->optimize('webp')
                                    ->imageAspectRatio('16:9')
                                    ->automaticallyOpenImageEditorForAspectRatio()
                                    ->automaticallyCropImagesToAspectRatio()
                                    ->automaticallyResizeImagesMode('cover')
                                    ->automaticallyResizeImagesToWidth('200')
                                    ->automaticallyResizeImagesToHeight('113'),
                                TextInput::make('client_name')
                                    ->label(__('app.pages.manage-settings.form.label.client_name')),
                                PhoneInput::make('client_phone')
                                    ->label(__('app.pages.manage-settings.form.label.client_phone')),
                                TextInput::make('client_website')
                                    ->label(__('app.pages.manage-settings.form.label.client_website'))
                                    ->url()
                                    ->suffixIcon('heroicon-o-globe-alt'),
                                TextInput::make('client_email')
                                    ->label(__('app.pages.manage-settings.form.label.client_email'))
                                    ->email()
                                    ->suffixIcon('heroicon-o-at-symbol'),
                                TextInput::make('client_address')
                                    ->label(__('app.pages.manage-settings.form.label.client_street')),
                                TextInput::make('client_postal_code')
                                    ->label(__('app.pages.manage-settings.form.label.client_postal_code'))
                                    ->rules('postal_code:FR'),
                                TextInput::make('client_city')
                                    ->label(__('app.pages.manage-settings.form.label.client_city')),
                            ]),
                        Tab::make(__('app.pages.manage-settings.form.tabs.provider'))
                            ->icon('phosphor-building-office')
                            ->schema([
                                TextInput::make('generator_name')
                                    ->label(__('app.pages.manage-settings.form.label.generator_name')),
                                TextInput::make('generator_website')
                                    ->label(__('app.pages.manage-settings.form.label.generator_website'))
                                    ->url()
                                    ->suffixIcon('heroicon-o-globe-alt'),
                                FileUpload::make('generator_logo')
                                    ->label(__('app.pages.manage-settings.form.label.generator_logo'))
                                    ->directory('generator')
                                    ->image()
                                    ->optimize('webp')
                                    ->imageAspectRatio('16:9')
                                    ->automaticallyOpenImageEditorForAspectRatio()
                                    ->automaticallyCropImagesToAspectRatio()
                                    ->automaticallyResizeImagesMode('cover')
                                    ->automaticallyResizeImagesToWidth('200')
                                    ->automaticallyResizeImagesToHeight('113'),
                                FileUpload::make('generator_logo_dark')
                                    ->label(__('app.pages.manage-settings.form.label.generator_logo_dark'))
                                    ->directory('generator')
                                    ->image()
                                    ->optimize('webp')
                                    ->imageAspectRatio('16:9')
                                    ->automaticallyOpenImageEditorForAspectRatio()
                                    ->automaticallyCropImagesToAspectRatio()
                                    ->automaticallyResizeImagesMode('cover')
                                    ->automaticallyResizeImagesToWidth('200')
                                    ->automaticallyResizeImagesToHeight('113'),
                                TextInput::make('generator_name_email')
                                    ->label(__('app.pages.manage-settings.form.label.generator_name_email')),
                                TextInput::make('generator_email')
                                    ->label(__('app.pages.manage-settings.form.label.generator_email'))
                                    ->email()
                                    ->rules(['email:rfc,dns'])
                                    ->suffixIcon('heroicon-o-envelope'),
                                PhoneInput::make('generator_phone')
                                    ->label(__('app.pages.manage-settings.form.label.generator_phone')),
                                TextInput::make('generator_support_name')
                                    ->label(__('app.pages.manage-settings.form.label.generator_support_name')),
                                TextInput::make('generator_support_email')
                                    ->label(__('app.pages.manage-settings.form.label.generator_support_email'))
                                    ->email()
                                    ->rules(['email:rfc,dns'])
                                    ->suffixIcon('heroicon-o-envelope'),
                            ])
                            ->visible(auth()->user()->isSuperAdmin()),
                        Tab::make(__('app.pages.manage-settings.form.tabs.application'))
                            ->icon('phosphor-browser')
                            ->schema([
                                TextInput::make('app_title_page')
                                    ->label(__('app.pages.manage-settings.form.label.app_title_page')),
                                TextInput::make('app_title_prefix_page')
                                    ->label(__('app.pages.manage-settings.form.label.app_title_prefix_page')),
                                RichEditor::make('app_salutations_internal')
                                    ->label(__('app.pages.manage-settings.form.label.app_salutations_internal')),
                                FileUpload::make('app_email_logo_internal')
                                    ->label(__('app.pages.manage-settings.form.label.app_email_logo_internal'))
                                    ->directory('client')
                                    ->image()
                                    ->optimize('webp')
                                    ->imageAspectRatio('16:9')
                                    ->automaticallyOpenImageEditorForAspectRatio()
                                    ->automaticallyCropImagesToAspectRatio()
                                    ->automaticallyResizeImagesMode('cover')
                                    ->automaticallyResizeImagesToWidth('200')
                                    ->automaticallyResizeImagesToHeight('113'),
                                RichEditor::make('app_salutations_external')
                                    ->label(__('app.pages.manage-settings.form.label.app_salutations_external')),
                                FileUpload::make('app_email_logo_external')
                                    ->label(__('app.pages.manage-settings.form.label.app_email_logo_external'))
                                    ->directory('client')
                                    ->image()
                                    ->optimize('webp')
                                    ->imageAspectRatio('16:9')
                                    ->automaticallyOpenImageEditorForAspectRatio()
                                    ->automaticallyCropImagesToAspectRatio()
                                    ->automaticallyResizeImagesMode('cover')
                                    ->automaticallyResizeImagesToWidth('200')
                                    ->automaticallyResizeImagesToHeight('113'),
                                TextInput::make('app_dedicated')
                                    ->label(__('app.pages.manage-settings.form.label.app_dedicated')),
                                TextInput::make('app_email_from')
                                    ->label(__('app.pages.manage-settings.form.label.app_email_from'))
                                    ->email()
                                    ->rules(['email:rfc,dns']),
                                TextInput::make('app_email_name_from')
                                    ->label(__('app.pages.manage-settings.form.label.app_email_name_from')),
                            ])
                            ->visible(auth()->user()->isSuperAdmin()),
                        Tab::make(__('app.pages.manage-settings.form.tabs.membership'))
                            ->icon('phosphor-certificate')
                            ->schema([
                                AdvancedFileUpload::make('membership.document_for_email')
                                    ->label(__('app.pages.manage-settings.form.label.membership_document'))
                                    ->pdfToolbar(true)
                                    ->directory('document')
                                    ->disk('public')
                                    ->acceptedFileTypes(['application/pdf']),
                                /*FileUpload::make('membership.document_for_email')
                                    ->label(__('app.pages.manage-settings.form.label.membership_document'))
                                    ->directory('document')
                                    ->acceptedFileTypes(['application/pdf']),*/
                                TextInput::make('membership.subject_for_email')
                                    ->label(__('app.pages.manage-settings.form.label.membership_subject_for_email'))
                                    ->required()
                                    ->columnSpanFull(),
                                RichEditor::make('membership.content_for_email')
                                    ->label(__('app.pages.manage-settings.form.label.membership_content_for_email'))
                                    ->customHeight()
                                    ->columnSpanFull(),
                            ]),
                        Tab::make(__('app.pages.manage-settings.form.tabs.socials_networks'))
                            ->icon('phosphor-share-network')
                            ->schema([
                                Repeater::make('socials_networks')
                                    ->hiddenLabel()
                                    ->table([
                                        TableColumn::make(__('app.pages.manage-settings.form.label.repeater_socials_networks.name')),
                                        TableColumn::make(__('app.pages.manage-settings.form.label.repeater_socials_networks.account')),
                                    ])
                                    ->compact()
                                    ->schema([
                                        Select::make('name')
                                            ->label(__('app.pages.manage-settings.form.label.repeater_socials_networks.name'))
                                            ->options(SocialNetwork::options())
                                            ->native(false)
                                            ->allowHtml()
                                            ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                            ->required(),
                                        TextInput::make('account')
                                            ->label(__('app.pages.manage-settings.form.label.repeater_socials_networks.account'))
                                            ->url()
                                            ->prefixIcon('phosphor-globe-simple')
                                            ->placeholder(__('app.pages.manage-settings.form.label.repeater_socials_networks.account_helper'))
                                            ->required(),
                                    ])
                                    ->columnSpanFull()
                                    ->collapsible()
                                    ->addActionLabel(__('app.pages.manage-settings.form.label.repeater_socials_networks.add'))
                                    ->itemLabel(fn (array $state): ?string => $state['name'] ? SocialNetwork::from($state['name'])->getLabel() : null)
                                    ->defaultItems(0),
                            ]),
                        Tab::make(__('app.pages.manage-settings.form.tabs.emails_client'))
                            ->icon('heroicon-o-at-symbol')
                            ->schema([
                                Callout::make(__('app.pages.manage-settings.form.callout.notice_customers_emails.title'))
                                    ->description(new HtmlString('<p>'.__('app.pages.manage-settings.form.callout.notice_customers_emails.content').'</p>'))
                                    ->info()
                                    ->columnSpanFull(),
                                Repeater::make('emails_client')
                                    ->label(__('app.pages.manage-settings.form.label.emails_client'))
                                    ->schema([
                                        Grid::make()
                                            ->schema([
                                                TextInput::make('function')
                                                    ->label(__('app.pages.manage-settings.form.label.emails_client_function'))
                                                    ->live(onBlur: true)
                                                    ->afterStateUpdated(function (Set $set, $state) {
                                                        $set('key', Str::snake($state));
                                                    })
                                                    ->required(),
                                                TextInput::make('key')
                                                    ->label(__('app.pages.manage-settings.form.label.emails_client_key'))
                                                    ->readOnly()
                                                    ->required(),
                                                TextInput::make('name')
                                                    ->label(__('app.pages.manage-settings.form.label.emails_client_name'))
                                                    ->required(),
                                                TextInput::make('email')
                                                    ->label(__('app.pages.manage-settings.form.label.emails_client_email'))
                                                    ->email()
                                                    ->suffixIcon('heroicon-o-envelope')
                                                    ->rules(['email:rfc,dns'])
                                                    ->required(),
                                            ]),
                                    ])
                                    ->collapsible()
                                    ->addActionLabel(__('app.pages.manage-settings.action.label.add_new_email'))
                                    ->reorderable(false)
                                    ->itemLabel(fn (array $state): ?string => $state['function'] ?? null)
                                    ->columnSpanFull(),
                            ])
                            ->visible(auth()->user()->isSuperAdmin()),
                    ])
                    ->columns()
                    ->columnSpanFull(),
            ]);
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $new_data = [];
        $data['emails_client'] = data_get($data, 'emails_client');

        if (filled($data['emails_client'])) {
            foreach ($data['emails_client'] as $item) {
                $new_data[$item['key']] = $item;
            }
            $data['emails_client'] = $new_data;
        } else {
            $data['emails_client'] = [];
        }

        return $data;
    }
}
