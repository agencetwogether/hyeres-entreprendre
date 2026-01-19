<?php

namespace App\Filament\Resources\Subscriptions\Tables;

use App\Filament\Resources\Subscriptions\SubscriptionResource;
use App\Filament\Resources\Subscriptions\Tables\Components\SubscriptionColumns;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class SubscriptionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                SubscriptionColumns::getSubscriberName(),
                SubscriptionColumns::getPlanName(),
                SubscriptionColumns::getActive(),
                SubscriptionColumns::getTrialEndsAt(),
                SubscriptionColumns::getStartsAt(),
                SubscriptionColumns::getEndsAt(),
                SubscriptionColumns::getCanceledAt(),
            ])
            ->filters([
                TrashedFilter::make(),
                Filter::make(__('app.subscriptions.table.filters.date_range'))
                    ->schema([
                        DatePicker::make('start_date')
                            ->label(__('app.subscriptions.table.filters.start_date'))
                            ->required(),
                        DatePicker::make('end_date')
                            ->label(__('app.subscriptions.table.filters.end_date'))
                            ->required(),
                    ])
                    ->query(function (Builder $query, array $data) {
                        if (! isset($data['start_date']) || ! isset($data['end_date'])) {
                            return $query;
                        }

                        return $query->whereBetween('starts_at', [$data['start_date'], $data['end_date']]);
                    }),
                Filter::make(__('app.subscriptions.table.filters.canceled'))
                    ->schema([
                        Select::make('canceled')
                            ->label(__('app.subscriptions.table.filters.canceled'))
                            ->options([
                                '' => __('app.subscriptions.table.filters.all'),
                                '1' => __('app.subscriptions.table.filters.yes'),
                                '0' => __('app.subscriptions.table.filters.no'),
                            ])
                            ->required(),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        if (! isset($data['canceled'])) {
                            return $query;
                        }
                        if ($data['canceled'] === '1') {
                            return $query->whereNotNull('canceled_at');
                        }
                        if ($data['canceled'] === '0') {
                            return $query->whereNull('canceled_at');
                        }

                        return $query;
                    }),
            ])
            ->recordActions([
                EditAction::make()
                    ->tooltip(__('app.subscriptions.table.action.edit.label'))
                    ->iconButton(),
                Action::make('cancel')
                    ->visible(fn (Model $record): bool => $record->active())
                    ->iconButton()
                    ->label(__('app.subscriptions.table.action.cancel.label'))
                    ->tooltip(__('app.subscriptions.table.action.cancel.label'))
                    ->icon('heroicon-o-x-circle')
                    ->color('warning')
                    ->action(function (Model $record) {
                        $record->cancel(true);

                        Notification::make()
                            ->body(__('app.subscriptions.table.action.cancel.notification_success'))
                            ->success()
                            ->send();
                    })
                    ->requiresConfirmation(),
                Action::make('renew')
                    ->visible(fn (Model $record): bool => $record->ended())
                    ->iconButton()
                    ->label(__('app.subscriptions.table.action.renew.label'))
                    ->tooltip(__('app.subscriptions.table.action.renew.label'))
                    ->icon('heroicon-o-arrow-path-rounded-square')
                    ->color('info')
                    ->action(function (Model $record) {
                        $record->canceled_at = Carbon::parse($record->cancels_at)->addDays(1);
                        $record->cancels_at = Carbon::parse($record->cancels_at)->addDays(1);
                        $record->ends_at = Carbon::parse($record->cancels_at)->addDays(1);
                        $record->save();
                        $record->renew();

                        Notification::make()
                            ->body(__('app.subscriptions.table.action.renew.notification_success'))
                            ->success()
                            ->send();

                    })
                    ->requiresConfirmation(),
                DeleteAction::make()
                    ->tooltip(__('app.subscriptions.table.action.delete.label'))
                    ->iconButton(),
                ForceDeleteAction::make()
                    ->tooltip(__('app.subscriptions.table.action.force_delete.label'))
                    ->iconButton(),
                RestoreAction::make()
                    ->tooltip(__('app.subscriptions.table.action.restore.label'))
                    ->iconButton(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->emptyStateIcon(SubscriptionResource::getNavigationIcon())
            ->emptyStateHeading(__('app.subscriptions.table.empty_state.heading'))
            ->emptyStateDescription(__('app.subscriptions.table.empty_state.description'));
    }
}
