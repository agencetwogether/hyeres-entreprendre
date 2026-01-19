<?php

namespace App\Filament\Resources\Members\Schemas\Components;

use App\Enums\SocialNetwork;
use App\Filament\Resources\Members\Actions\DownloadInvoice;
use App\Filament\Resources\Members\Actions\SendInvoice;
use App\Services\RichEditorService;
use Filament\Forms\Components\RichEditor\RichContentRenderer;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;
use Ysfkaya\FilamentPhoneInput\Infolists\PhoneEntry;
use Ysfkaya\FilamentPhoneInput\PhoneInputNumberType;

class MemberEntries
{
    public static function getSectionCompany(): Section
    {
        return Section::make(__('app.members.infolist.section.company.title'))
            ->description(__('app.members.infolist.section.company.description'))
            ->icon('phosphor-building-office')
            ->iconColor('primary')
            ->schema([
                Grid::make(4)
                    ->schema([
                        self::getCompanyLogo()
                            ->columnSpan(1),
                        Group::make()
                            ->schema([
                                self::getCompanyName(),
                                self::getCompanyActivity(),
                                self::getCompanyWebsite(),
                                self::getCompanyDescription()
                                    ->columnSpanFull(),
                                self::getCompanyAddress(),
                            ])
                            ->columns()
                            ->columnSpan(3),
                    ]),

                // self::getIsPublished(),
                // self::getAccountCreated(),
            ])
            ->collapsible()
            ->persistCollapsed()
            ->columnSpanFull();
    }

    public static function getSectionMember(): Section
    {
        return Section::make(__('app.members.infolist.section.member.title'))
            ->description(__('app.members.infolist.section.member.description'))
            ->icon('phosphor-identification-badge')
            ->iconColor('primary')
            ->schema([
                Grid::make(4)
                    ->schema([
                        self::getAvatar()
                            ->columnSpan(1),
                        Group::make()
                            ->schema([
                                self::getName(),
                                self::getFirstName(),
                                self::getJob()
                                    ->columnSpanFull(),
                                self::getPhone(),
                                self::getEmail(),
                            ])
                            ->columns()
                            ->columnSpan(3),
                    ]),
            ])
            ->collapsible()
            ->persistCollapsed()
            ->columnSpanFull();
    }

    public static function getSectionSocials(): Section
    {
        return Section::make(__('app.members.infolist.section.socials.title'))
            ->description(__('app.members.infolist.section.socials.description'))
            ->icon('phosphor-share-network')
            ->iconColor('primary')
            ->schema([
                self::getSocials(),
            ])
            ->columnSpanFull();
    }

    public static function getName(): TextEntry
    {
        return TextEntry::make('name')
            ->label(__('app.members.infolist.label.name'));
    }

    public static function getFirstName(): TextEntry
    {
        return TextEntry::make('firstname')
            ->label(__('app.members.infolist.label.firstname'));
    }

    public static function getJob(): TextEntry
    {
        return TextEntry::make('job')
            ->label(__('app.members.infolist.label.job'))
            ->badge()
            ->color('success')
            ->placeholder(__('app.members.infolist.placeholder.job'));
    }

    public static function getPhone(): PhoneEntry
    {
        return PhoneEntry::make('phone')
            ->label(__('app.members.infolist.label.phone'))
            ->displayFormat(PhoneInputNumberType::NATIONAL);
    }

    public static function getEmail(): TextEntry
    {
        return TextEntry::make('email')
            ->label(__('app.members.infolist.label.email'))
            ->icon('phosphor-envelope-simple')
            ->copyable()
            ->copyMessage(__('app.general.copy_email'));
    }

    public static function getCompanyName(): TextEntry
    {
        return TextEntry::make('company_name')
            ->label(__('app.members.infolist.label.company_name'));
    }

    public static function getCompanyActivity(): TextEntry
    {
        return TextEntry::make('company_activity')
            ->label(__('app.members.infolist.label.company_activity'))
            ->badge()
            ->color('success');
    }

    public static function getCompanyDescription(): TextEntry
    {
        return TextEntry::make('company_description')
            ->label(__('app.members.infolist.label.company_description'))
            ->formatStateUsing(fn ($state) => RichContentRenderer::make($state)->textColors(app(RichEditorService::class)->getColors())
                ->fileAttachmentsDisk('public'))
            ->extraAttributes(['class' => 'fi-prose']);
    }

    public static function getCompanyAddress(): Fieldset
    {
        return Fieldset::make(__('app.members.infolist.label.address'))
            ->schema([
                self::getCompanyStreet(),
                self::getCompanyExtStreet(),
                self::getCompanyPostalCode(),
                self::getCompanyCity(),
            ]);
    }

    public static function getCompanyStreet(): TextEntry
    {
        return TextEntry::make('company_street')
            ->label(__('app.members.infolist.label.company_street'))
            ->columnSpanFull();
    }

    public static function getCompanyExtStreet(): TextEntry
    {
        return TextEntry::make('company_ext_street')
            ->label(__('app.members.infolist.label.company_ext_street'))
            ->visible(fn (Model $record): bool => filled($record->company_ext_street))
            ->columnSpanFull();
    }

    public static function getCompanyPostalCode(): TextEntry
    {
        return TextEntry::make('company_postal_code')
            ->label(__('app.members.infolist.label.company_postal_code'));
    }

    public static function getCompanyCity(): TextEntry
    {
        return TextEntry::make('company_city')
            ->label(__('app.members.infolist.label.company_city'));
    }

    public static function getCompanyWebsite(): TextEntry
    {
        return TextEntry::make('company_website')
            ->label(__('app.members.infolist.label.company_website'))
            ->icon('phosphor-globe-simple')
            ->url(fn (Model $record): string => filled($record->company_website) ? url($record->company_website) : '')
            ->openUrlInNewTab()
            ->placeholder(__('app.members.infolist.placeholder.company_website'))
            ->columnSpanFull();
    }

    public static function getIsPublished(): TextEntry
    {
        return TextEntry::make('is_published')
            ->label(__('app.members.infolist.label.is_published'))
            ->formatStateUsing(fn (string $state): string => $state ? __('Yes') : __('No'))
            ->icon(fn (string $state): string => $state ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle')
            ->iconColor(fn (string $state): string => $state ? 'success' : 'danger');
    }

    public static function getAccountCreated(): TextEntry
    {
        return TextEntry::make('account_created')
            ->label(__('app.members.infolist.label.account_created'))
            ->formatStateUsing(fn (string $state): string => $state ? __('Yes') : __('No'))
            ->icon(fn (string $state): string => $state ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle')
            ->iconColor(fn (string $state): string => $state ? 'success' : 'danger');
    }

    public static function getSocials(): RepeatableEntry
    {
        return RepeatableEntry::make('company_socials')
            ->hiddenLabel()
            ->placeholder(__('app.members.infolist.placeholder.socials'))
            ->schema([
                TextEntry::make('name')
                    ->hiddenLabel()
                    ->formatStateUsing(fn (string $state): string => SocialNetwork::from($state)->getLabel())
                    ->icon(fn ($state): string => SocialNetwork::from($state)->getIcon())
                    ->iconColor(fn ($state): string => SocialNetwork::from($state)->getColor())
                    ->url(function (Component $component): string {
                        $index = explode('.', $component->getStatePath())[1];
                        $data = $component
                            ->getContainer()
                            ->getParentComponent()
                            ->getState()[$index];

                        return $data['account'];
                    })
                    ->openUrlInNewTab(),
            ])
            ->grid()
            ->contained(false);
    }

    public static function getAvatar(): SpatieMediaLibraryImageEntry
    {
        return SpatieMediaLibraryImageEntry::make('avatar')
            ->hiddenLabel()
            ->collection('avatar')
            ->conversion('webp')
            ->imageSize('50%')
            ->circular()
            ->alignCenter();
    }

    public static function getCompanyLogo(): SpatieMediaLibraryImageEntry
    {
        return SpatieMediaLibraryImageEntry::make('company_logo')
            ->hiddenLabel()
            ->collection('company_logo')
            ->conversion('webp')
            ->alignCenter();
    }

    public static function getSectionCurrentSubscription(bool $owner = false): Section
    {
        $section = Section::make($owner ? __('app.members.infolist.section.current_subscription.title_owner') : __('app.members.infolist.section.current_subscription.title'))
            ->description($owner ? __('app.members.infolist.section.current_subscription.description_owner') : __('app.members.infolist.section.current_subscription.description'))
            ->icon('phosphor-tag')
            ->iconColor('success')
            ->schema([
                self::getName(),
                self::getPlanPrice(),
                self::getPeriod(),
            ])
            ->collapsible()
            ->persistCollapsed()
            ->columnSpanFull();

        if ($owner) {
            $section
                ->headerActions([
                    DownloadInvoice::make(),
                ]);
        } else {
            $section
                ->headerActions([
                    DownloadInvoice::make(),
                    SendInvoice::make(),
                ]);
        }

        return $section;
    }

    public static function getSectionPastSubscriptions(): Section
    {
        return Section::make(__('app.members.infolist.section.past_subscriptions.title'))
            ->description(__('app.members.infolist.section.past_subscriptions.description'))
            ->icon('phosphor-clock-counter-clockwise')
            ->iconColor('warning')
            ->schema([
                ViewEntry::make('past_subscriptions')
                    ->view('partials.past-subscriptions'),
            ])
            ->collapsed()
            ->persistCollapsed()
            ->columnSpanFull();
    }

    public static function getSubscriptionName(): TextEntry
    {
        return TextEntry::make('onePlanSubscriptions.name')
            ->label(__('app.members.infolist.label.plan_type'));
    }

    public static function getPlanPrice(): TextEntry
    {
        return TextEntry::make('onePlanSubscriptions.plan.price')
            ->label(__('app.members.infolist.label.plan_price'))
            ->formatStateUsing(function (Model $record, string $state): HtmlString {
                if ($record->onePlanSubscriptions->discount_rate) {
                    return new HtmlString('<span class="line-through">'.$state.' '.$record->onePlanSubscriptions->plan->currency.'</span> Réduction de <span class="text-success-600">'.$record->onePlanSubscriptions->discount_rate->getLabel().'</span><br>'.$state * (1 - $record->onePlanSubscriptions->discount_rate->value / 100).' '.$record->onePlanSubscriptions->plan->currency);
                }

                return new HtmlString($state.' '.$record->onePlanSubscriptions->plan->currency);
            })
            ->suffix(function (Model $record): string {
                if (filled($record->onePlanSubscriptions->payment_received_at)) {
                    return new HtmlString(__('app.members.infolist.label.plan_price_suffix', ['date' => $record->onePlanSubscriptions->payment_received_at->format('d/m/Y - H:i')]));
                } else {
                    return __('app.members.infolist.label.plan_price_suffix_wait');
                }
            });
    }

    public static function getPeriod(): TextEntry
    {
        return TextEntry::make('period')
            ->label(__('app.members.infolist.label.plan_period'))
            ->state(function (Model $record): string {
                return $record->onePlanSubscriptions->starts_at->format('d/m/Y').' - '.$record->onePlanSubscriptions->ends_at->format('d/m/Y');
            });
    }
}
