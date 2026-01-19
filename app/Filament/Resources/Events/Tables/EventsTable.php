<?php

namespace App\Filament\Resources\Events\Tables;

use App\Filament\Resources\Events\EventResource;
use App\Filament\Resources\Events\Tables\Components\EventColumns;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class EventsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                EventColumns::getThumbnail(),
                EventColumns::getTitle(),
                EventColumns::getSlug(),
                EventColumns::getExcerpt(),
                EventColumns::getDateStart(),
                EventColumns::getDateEnd(),
                EventColumns::getLocation(),
                EventColumns::getPrice(),
                EventColumns::getPublishedAt(),
            ])
            ->defaultSort('date_start', 'desc')
            ->recordActions([
                ActionGroup::make([
                    EditAction::make()
                        ->label(__('app.events.table.action.edit.label')),
                    DeleteAction::make()
                        ->label(__('app.events.table.action.delete.label'))
                        ->modalHeading(fn (Model $record): string => __('app.events.table.action.delete.modal.heading', ['title' => $record->title]))
                        ->modalDescription(__('app.events.table.action.delete.modal.description'))
                        ->successNotificationTitle(fn (Model $record): string => __('app.events.table.action.delete.modal.notification_success', ['title' => $record->title])),
                ]),
            ])
            ->emptyStateIcon(EventResource::getNavigationIcon())
            ->emptyStateHeading(__('app.events.table.empty_state.heading'))
            ->emptyStateDescription(__('app.events.table.empty_state.description'));
    }
}
