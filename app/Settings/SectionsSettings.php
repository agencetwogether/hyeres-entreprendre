<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class SectionsSettings extends Settings
{
    public array $introduction;

    public array $presentation;

    public array $join;

    public static function group(): string
    {
        return 'sections';
    }
}
