<?php

namespace App\Filament\Pages;

use App\Enums\IntervalPeriod;
use App\Services\RichEditorService;
use App\Settings\LicenceSettings;
use Awcodes\Shout\Components\Shout;
use BackedEnum;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Carbon;

class ManageLicence extends SettingsPage
{
    use HasPageShield;

    protected static string $settings = LicenceSettings::class;

    protected static string|null|BackedEnum $navigationIcon = 'phosphor-tag';

    public static function getNavigationGroup(): ?string
    {
        return __('app.general.navigation.groups.administration');
    }

    public function getTitle(): string|Htmlable
    {
        return __('app.pages.manage-licence.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('app.pages.manage-licence.navigation_title');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('tabs-licence')
                    ->tabs([
                        Tab::make(__('app.pages.manage-licence.form.tabs.resume'))
                            ->icon('phosphor-note')
                            ->schema([
                                Shout::make('so-important')
                                    ->icon(false)
                                    ->content(view('filament.pages.manage-licence.reminder')),
                            ]),
                        Tab::make(__('app.pages.manage-licence.form.tabs.general'))
                            ->icon('phosphor-info')
                            ->schema([
                                TextInput::make('name')
                                    ->label(__('app.pages.manage-licence.form.label.name'))
                                    ->required(),
                                RichEditor::make('description')
                                    ->label(__('app.pages.manage-licence.form.label.description'))
                                    ->toolbarButtons(fn (RichEditorService $editorService) => $editorService->getToolbarButtonsEditorSimple())
                                    ->required(),
                                Fieldset::make(__('app.pages.manage-licence.form.label.duration_subscribe_licence'))
                                    ->schema([
                                        TextInput::make('invoice_period')
                                            ->hiddenLabel()
                                            ->numeric()
                                            ->required(),
                                        Select::make('invoice_interval')
                                            ->hiddenLabel()
                                            ->options(IntervalPeriod::class)
                                            ->required(),
                                    ]),
                                DatePicker::make('starts_at')
                                    ->label(__('app.pages.manage-licence.form.label.start_subscribe_licence'))
                                    ->prefixIcon('phosphor-calendar-blank')
                                    ->displayFormat(getDisplayDate())
                                    ->native(false)
                                    ->format('Y-m-d')
                                    ->dehydrateStateUsing(fn ($state) => Carbon::parse($state))
                                    ->required(),
                                DatePicker::make('ends_at')
                                    ->label(__('app.pages.manage-licence.form.label.end_subscribe_licence'))
                                    ->prefixIcon('phosphor-calendar-blank')
                                    ->displayFormat(getDisplayDate())
                                    ->native(false)
                                    ->format('Y-m-d')
                                    ->dehydrateStateUsing(fn ($state) => Carbon::parse($state))
                                    ->required(),
                                TextInput::make('price')
                                    ->label(__('app.pages.manage-licence.form.label.price'))
                                    ->numeric()
                                    ->suffixIcon('phosphor-currency-eur')
                                    ->required(),
                                TextInput::make('next_price')
                                    ->label(__('app.pages.manage-licence.form.label.next_price'))
                                    ->numeric()
                                    ->suffixIcon('phosphor-currency-eur')
                                    ->helperText(__('app.pages.manage-licence.form.placeholder.next_price')),
                            ])
                            ->columns(),
                        Tab::make(__('app.pages.manage-licence.form.tabs.notification'))
                            ->icon('phosphor-bell-ringing')
                            ->schema([
                                TextInput::make('invoice_contact_name')
                                    ->label(__('app.pages.manage-licence.form.label.contact_name_invoice'))
                                    ->required(),
                                TextInput::make('invoice_contact_email')
                                    ->label(__('app.pages.manage-licence.form.label.contact_email_invoice'))
                                    ->email()
                                    ->rules(['email:rfc,dns'])
                                    ->prefixIcon('phosphor-envelope')
                                    ->required(),
                                TagsInput::make('days_before')
                                    ->label(__('app.pages.manage-licence.form.label.days_before_licence'))
                                    ->helperText(__('app.pages.manage-licence.form.placeholder.helper_days_before_licence'))
                                    ->placeholder(__('app.pages.manage-licence.form.placeholder.days_before_licence'))
                                    ->tagSuffix(' jours')
                                    ->required()
                                    ->nestedRecursiveRules([
                                        'int',
                                    ]),
                            ])
                            ->columns(),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
