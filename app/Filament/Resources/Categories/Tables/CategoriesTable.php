<?php

namespace App\Filament\Resources\Categories\Tables;

use App\Filament\Resources\Categories\CategoryResource;
use App\Filament\Resources\Categories\Tables\Components\CategoryColumns;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class CategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                CategoryColumns::getName(),
                CategoryColumns::getSlug()
                    ->visible(auth()->user()->isSuperAdmin()),
                CategoryColumns::getDescription(),
                CategoryColumns::getIsVisible(),
            ])
            ->filters([
                TernaryFilter::make('is_visible')
                    ->label(__('app.categories.table.filter.is_visible'))
                    ->native(false),
            ])
            ->recordActions([
                ActionGroup::make([
                    EditAction::make()
                        ->label(__('app.categories.table.action.edit.label')),
                    DeleteAction::make()
                        ->label(__('app.categories.table.action.delete.label'))
                        ->modalHeading(fn (Model $record): string => __('app.categories.table.action.delete.modal.heading', ['name' => $record->name]))
                        ->modalDescription(__('app.categories.table.action.delete.modal.description'))
                        ->successNotificationTitle(fn (Model $record): string => __('app.categories.table.action.delete.modal.notification_success', ['name' => $record->name])),
                ]),
            ])
            ->emptyStateIcon(CategoryResource::getNavigationIcon())
            ->emptyStateHeading(__('app.categories.table.empty_state.heading'))
            ->emptyStateDescription(__('app.categories.table.empty_state.description'));
    }
}
