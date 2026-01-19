<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum IntervalPeriod: string implements HasLabel
{
    case YEAR = 'year';
    case MONTH = 'month';
    case WEEK = 'week';
    case DAY = 'day';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::YEAR => __('app.general.enum_interval_period.year'),
            self::MONTH => __('app.general.enum_interval_period.month'),
            self::WEEK => __('app.general.enum_interval_period.week'),
            self::DAY => __('app.general.enum_interval_period.day'),
        };
    }

    public function getPluralLabel(): ?string
    {
        return match ($this) {
            self::YEAR => __('app.general.enum_interval_period.years'),
            self::MONTH => __('app.general.enum_interval_period.months'),
            self::WEEK => __('app.general.enum_interval_period.weeks'),
            self::DAY => __('app.general.enum_interval_period.days'),
        };
    }
}
