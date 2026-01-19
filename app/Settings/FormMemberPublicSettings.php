<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class FormMemberPublicSettings extends Settings
{
    public array $general;

    public array $header;

    public array $content;

    public array $seo;

    public static function group(): string
    {
        return 'form_member_public_page_settings';
    }
}
