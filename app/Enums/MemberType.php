<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum MemberType: string implements HasLabel
{
    case MEMBER = 'member';
    case PARTNER = 'partner';
    case OFFICE = 'office';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::MEMBER => __('app.general.enum_member_type.member'),
            self::PARTNER => __('app.general.enum_member_type.partner'),
            self::OFFICE => __('app.general.enum_member_type.office'),
        };
    }

    public function getPluralLabel(): ?string
    {
        return match ($this) {
            self::MEMBER => __('app.general.enum_member_type.members'),
            self::PARTNER => __('app.general.enum_member_type.partners'),
            self::OFFICE => __('app.general.enum_member_type.offices'),
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(function ($item) {
            return [$item->value => $item->getPluralLabel()];
        })->toArray();
    }
}
