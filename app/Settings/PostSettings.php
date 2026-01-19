<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class PostSettings extends Settings
{
    public array $general;

    public array $header;

    public array $content;

    public array $seo;

    public static function group(): string
    {
        return 'post_page_settings';
    }
}
