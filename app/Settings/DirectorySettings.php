<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class DirectorySettings extends Settings
{
    public array $general;

    public array $header;

    public array $content;

    public array $seo;

    public static function group(): string
    {
        return 'directory_page_settings';
    }
}
