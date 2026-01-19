<?php

namespace App\Filament\Resources\Events;

use App\Filament\Resources\Events\Pages\CreateEvent;
use App\Filament\Resources\Events\Pages\EditEvent;
use App\Filament\Resources\Events\Pages\ListEvents;
use App\Filament\Resources\Events\Schemas\EventForm;
use App\Filament\Resources\Events\Tables\EventsTable;
use App\Models\Event;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $slug = 'evenements';

    protected static string|null|BackedEnum $navigationIcon = 'phosphor-calendar-dots';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'title';

    public static function getNavigationGroup(): ?string
    {
        return __('app.general.navigation.groups.site');
    }

    public static function getModelLabel(): string
    {
        return __('app.events.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('app.events.plural');
    }

    public static function getNavigationLabel(): string
    {
        return __('app.events.navigation');
    }

    public static function form(Schema $schema): Schema
    {
        return EventForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EventsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEvents::route('/'),
            'create' => CreateEvent::route('/create'),
            'edit' => EditEvent::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'location'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            __('app.events.global_search.date') => $record->date_start->format('d/m/Y - H:i'),
        ];
    }
}
