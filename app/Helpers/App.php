<?php

use App\Enums\IntervalPeriod;
use App\Services\RichEditorService;
use App\Settings\ContactSettings;
use App\Settings\DirectorySettings;
use App\Settings\EventSettings;
use App\Settings\FormMemberPublicSettings;
use App\Settings\GeneralSettings;
use App\Settings\HomeSettings;
use App\Settings\LegalSettings;
use App\Settings\LicenceSettings;
use App\Settings\PolicySettings;
use App\Settings\PostSettings;
use App\Settings\SectionsSettings;
use Carbon\Carbon;
use Filament\Forms\Components\RichEditor\RichContentRenderer;
use Illuminate\Support\Facades\Storage;

if (! function_exists('getNearestTimeRoundedUp')) {
    function getNearestTimeRoundedUp($now, $nearestMin = 15, $minimumMinutes = 1): Carbon
    {
        $nearestSec = $nearestMin * 60;
        $minimumMoment = $now->addMinutes($minimumMinutes);
        $futureTimestamp = ceil($minimumMoment->timestamp / $nearestSec) * $nearestSec;
        $futureMoment = Carbon::createFromTimestamp($futureTimestamp, config('app.timezone'));

        return $futureMoment->startOfMinute();
    }

}

if (! function_exists('addTimeToDate')) {
    function addTimeToDate(Carbon $date, string $time): Carbon
    {
        [$hours, $minutes, $seconds] = explode(':', $time);

        return $date->copy()->addHours(intval($hours))->addMinutes(intval($minutes))->addSeconds(intval($seconds));
    }
}

if (! function_exists('getDuration')) {
    function getDuration(Carbon $start, Carbon $end, int $parts = 6): string
    {
        return $start->longAbsoluteDiffForHumans($end, $parts);
    }
}

if (! function_exists('getDisplayDate')) {
    function getDisplayDate(): string
    {
        return app(GeneralSettings::class)->display_date;
    }
}

if (! function_exists('getFallbackAvatar')) {
    function getFallbackAvatar(): string
    {
        return url(Storage::url(app(GeneralSettings::class)->fallback_avatar));
    }
}

if (! function_exists('getFallbackFuneralLogo')) {
    function getFallbackFuneralLogo(): string
    {
        return url(Storage::url(app(GeneralSettings::class)->fallback_funeral_logo));
    }
}

if (! function_exists('getClientLogo')) {
    function getClientLogo(): ?string
    {
        if (app(GeneralSettings::class)->client_logo) {
            return asset(Storage::url(app(GeneralSettings::class)->client_logo));
        } else {
            return null;
        }
    }
}

if (! function_exists('getClientEmail')) {
    function getClientEmail(): string
    {
        return app(GeneralSettings::class)->client_email;
    }
}

if (! function_exists('getClientLogoDark')) {
    function getClientLogoDark(): string
    {
        return url(Storage::url(app(GeneralSettings::class)->client_logo_dark));
    }
}

if (! function_exists('getClientName')) {
    function getClientName(): string
    {
        return app(GeneralSettings::class)->client_name;
    }
}

if (! function_exists('getClientPhone')) {
    function getClientPhone(): string
    {
        return app(GeneralSettings::class)->client_phone;
    }
}

if (! function_exists('getClientWebsite')) {
    function getClientWebsite(): string
    {
        return app(GeneralSettings::class)->client_website;
    }
}

if (! function_exists('getClientAddress')) {
    function getClientAddress(): string
    {
        return app(GeneralSettings::class)->client_address;
    }
}

if (! function_exists('getClientCity')) {
    function getClientCity(): string
    {
        return app(GeneralSettings::class)->client_city;
    }
}

if (! function_exists('getClientPostalCode')) {
    function getClientPostalCode(): string
    {
        return app(GeneralSettings::class)->client_postal_code;
    }
}

if (! function_exists('getGeneratorName')) {
    function getGeneratorName(): string
    {
        return app(GeneralSettings::class)->generator_name;
    }
}

if (! function_exists('getGeneratorWebsite')) {
    function getGeneratorWebsite(): string
    {
        return app(GeneralSettings::class)->generator_website;
    }
}

if (! function_exists('getGeneratorLogo')) {
    function getGeneratorLogo(): string
    {
        return url(Storage::url(app(GeneralSettings::class)->generator_logo));
    }
}

if (! function_exists('getGeneratorLogoDark')) {
    function getGeneratorLogoDark(): string
    {
        return url(Storage::url(app(GeneralSettings::class)->generator_logo_dark));
    }
}

if (! function_exists('getGeneratorNameEmail')) {
    function getGeneratorNameEmail(): string
    {
        return app(GeneralSettings::class)->generator_name_email;
    }
}

if (! function_exists('getGeneratorEmail')) {
    function getGeneratorEmail(): string
    {
        return app(GeneralSettings::class)->generator_email;
    }
}

if (! function_exists('getGeneratorPhone')) {
    function getGeneratorPhone(): string
    {
        return app(GeneralSettings::class)->generator_phone;
    }
}

if (! function_exists('getGeneratorSupportName')) {
    function getGeneratorSupportName(): string
    {
        return app(GeneralSettings::class)->generator_support_name;
    }
}

if (! function_exists('getGeneratorSupportEmail')) {
    function getGeneratorSupportEmail(): string
    {
        return app(GeneralSettings::class)->generator_support_email;
    }
}

if (! function_exists('getAppTitlePage')) {
    function getAppTitlePage(): string
    {
        return app(GeneralSettings::class)->app_title_page;
    }
}

if (! function_exists('getAppTitlePrefixPage')) {
    function getAppTitlePrefixPage(): string
    {
        return app(GeneralSettings::class)->app_title_prefix_page;
    }
}

if (! function_exists('getAppSalutationsInternal')) {
    function getAppSalutationsInternal(): RichContentRenderer
    {
        return RichContentRenderer::make(app(GeneralSettings::class)->app_salutations_internal);
    }
}

if (! function_exists('getAppSalutationsExternal')) {
    function getAppSalutationsExternal(): RichContentRenderer
    {
        return RichContentRenderer::make(app(GeneralSettings::class)->app_salutations_external);
    }
}

if (! function_exists('getAppDedicated')) {
    function getAppDedicated(): string
    {
        return app(GeneralSettings::class)->app_dedicated;
    }
}

if (! function_exists('getAppEmailLogoInternal')) {
    function getAppEmailLogoInternal(): string
    {
        return url(Storage::url(app(GeneralSettings::class)->app_email_logo_internal));
    }
}

if (! function_exists('getAppEmailLogoExternal')) {
    function getAppEmailLogoExternal(): string
    {
        return url(Storage::url(app(GeneralSettings::class)->app_email_logo_external));
    }
}

if (! function_exists('getAppEmailFrom')) {
    function getAppEmailFrom(): string
    {
        return app(GeneralSettings::class)->app_email_from;
    }
}

if (! function_exists('getAppEmailNameFrom')) {
    function getAppEmailNameFrom(): string
    {
        return app(GeneralSettings::class)->app_email_name_from;
    }
}

if (! function_exists('getMembership')) {
    function getMembership(): array
    {
        return app(GeneralSettings::class)->membership;
    }
}

if (! function_exists('getEmailsClient')) {
    function getEmailsClient(): array
    {
        return app(GeneralSettings::class)->emails_client;
    }
}

if (! function_exists('getSocialsNetworks')) {
    function getSocialsNetworks(): array
    {
        return app(GeneralSettings::class)->socials_networks;
    }
}

// LicenceSettings

if (! function_exists('getLicenceName')) {
    function getLicenceName(): string
    {
        return app(LicenceSettings::class)->name;
    }
}

if (! function_exists('getLicenceDescription')) {
    function getLicenceDescription(): RichContentRenderer
    {
        return RichContentRenderer::make(app(LicenceSettings::class)->description);
    }
}

if (! function_exists('getLicencePrice')) {
    function getLicencePrice(): string
    {
        return app(LicenceSettings::class)->price;
    }
}

if (! function_exists('getLicenceNextPrice')) {
    function getLicenceNextPrice(): string
    {
        return app(LicenceSettings::class)->next_price;
    }
}

if (! function_exists('getLicencePriceContract')) {
    function getLicencePriceContract(): string
    {
        if (getLicenceNextPrice() > 0) {
            return __('notification.licence-is-about-to-expire.new-price', ['next_price' => getLicenceNextPrice(), 'duration' => getLicenceFormatDuration()]);
        }

        return __('notification.licence-is-about-to-expire.price', ['duration' => getLicenceFormatDuration(), 'price' => getLicencePrice()]);
    }
}
//

if (! function_exists('getLicenceInvoiceInterval')) {
    function getLicenceInvoiceInterval(): IntervalPeriod
    {
        return app(LicenceSettings::class)->invoice_interval;
    }
}

if (! function_exists('getLicenceInvoicePeriod')) {
    function getLicenceInvoicePeriod(): int
    {
        return app(LicenceSettings::class)->invoice_period;
    }
}

if (! function_exists('getLicenceFormatDuration')) {
    function getLicenceFormatDuration(): string
    {

        $interval = getLicenceInvoicePeriod() <= 1 ? getLicenceInvoiceInterval()->getLabel() : getLicenceInvoiceInterval()->getPluralLabel();

        return getLicenceInvoicePeriod().' '.$interval;
    }
}

if (! function_exists('getLicenceInvoiceContactName')) {
    function getLicenceInvoiceContactName(): string
    {
        return app(LicenceSettings::class)->invoice_contact_name;
    }
}

if (! function_exists('getLicenceInvoiceContactEmail')) {
    function getLicenceInvoiceContactEmail(): string
    {
        return app(LicenceSettings::class)->invoice_contact_email;
    }
}

if (! function_exists('getLicenceStartsAt')) {
    function getLicenceStartsAt(): Carbon
    {
        return app(LicenceSettings::class)->starts_at;
    }
}

if (! function_exists('getLicenceEndsAt')) {
    function getLicenceEndsAt(): Carbon
    {
        return app(LicenceSettings::class)->ends_at;
    }
}

if (! function_exists('checkLicenceIsValid')) {
    function checkLicenceIsValid(): bool
    {
        return Carbon::now() < app(LicenceSettings::class)->ends_at;
    }
}
if (! function_exists('getDaysBefore')) {
    function getDaysBefore(): array
    {
        return app(LicenceSettings::class)->days_before;
    }
}
// MANAGE SECTIONS
// INTRODUCTION
if (! function_exists('getSectionIntroductionIsVisible')) {
    function getSectionIntroductionIsVisible(): bool
    {
        return app(SectionsSettings::class)->introduction['is_visible'];
    }
}
if (! function_exists('getSectionIntroductionBackgroundImage')) {
    function getSectionIntroductionBackgroundImage(): ?string
    {
        if (app(SectionsSettings::class)->introduction['image']) {
            return asset(Storage::url(app(SectionsSettings::class)->introduction['image']));
        } else {
            return null;
        }
    }
}
if (! function_exists('getSectionIntroductionTitle')) {
    function getSectionIntroductionTitle(): RichContentRenderer
    {
        return RichContentRenderer::make(app(SectionsSettings::class)->introduction['title'])
            ->textColors(app(RichEditorService::class)->getColors());
    }
}
if (! function_exists('getSectionIntroductionSubTitle')) {
    function getSectionIntroductionSubTitle(): ?string
    {
        return app(SectionsSettings::class)->introduction['subtitle'];
    }
}
if (! function_exists('getSectionIntroductionContent')) {
    function getSectionIntroductionContent(): RichContentRenderer
    {
        return RichContentRenderer::make(app(SectionsSettings::class)->introduction['content']);
    }
}
if (! function_exists('getSectionIntroductionLink')) {
    function getSectionIntroductionLink(): array
    {
        return app(SectionsSettings::class)->introduction['link'];
    }
}

// PRESENTATION
if (! function_exists('getSectionPresentationIsVisible')) {
    function getSectionPresentationIsVisible(): bool
    {
        return app(SectionsSettings::class)->presentation['is_visible'];
    }
}
if (! function_exists('getSectionPresentationSlider')) {
    function getSectionPresentationSlider(): array
    {
        return app(SectionsSettings::class)->presentation['slider'];
    }
}
if (! function_exists('getSectionPresentationTitle')) {
    function getSectionPresentationTitle(): string
    {
        return app(SectionsSettings::class)->presentation['title'];
    }
}
if (! function_exists('getSectionPresentationSubTitle')) {
    function getSectionPresentationSubTitle(): ?string
    {
        return app(SectionsSettings::class)->presentation['subtitle'];
    }
}
if (! function_exists('getSectionPresentationContent')) {
    function getSectionPresentationContent(): RichContentRenderer
    {
        return RichContentRenderer::make(app(SectionsSettings::class)->presentation['content']);
    }
}

// JOIN
if (! function_exists('getSectionJoinIsVisible')) {
    function getSectionJoinIsVisible(): bool
    {
        return app(SectionsSettings::class)->join['is_visible'];
    }
}
if (! function_exists('getSectionJoinTitle')) {
    function getSectionJoinTitle(): string
    {
        return app(SectionsSettings::class)->join['title'];
    }
}
if (! function_exists('getSectionJoinContent')) {
    function getSectionJoinContent(): RichContentRenderer
    {
        return RichContentRenderer::make(app(SectionsSettings::class)->join['content']);
    }
}

if (! function_exists('getSectionJoinLinks')) {
    function getSectionJoinLinks(): ?array
    {
        return app(SectionsSettings::class)->join['links'];
    }
}

if (! function_exists('getPostSettingsGeneral')) {
    function getPostSettingsGeneral(): ?array
    {
        return app(PostSettings::class)->general;
    }
}
if (! function_exists('getPostSettingsHeader')) {
    function getPostSettingsHeader(): ?array
    {
        return app(PostSettings::class)->header;
    }
}
if (! function_exists('getPostSettingsContent')) {
    function getPostSettingsContent(): ?array
    {
        return app(PostSettings::class)->content;
    }
}
if (! function_exists('getPostSettingsSeo')) {
    function getPostSettingsSeo(): ?array
    {
        return app(PostSettings::class)->seo;
    }
}

if (! function_exists('getPolicySettingsGeneral')) {
    function getPolicySettingsGeneral(): ?array
    {
        return app(PolicySettings::class)->general;
    }
}
if (! function_exists('getPolicySettingsHeader')) {
    function getPolicySettingsHeader(): ?array
    {
        return app(PolicySettings::class)->header;
    }
}
if (! function_exists('getPolicySettingsContent')) {
    function getPolicySettingsContent(): ?array
    {
        return app(PolicySettings::class)->content;
    }
}
if (! function_exists('getPolicySettingsSeo')) {
    function getPolicySettingsSeo(): ?array
    {
        return app(PolicySettings::class)->seo;
    }
}

if (! function_exists('getLegalSettingsGeneral')) {
    function getLegalSettingsGeneral(): ?array
    {
        return app(LegalSettings::class)->general;
    }
}
if (! function_exists('getLegalSettingsHeader')) {
    function getLegalSettingsHeader(): ?array
    {
        return app(LegalSettings::class)->header;
    }
}
if (! function_exists('getLegalSettingsContent')) {
    function getLegalSettingsContent(): ?array
    {
        return app(LegalSettings::class)->content;
    }
}
if (! function_exists('getLegalSettingsSeo')) {
    function getLegalSettingsSeo(): ?array
    {
        return app(LegalSettings::class)->seo;
    }
}

if (! function_exists('getHomeSettingsGeneral')) {
    function getHomeSettingsGeneral(): ?array
    {
        return app(HomeSettings::class)->general;
    }
}
if (! function_exists('getHomeSettingsHeader')) {
    function getHomeSettingsHeader(): ?array
    {
        return app(HomeSettings::class)->header;
    }
}
if (! function_exists('getHomeSettingsContent')) {
    function getHomeSettingsContent(): ?array
    {
        return app(HomeSettings::class)->content;
    }
}
if (! function_exists('getHomeSettingsSeo')) {
    function getHomeSettingsSeo(): ?array
    {
        return app(HomeSettings::class)->seo;
    }
}

if (! function_exists('getEventSettingsGeneral')) {
    function getEventSettingsGeneral(): ?array
    {
        return app(EventSettings::class)->general;
    }
}
if (! function_exists('getEventSettingsHeader')) {
    function getEventSettingsHeader(): ?array
    {
        return app(EventSettings::class)->header;
    }
}
if (! function_exists('getEventSettingsContent')) {
    function getEventSettingsContent(): ?array
    {
        return app(EventSettings::class)->content;
    }
}
if (! function_exists('getEventSettingsSeo')) {
    function getEventSettingsSeo(): ?array
    {
        return app(EventSettings::class)->seo;
    }
}

if (! function_exists('getDirectorySettingsGeneral')) {
    function getDirectorySettingsGeneral(): ?array
    {
        return app(DirectorySettings::class)->general;
    }
}
if (! function_exists('getDirectorySettingsHeader')) {
    function getDirectorySettingsHeader(): ?array
    {
        return app(DirectorySettings::class)->header;
    }
}
if (! function_exists('getDirectorySettingsContent')) {
    function getDirectorySettingsContent(): ?array
    {
        return app(DirectorySettings::class)->content;
    }
}
if (! function_exists('getDirectorySettingsSeo')) {
    function getDirectorySettingsSeo(): ?array
    {
        return app(DirectorySettings::class)->seo;
    }
}

if (! function_exists('getContactSettingsGeneral')) {
    function getContactSettingsGeneral(): ?array
    {
        return app(ContactSettings::class)->general;
    }
}
if (! function_exists('getContactSettingsHeader')) {
    function getContactSettingsHeader(): ?array
    {
        return app(ContactSettings::class)->header;
    }
}
if (! function_exists('getContactSettingsContent')) {
    function getContactSettingsContent(): ?array
    {
        return app(ContactSettings::class)->content;
    }
}
if (! function_exists('getContactSettingsSeo')) {
    function getContactSettingsSeo(): ?array
    {
        return app(ContactSettings::class)->seo;
    }
}

if (! function_exists('getFormMemberPublicSettingsGeneral')) {
    function getFormMemberPublicSettingsGeneral(): ?array
    {
        return app(FormMemberPublicSettings::class)->general;
    }
}
if (! function_exists('getFormMemberPublicSettingsHeader')) {
    function getFormMemberPublicSettingsHeader(): ?array
    {
        return app(FormMemberPublicSettings::class)->header;
    }
}
if (! function_exists('getFormMemberPublicSettingsContent')) {
    function getFormMemberPublicSettingsContent(): ?array
    {
        return app(FormMemberPublicSettings::class)->content;
    }
}
if (! function_exists('getFormMemberPublicSettingsSeo')) {
    function getFormMemberPublicSettingsSeo(): ?array
    {
        return app(FormMemberPublicSettings::class)->seo;
    }
}
