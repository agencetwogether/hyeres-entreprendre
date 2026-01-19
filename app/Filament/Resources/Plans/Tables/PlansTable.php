<?php

namespace App\Filament\Resources\Plans\Tables;

use App\Filament\Resources\Plans\PlanResource;
use App\Filament\Resources\Plans\Tables\Components\PlanColumns;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class PlansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->columns([
                PlanColumns::getName(),
                PlanColumns::getPrice(),
                PlanColumns::getIsActive(),
            ])
            ->defaultSort('sort_order')
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                ActionGroup::make([
                    EditAction::make()
                        ->label(__('app.plans.table.action.edit.label')),
                    DeleteAction::make()
                        ->label(__('app.plans.table.action.delete.label'))
                        ->modalHeading(fn (Model $record): string => __('app.plans.table.action.delete.modal.heading', ['name' => $record->name]))
                        ->modalDescription(__('app.plans.table.action.delete.modal.description'))
                        ->successNotificationTitle(fn (Model $record): string => __('app.plans.table.action.delete.modal.notification_success', ['name' => $record->name])),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateIcon(PlanResource::getNavigationIcon())
            ->emptyStateHeading(__('app.plans.table.empty_state.heading'))
            ->emptyStateDescription(__('app.plans.table.empty_state.description'));
    }
}
