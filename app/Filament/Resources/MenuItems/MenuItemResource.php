<?php

namespace App\Filament\Resources\MenuItems;

use Biostate\FilamentMenuBuilder\Filament\Resources\MenuItemResource as BaseMenuItemResource;

class MenuItemResource extends BaseMenuItemResource
{
    public static function getNavigationGroup(): ?string
    {
        return __('app.general.navigation.groups.administration');
    }
}
