<?php

namespace App\Filament\Forms\Components;

use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Support\Arr;

class SeoTab
{
    public static function make(array $only = ['title', 'author', 'description', 'robots']): Tab
    {
        return Tab::make(__('app.general.seo.form.section.title'))
            ->icon('phosphor-magnifying-glass')
            ->schema(
                Arr::only([
                    'title' => SeoFormComponents::getTitle(),
                    'author' => SeoFormComponents::getAuthor(),
                    'description' => SeoFormComponents::getDescription(),
                    'robots' => SeoFormComponents::getRobots(),
                ], $only)
            );
    }
}
