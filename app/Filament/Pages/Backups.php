<?php

namespace App\Filament\Pages;

use BackedEnum;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use ShuvroRoy\FilamentSpatieLaravelBackup\Pages\Backups as BaseBackups;

class Backups extends BaseBackups
{
    use HasPageShield;

    protected static string|null|BackedEnum $navigationIcon = 'phosphor-cloud';

    public static function getNavigationGroup(): ?string
    {
        return __('app.general.navigation.groups.administration');
    }
}
