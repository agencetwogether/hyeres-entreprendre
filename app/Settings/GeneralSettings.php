<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public string $display_date;

    public ?string $fallback_avatar;

    public ?string $fallback_logo;

    public ?string $client_logo;

    public ?string $client_logo_dark;

    public ?string $client_name;

    public ?string $client_phone;

    public ?string $client_website;

    public ?string $client_email;

    public ?string $client_address;

    public ?string $client_city;

    public ?string $client_postal_code;

    public ?string $generator_name;

    public ?string $generator_website;

    public ?string $generator_logo;

    public ?string $generator_logo_dark;

    public ?string $generator_name_email;

    public ?string $generator_email;

    public ?string $generator_phone;

    public ?string $generator_support_name;

    public ?string $generator_support_email;

    public ?string $app_title_page;

    public ?string $app_title_prefix_page;

    public ?string $app_salutations_internal;

    public ?string $app_salutations_external;

    public ?string $app_dedicated;

    public ?string $app_email_logo_internal;

    public ?string $app_email_logo_external;

    public ?string $app_email_from;

    public ?string $app_email_name_from;

    public array $emails_client;

    public array $membership;

    public array $socials_networks;

    public static function group(): string
    {
        return 'general';
    }
}
