<?php

namespace App\Filament\Resources\Menus;

use Biostate\FilamentMenuBuilder\Filament\Resources\MenuResource as BaseMenuResource;

class MenuResource extends BaseMenuResource
{
    public static function getNavigationGroup(): ?string
    {
        return __('app.general.navigation.groups.administration');
    }
}
