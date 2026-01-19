<?php

namespace App\Filament\Resources\Members\Schemas\Components;

use App\Enums\DiscountRate;
use App\Enums\IntervalPeriod;
use App\Enums\MemberType;
use App\Enums\OfficeRole;
use App\Enums\SocialNetwork;
use App\Models\Member;
use App\Models\User;
use App\Services\RichEditorService;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Text;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Support\Enums\IconSize;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;
use JaOcero\RadioDeck\Forms\Components\RadioDeck;
use Laravelcm\Subscriptions\Models\Plan;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;

class MemberFields
{
    public static function getAvatar(): SpatieMediaLibraryFileUpload
    {
        return SpatieMediaLibraryFileUpload::make('avatar')
            ->label(__('app.members.form.label.avatar'))
            ->collection('avatar')
            ->avatar()
            ->disk('public')
            ->visibility('public')
            ->imageAspectRatio('1:1')
            ->automaticallyOpenImageEditorForAspectRatio()
            ->automaticallyCropImagesToAspectRatio()
            ->automaticallyResizeImagesMode('cover')
            ->automaticallyResizeImagesToWidth('400')
            ->automaticallyResizeImagesToHeight('400')
            ->columnSpanFull();
    }

    public static function getFirstName(): TextInput
    {
        return TextInput::make('firstname')
            ->label(__('app.members.form.label.firstname'))
            ->required()
            ->columnSpanFull();
    }

    public static function getName(): TextInput
    {
        return TextInput::make('name')
            ->label(__('app.members.form.label.name'))
            ->required()
            ->columnSpanFull();
    }

    public static function getJob(): TextInput
    {
        return TextInput::make('job')
            ->label(__('app.members.form.label.job'))
            ->columnSpanFull();
    }

    public static function getPhone(): PhoneInput
    {
        return PhoneInput::make('phone')
            ->label(__('app.members.form.label.phone'))
            ->placeholderNumberType('FIXED_LINE')
            ->required()
            ->columnSpanFull();
    }

    public static function getEmail(): TextInput
    {
        return TextInput::make('email')
            ->label(__('app.members.form.label.email'))
            ->required()
            ->columnSpanFull();
    }

    public static function getMemberType(): Radio
    {
        return Radio::make('member_type')
            ->label(__('app.members.form.label.member_type'))
            ->default(MemberType::MEMBER)
            ->options(MemberType::class)
            ->required()
            ->live();
    }

    public static function getOfficeRole(): Select
    {
        return Select::make('office_role')
            ->label(__('app.members.form.label.office_role'))
            ->native(false)
            ->selectablePlaceholder(false)
            ->options(OfficeRole::class)
            ->visible(function (Get $get): bool {
                if ($get('member_type') != null) {
                    return is_a($get('member_type'), MemberType::class) ? $get('member_type') == MemberType::OFFICE : MemberType::from($get('member_type')) == MemberType::OFFICE;
                }

                return false;
            })
            ->required();
    }

    public static function getApplyDiscount(): Fieldset
    {
        return Fieldset::make(__('app.actions.send_document.label.fieldset_discount'))
            ->schema([
                Text::make(__('app.members.form.placeholder.info_discount'))
                    ->color('neutral')
                    ->columnSpanFull(),
                Radio::make('has_discount')
                    ->label(__('app.actions.send_document.label.has_discount'))
                    ->hiddenLabel()
                    ->boolean()
                    ->inline()
                    ->default(false)
                    ->live(),
                Select::make('discount_rate')
                    ->label(__('app.actions.send_document.label.discount_rate'))
                    ->native(false)
                    ->selectablePlaceholder(false)
                    ->options(DiscountRate::class)
                    ->requiredIfAccepted('has_discount')
                    ->validationMessages([
                        'required_if_accepted' => __('app.actions.send_document.validation.discount_rate'),
                    ])
                    ->live()
                    ->visible(fn (Get $get): bool => $get('has_discount')),
            ]);

    }

    public static function getPlans(bool $hasDiscount = false, ?DiscountRate $discountRate = null, bool $useLiveData = false, bool $removeCurrentPlan = false): RadioDeck
    {
        $plans = once(fn () => Plan::query()->where('is_active', 1)->get());

        return RadioDeck::make('plan_id')
            ->live()
            ->label(__('app.members.form.label.plan_type'))
            ->options(function (Get $get, ?Model $record) use ($hasDiscount, $discountRate, $useLiveData, $plans, $removeCurrentPlan) {
                if (! $useLiveData) {
                    $hasDiscount = $get('has_discount');
                    // $discountRate = $get('discount_rate') ? DiscountRate::from($get('discount_rate')) : null;
                    if (filled($get('discount_rate'))) {
                        if ($get('discount_rate') instanceof DiscountRate) {
                            $discountRate = $get('discount_rate');
                        } else {
                            $discountRate = DiscountRate::from($get('discount_rate'));
                        }
                    } else {
                        $discountRate = null;
                    }
                }

                if ($removeCurrentPlan) {
                    $plans = $plans->reject(function (Plan $plan) use ($record) {
                        return $plan->id == $record->onePlanSubscriptions->plan_id;
                    });
                }

                return $plans->mapWithKeys(function (Plan $plan) use ($hasDiscount, $discountRate) {

                    if ($hasDiscount && filled($discountRate)) {
                        $newPrice = $plan['price'] * (1 - $discountRate->value / 100);

                        return [$plan['id'] => new HtmlString(__('app.members.form.label.plan_type_label_discounted', ['name' => $plan['name'], 'period' => $plan['invoice_period'], 'interval' => IntervalPeriod::from($plan['invoice_interval'])->getLabel(), 'price' => $plan['price'], 'currency' => $plan['currency'], 'discount_rate' => $discountRate->getLabel(), 'new_price' => $newPrice]))];
                    }

                    return [$plan['id'] => __('app.members.form.label.plan_type_label', ['name' => $plan['name'], 'period' => $plan['invoice_period'], 'interval' => IntervalPeriod::from($plan['invoice_interval'])->getLabel(), 'price' => $plan['price'], 'currency' => $plan['currency']])];
                });
            })
            ->descriptions($plans->mapWithKeys(function (Plan $plan): array {
                return [$plan['id'] => new HtmlString('<div class="text-gray-500 dark:text-gray-400">'.$plan['description'].'</div>')];
            }))
            ->icons(fn (RadioDeck $component): array => array_map(fn (): string => 'phosphor-tag', $component->getOptions()))
            ->required()
            ->iconSize(IconSize::Large)
            ->color('primary')
            ->columns()
            ->columnSpanFull();
    }

    /*public static function getPlans(bool $hasDiscount = false, ?DiscountRate $discountRate = null): RadioDeck
    {
        $plans = Plan::query()->where('is_active', 1)->get();

        return RadioDeck::make('plan_id')
            ->live()
            ->label(__('app.members.form.label.plan_type'))
            ->options($plans->mapWithKeys(function (Plan $plan) use ($hasDiscount, $discountRate) {
                if ($hasDiscount) {
                    $newPrice = $plan['price'] * (1 - $discountRate->value / 100);

                    return [$plan['id'] => new HtmlString(__('app.members.form.label.plan_type_label_discounted', ['name' => $plan['name'], 'period' => $plan['invoice_period'], 'interval' => IntervalPeriod::from($plan['invoice_interval'])->getLabel(), 'price' => $plan['price'], 'currency' => $plan['currency'], 'discount_rate' => $discountRate->getLabel(), 'new_price' => $newPrice]))];
                }

                return [$plan['id'] => __('app.members.form.label.plan_type_label', ['name' => $plan['name'], 'period' => $plan['invoice_period'], 'interval' => IntervalPeriod::from($plan['invoice_interval'])->getLabel(), 'price' => $plan['price'], 'currency' => $plan['currency']])];
            }))
            ->descriptions($plans->mapWithKeys(function (Plan $plan) {
                return [$plan['id'] => new HtmlString('<div class="text-gray-500 dark:text-gray-400">'.$plan['description'].'</div>')];
            }))
            // ->descriptions($plans->pluck('description', 'id')->map(fn ($description) => new HtmlString($description))->toArray())
            ->icons(fn (RadioDeck $component) => array_map(fn (): string => 'phosphor-tag', $component->getOptions()))
            ->required()
            ->iconSize(IconSize::Large)
            ->color('primary')
            ->columns()
            ->columnSpanFull();
    }*/

    public static function getPlan(): Text
    {
        return Text::make(function (Model $record, Get $get): HtmlString {
            if ($record->onePlanSubscriptions?->discount_rate) {

                $newPrice = $record->onePlanSubscriptions?->plan->price * (1 - $record->onePlanSubscriptions?->discount_rate->value / 100);

                return new HtmlString(__('app.members.form.label.plan_type_label_discounted', ['name' => $record->onePlanSubscriptions?->name, 'period' => $record->onePlanSubscriptions?->plan->invoice_period, 'interval' => IntervalPeriod::from($record->onePlanSubscriptions?->plan->invoice_interval)->getLabel(), 'price' => $record->onePlanSubscriptions?->plan->price, 'currency' => $record->onePlanSubscriptions?->plan->currency, 'discount_rate' => $record->onePlanSubscriptions?->discount_rate->getLabel(), 'new_price' => $newPrice]));
            }

            if ($get('has_discount') && $get('discount_rate')) {
                $newPrice = $record->onePlanSubscriptions?->plan->price * (1 - $get('discount_rate') / 100);

                return new HtmlString(__('app.members.form.label.plan_type_label_discounted', ['name' => $record->onePlanSubscriptions?->name, 'period' => $record->onePlanSubscriptions?->plan->invoice_period, 'interval' => IntervalPeriod::from($record->onePlanSubscriptions?->plan->invoice_interval)->getLabel(), 'price' => $record->onePlanSubscriptions?->plan->price, 'currency' => $record->onePlanSubscriptions?->plan->currency, 'discount_rate' => DiscountRate::from($get('discount_rate'))->getLabel(), 'new_price' => $newPrice]));

            }

            return new HtmlString(__('app.members.form.label.plan_type_label', ['name' => $record->onePlanSubscriptions?->name, 'period' => $record->onePlanSubscriptions?->plan->invoice_period, 'interval' => IntervalPeriod::from($record->onePlanSubscriptions?->plan->invoice_interval)->getLabel(), 'price' => $record->onePlanSubscriptions?->plan->price, 'currency' => $record->onePlanSubscriptions?->plan->currency]));

        })
            ->color('neutral')
            ->columnSpanFull();
    }

    public static function getIsPublished(): Toggle
    {
        return Toggle::make('is_published')
            ->label(__('app.members.form.label.is_published'))
            ->onColor('success')
            ->columnSpanFull();
    }

    public static function getSendMemberNotification(): Toggle
    {
        return Toggle::make('send_notification')
            ->label(__('app.members.form.label.send_notification'))
            ->onColor('success')
            ->columnSpanFull();
    }

    public static function getUser(): Select
    {
        return Select::make('user_id')
            ->label(__('app.members.form.label.user'))
            ->native(false)
            ->relationship(name: 'user', titleAttribute: 'name')
            ->getOptionLabelFromRecordUsing(fn (Model $record): string => $record->getFilamentName())
            ->searchable()
            ->preload()
            ->live()
            ->disabled(fn (string $operation): bool => $operation == 'edit')
            ->afterStateUpdated(function (Set $set, ?string $state) {
                $user = User::find($state);
                if ($user) {
                    $set('firstname', $user->firstname);
                    $set('name', $user->name);
                    $set('phone', $user->phone);
                    $set('email', $user->email);
                }
            })
            ->disableOptionWhen(function (string $value, ?string $state, ?Model $record): bool {
                $usersTaken = Member::pluck('user_id')->toArray();

                return collect($usersTaken)
                    ->reject(fn ($id) => $id == $state || $id == $record?->user_id)
                    ->filter()
                    ->contains($value);
            })
            ->columnSpanFull();
    }

    public static function getCompanyLogo(): SpatieMediaLibraryFileUpload
    {
        return SpatieMediaLibraryFileUpload::make('company_logo')
            ->label(__('app.members.form.label.company_logo'))
            ->collection('company_logo')
            ->disk('public')
            ->visibility('public')
            ->image()
            ->imageAspectRatio('16:9')
            ->automaticallyOpenImageEditorForAspectRatio()
            ->automaticallyCropImagesToAspectRatio()
            ->automaticallyResizeImagesMode('cover')
            ->automaticallyResizeImagesToWidth('800')
            ->automaticallyResizeImagesToHeight('450')
            ->columnSpanFull();
    }

    public static function getCompanyName(): TextInput
    {
        return TextInput::make('company_name')
            ->label(__('app.members.form.label.company_name'))
            ->required()
            ->columnSpanFull();
    }

    public static function getCompanyActivity(): TextInput
    {
        return TextInput::make('company_activity')
            ->label(__('app.members.form.label.company_activity'))
            ->required()
            ->columnSpanFull();
    }

    public static function getCompanyDescription(): RichEditor
    {
        return RichEditor::make('company_description')
            ->label(__('app.members.form.label.company_description'))
            ->customHeight()
            ->textColors(fn (RichEditorService $editorService): array => $editorService->getColors())
            ->toolbarButtons(fn (RichEditorService $editorService): array => $editorService->getToolbarButtonsEditorWithColorAndImage())
            ->fileAttachmentsDirectory('members')
            ->resizableImages()
            ->required()
            ->columnSpanFull();
    }

    public static function getCompanyStreet(): TextInput
    {
        return TextInput::make('company_street')
            ->label(__('app.members.form.label.company_street'))
            ->required()
            ->columnSpanFull();
    }

    public static function getCompanyExtStreet(): TextInput
    {
        return TextInput::make('company_ext_street')
            ->label(__('app.members.form.label.company_ext_street'))
            ->columnSpanFull();
    }

    public static function getCompanyPostalCode(): TextInput
    {
        return TextInput::make('company_postal_code')
            ->label(__('app.members.form.label.company_postal_code'))
            ->rules('postal_code:FR')
            ->required()
            ->columnSpan(1);
    }

    public static function getCompanyCity(): TextInput
    {
        return TextInput::make('company_city')
            ->label(__('app.members.form.label.company_city'))
            ->required()
            ->columnSpan(1);
    }

    public static function getCompanyWebsite(): TextInput
    {
        return TextInput::make('company_website')
            ->label(__('app.members.form.label.company_website'))
            ->columnSpanFull();
    }

    public static function getCompanyAddress(): Fieldset
    {
        return Fieldset::make(__('app.members.form.label.address'))
            ->schema([
                self::getCompanyStreet(),
                self::getCompanyExtStreet(),
                self::getCompanyPostalCode(),
                self::getCompanyCity(),
            ])
            ->columnSpanFull();
    }

    public static function getSocials(): Repeater
    {
        return Repeater::make('company_socials')
            ->hiddenLabel()
            ->table([
                TableColumn::make(__('app.members.form.label.repeater.name')),
                TableColumn::make(__('app.members.form.label.repeater.account')),
            ])
            ->compact()
            ->schema([
                Select::make('name')
                    ->label(__('app.members.form.label.repeater.name'))
                    ->options(SocialNetwork::options())
                    ->native(false)
                    ->allowHtml()
                    ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                    ->required()
                    ->columnSpan(1),
                TextInput::make('account')
                    ->label(__('app.members.form.label.repeater.account'))
                    ->url()
                    ->prefixIcon('phosphor-globe-simple')
                    ->placeholder(__('app.members.form.label.repeater.account_helper'))
                    ->required()
                    ->columnSpan(2),
            ])
            ->columns(3)
            ->collapsible()
            ->addActionLabel(__('app.members.form.label.repeater.add'))
            ->itemLabel(fn (array $state): ?string => $state['name'] ? SocialNetwork::from($state['name'])->getLabel() : null)
            ->defaultItems(0);
    }
}
