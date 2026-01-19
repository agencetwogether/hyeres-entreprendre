<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class PolicySettings extends Settings
{
    public array $general;

    public array $header;

    public array $content;

    public array $seo;

    public static function group(): string
    {
        return 'policy_page_settings';
    }
}
