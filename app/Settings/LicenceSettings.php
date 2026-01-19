<?php

namespace App\Settings;

use App\Enums\IntervalPeriod;
use Carbon\Carbon;
use Spatie\LaravelSettings\Settings;
use Spatie\LaravelSettings\SettingsCasts\EnumCast;

class LicenceSettings extends Settings
{
    public string $name;

    public string $description;

    public int $price;

    public int $next_price;

    public int $invoice_period;

    public IntervalPeriod $invoice_interval;

    public string $invoice_contact_name;

    public string $invoice_contact_email;

    public ?Carbon $starts_at;

    public ?Carbon $ends_at;

    public array $days_before;

    public static function group(): string
    {
        return 'licence';
    }

    public static function casts(): array
    {
        return [
            'invoice_interval' => EnumCast::class,
        ];
    }
}
