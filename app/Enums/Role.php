<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum Role: string implements HasColor, HasIcon, HasLabel
{
    case SUPERADMIN = 'super_admin';
    case ADMIN = 'admin';
    case MEMBER = 'member';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::SUPERADMIN => __('app.general.enum_role.super_admin'),
            self::ADMIN => __('app.general.enum_role.admin'),
            self::MEMBER => __('app.general.enum_role.member'),
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::SUPERADMIN => 'danger',
            self::ADMIN => 'warning',
            self::MEMBER => 'info',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::SUPERADMIN => 'phosphor-shield-check',
            default => 'phosphor-shield',
        };
    }
}
