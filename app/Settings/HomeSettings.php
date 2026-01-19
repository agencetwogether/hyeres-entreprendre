<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class HomeSettings extends Settings
{
    public array $general;

    public array $header;

    public array $content;

    public array $seo;

    public static function group(): string
    {
        return 'home_page_settings';
    }
}
