<?php

namespace App\Providers\Filament;

use App\Concerns\UseColorsTrait;
use App\Filament\Pages\Auth\EditProfile;
use App\Filament\Pages\Auth\Login;
use App\Filament\Pages\Backups;
use App\Filament\Resources\Members\Pages\ListMembers;
use App\Filament\Resources\MenuItems\MenuItemResource;
use App\Filament\Resources\Menus\MenuResource;
use App\Filament\Widgets\CustomFilamentInfoWidget;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Biostate\FilamentMenuBuilder\FilamentMenuBuilderPlugin;
use DiogoGPinto\AuthUIEnhancer\AuthUIEnhancerPlugin;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Enums\ThemeMode;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Section;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Width;
use Filament\Support\Facades\FilamentView;
use Filament\Tables\Table;
use Filament\View\PanelsRenderHook;
use Filament\Widgets;
use Hugomyb\FilamentErrorMailer\FilamentErrorMailerPlugin;
use Illuminate\Contracts\View\View;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use RickDBCN\FilamentEmail\FilamentEmail;
use ShuvroRoy\FilamentSpatieLaravelBackup\FilamentSpatieLaravelBackupPlugin;
use Yebor974\Filament\RenewPassword\RenewPasswordPlugin;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;

class AdminPanelProvider extends PanelProvider
{
    use UseColorsTrait;

    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login(Login::class)
            ->passwordReset()
            ->profile(EditProfile::class, isSimple: false)
            ->colors($this->useColors())
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                CustomFilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->defaultThemeMode(ThemeMode::Light)
            ->font('Be Vietnam Pro')
            ->loginRouteSlug('connexion')
            ->passwordResetRoutePrefix('reinitialisation-mot-de-passe')
            ->passwordResetRequestRouteSlug('demande')
            ->passwordResetRouteSlug('reinitialisation')
            ->maxContentWidth(Width::Full)
            ->sidebarCollapsibleOnDesktop()
            ->globalSearchKeyBindings(['command+k', 'ctrl+k'])
            ->globalSearchFieldKeyBindingSuffix()
            ->navigationGroups([
                NavigationGroup::make()
                    ->label(__('app.general.navigation.groups.site')),
                NavigationGroup::make()
                    ->label(__('app.general.navigation.groups.pages'))
                    ->collapsed(),
                NavigationGroup::make()
                    ->label(__('app.general.navigation.groups.settings'))
                    ->collapsed(),
                NavigationGroup::make()
                    ->label(__('app.general.navigation.groups.support')),
                NavigationGroup::make()
                    ->label(__('app.general.navigation.groups.administration'))
                    ->collapsed(),
            ])
            ->userMenuItems(['profile' => fn (Action $action): Action => $action->label(__('app.general.user_menu.label_profile'))->icon('heroicon-o-user')])
            ->brandLogo(fn () => view('filament.general.logo'))
            ->favicon(asset('img/favicon.png'))
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->plugins([
                FilamentErrorMailerPlugin::make(),
                FilamentEmail::make(),
                FilamentSpatieLaravelBackupPlugin::make()
                    ->usingPage(Backups::class),
                AuthUIEnhancerPlugin::make()
                    ->showEmptyPanelOnMobile(false)
                    ->formPanelWidth('40%')
                    ->emptyPanelBackgroundColor(Color::Yellow, '600')
                    ->emptyPanelBackgroundImageUrl(asset('storage/default/intro.webp'))
                    ->emptyPanelBackgroundImageOpacity('70%'),
                RenewPasswordPlugin::make()
                    ->forceRenewPassword()
                    ->timestampColumn(),
                FilamentShieldPlugin::make()
                    ->navigationGroup(__('app.general.navigation.groups.administration'))
                    ->globallySearchable(false),
                FilamentMenuBuilderPlugin::make()
                    ->usingMenuResource(MenuResource::class)
                    ->usingMenuItemResource(MenuItemResource::class),
            ]);
    }

    public function boot(): void
    {
        FileUpload::configureUsing(function (FileUpload $fileUpload): void {
            $fileUpload
                // ->visibility('public')
                ->disk('public');
        });

        RichEditor::macro('maxHeight', function (int|string|null $value = '400px'): static {
            $this->extraAttributes([
                'style' => "max-height: {$value};",
                'class' => 'has-max-height',
            ]);

            return $this;
        });

        RichEditor::macro('customHeight', function (int|string|null $minHeight = '200px', int|string|null $maxHeight = '400px'): static {
            $this->extraAttributes([
                'style' => "min-height: {$minHeight}; max-height: {$maxHeight};",
                'class' => 'has-max-height',
            ]);

            return $this;
        });

        Table::configureUsing(fn (Table $table) => $table
            ->deferFilters(false)
            ->striped()
        );

        Section::configureUsing(fn (Section $section) => $section
            ->columnSpanFull()
        );

        Fieldset::configureUsing(fn (Fieldset $fieldset) => $fieldset
            ->columnSpanFull()
        );

        DeleteAction::configureUsing(function (DeleteAction $action): void {
            $action
                ->closeModalByClickingAway(false);
        });

        EditAction::configureUsing(function (EditAction $action): void {
            $action
                ->color('warning');
        });

        ViewAction::configureUsing(function (ViewAction $action): void {
            $action
                ->color('primary');
        });

        ActionGroup::configureUsing(function (ActionGroup $group): void {
            $group
                ->link();
        });

        PhoneInput::configureUsing(function (PhoneInput $phone): void {
            $phone
                ->initialCountry('fr')
                ->placeholderNumberType('MOBILE')
                ->onlyCountries(['fr', 'ad', 'at', 'be', 'de', 'dk', 'dz', 'es', 'fi', 'gb', 'gp', 'gr', 'ie', 'is', 'it', 'li', 'lt', 'lu', 'ma', 'mc', 'mq', 'nl', 'no', 'pl', 'pt', 're', 'ro', 'se', 'tn', 'ua', 'us'])
                ->i18n([
                    'fr' => __('app.form.phone_input.countries.fr'),
                    'ad' => __('app.form.phone_input.countries.ad'),
                    'at' => __('app.form.phone_input.countries.at'),
                    'be' => __('app.form.phone_input.countries.be'),
                    'de' => __('app.form.phone_input.countries.de'),
                    'dk' => __('app.form.phone_input.countries.dk'),
                    'dz' => __('app.form.phone_input.countries.dz'),
                    'es' => __('app.form.phone_input.countries.es'),
                    'fi' => __('app.form.phone_input.countries.fi'),
                    'gb' => __('app.form.phone_input.countries.gb'),
                    'gp' => __('app.form.phone_input.countries.gp'),
                    'gr' => __('app.form.phone_input.countries.gr'),
                    'ie' => __('app.form.phone_input.countries.ie'),
                    'is' => __('app.form.phone_input.countries.is'),
                    'it' => __('app.form.phone_input.countries.it'),
                    'li' => __('app.form.phone_input.countries.li'),
                    'lt' => __('app.form.phone_input.countries.lt'),
                    'lu' => __('app.form.phone_input.countries.lu'),
                    'ma' => __('app.form.phone_input.countries.ma'),
                    'mc' => __('app.form.phone_input.countries.mc'),
                    'mq' => __('app.form.phone_input.countries.mq'),
                    'nl' => __('app.form.phone_input.countries.nl'),
                    'no' => __('app.form.phone_input.countries.no'),
                    'pl' => __('app.form.phone_input.countries.pl'),
                    'pt' => __('app.form.phone_input.countries.pt'),
                    're' => __('app.form.phone_input.countries.re'),
                    'ro' => __('app.form.phone_input.countries.ro'),
                    'se' => __('app.form.phone_input.countries.se'),
                    'tn' => __('app.form.phone_input.countries.tn'),
                    'ua' => __('app.form.phone_input.countries.ua'),
                    'us' => __('app.form.phone_input.countries.us'),
                    'selectedCountryAriaLabel' => __('app.form.phone_input.countries.country_selected'),
                    'countryListAriaLabel' => __('app.form.phone_input.countries.countries_list'),
                    'searchPlaceholder' => __('app.form.phone_input.countries.search_placeholder'),
                ])
                ->countryOrder(['fr'])
                ->validateFor();
        });

        Textarea::configureUsing(function (Textarea $textarea): void {
            $textarea
                ->rows(3)
                ->cols(20);
        });

        RichEditor::configureUsing(function (RichEditor $richEditor): void {
            $richEditor
                ->toolbarButtons([
                    ['bold', 'italic', 'underline', 'strike'],
                    ['undo', 'redo', 'clearFormatting'],
                ]);
        });

        Repeater::configureUsing(function (Repeater $repeater): void {
            $repeater
                ->reorderAction(fn (Action $action) => $action->tooltip(__('filament-forms::components.repeater.actions.reorder.label')))
                ->deleteAction(fn (Action $action) => $action->tooltip(__('filament-forms::components.repeater.actions.delete.label')));
        });

        FilamentView::registerRenderHook(
            'panels::auth.login.form.before',
            fn (): View => view('filament.general.hook-before-login')
        );

        FilamentView::registerRenderHook(
            PanelsRenderHook::AUTH_LOGIN_FORM_AFTER,
            fn (): View => view('filament.general.after-auth-form'),
        );

        FilamentView::registerRenderHook(
            PanelsRenderHook::AUTH_PASSWORD_RESET_REQUEST_FORM_AFTER,
            fn (): View => view('filament.general.after-auth-form'),
        );

        FilamentView::registerRenderHook(
            PanelsRenderHook::AUTH_PASSWORD_RESET_RESET_FORM_AFTER,
            fn (): View => view('filament.general.after-auth-form'),
        );

        FilamentView::registerRenderHook(
            PanelsRenderHook::AUTH_REGISTER_FORM_AFTER,
            fn (): View => view('filament.general.after-auth-form'),
        );

        FilamentView::registerRenderHook(
            PanelsRenderHook::FOOTER,
            fn (): View => view('filament.general.custom-footer')
        );

        FilamentView::registerRenderHook(
            PanelsRenderHook::GLOBAL_SEARCH_BEFORE,
            fn (): View => view('filament.general.support-btn'),
        );

        FilamentView::registerRenderHook(
            PanelsRenderHook::USER_MENU_BEFORE,
            fn (): View => view('filament.general.hook-before-user-menu', ['url' => EditProfile::getUrl()])
        );

        FilamentView::registerRenderHook(
            PanelsRenderHook::GLOBAL_SEARCH_BEFORE,
            fn (): View => view('filament.general.go-to-front'),
        );

        FilamentView::registerRenderHook(
            PanelsRenderHook::RESOURCE_PAGES_LIST_RECORDS_TABLE_AFTER,
            fn (): View => view('filament.resources.members.legend-table'), scopes: [
                ListMembers::class,
            ]
        );
    }
}
