<?php

namespace App\Filament\Resources\Events\Schemas;

use App\Filament\Resources\Events\EventResource;
use App\Filament\Resources\Events\Schemas\Components\EventFields;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EventForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('app.events.form.section.event.title'))
                    ->icon(EventResource::getNavigationIcon())
                    ->iconColor('primary')
                    ->description(__('app.events.form.section.event.description'))
                    ->schema([
                        EventFields::getThumbnail()
                            ->columnSpan(1),
                        EventFields::getPublishedAt()
                            ->columnSpan(1),
                        EventFields::getTitle()
                            ->columnSpan(1),
                        EventFields::getSlug()
                            ->columnSpan(1),
                        EventFields::getExcerpt()
                            ->columnSpanFull(),
                        EventFields::getContent()
                            ->columnSpanFull(),
                        EventFields::getDateStart()
                            ->columnSpan(1),
                        EventFields::getDateEnd()
                            ->columnSpan(1),
                        EventFields::getLocation()
                            ->columnSpan(1),
                        EventFields::getPrice()
                            ->columnSpan(1),
                        EventFields::getExternalLink()
                            ->columnSpanFull(),

                    ])
                    ->columns(),
            ]);
    }
}
