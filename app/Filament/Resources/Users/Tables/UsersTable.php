<?php

namespace App\Filament\Resources\Users\Tables;

use App\Enums\Role as RoleEnum;
use App\Filament\Resources\Users\Actions\ChangeIsActive;
use App\Filament\Resources\Users\Actions\GivePermission;
use App\Filament\Resources\Users\Tables\Components\UserColumns;
use App\Filament\Resources\Users\UserResource;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use STS\FilamentImpersonate\Actions\Impersonate;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->query(UserResource::getEloquentQuery())
            ->columns([
                UserColumns::getTableAvatar(),
                UserColumns::getTableCompleteName(),
                UserColumns::getTableEmail(),
                UserColumns::getTableRole(),
                UserColumns::getTableIsActive(),
                UserColumns::getTableForceRenewPassword(),
            ])
            ->filters([
                Filter::make('roles')
                    ->schema([
                        Select::make('role')
                            ->label(__('app.users.table.filter.roles.role'))
                            ->options(RoleEnum::class)
                            ->native(false)
                            ->searchable()
                            ->preload(),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['role'],
                                fn (Builder $query, $role): Builder => $query->whereRelation('roles', 'name', $role)
                            );
                    })
                    ->indicateUsing(function (array $data): ?string {
                        $role = data_get($data, 'role');

                        if (empty($role)) {
                            return null;
                        }

                        return __('app.users.table.filter.roles.indicate').RoleEnum::from($role)->getLabel();
                    }),
            ], layout: FiltersLayout::AboveContent)
            ->recordActions([
                ActionGroup::make([
                    Impersonate::make(),
                    GivePermission::make(),
                    ChangeIsActive::make(),
                    EditAction::make()
                        ->label(__('app.users.actions.edit.label.button')),
                    DeleteAction::make()
                        ->label(__('app.users.actions.delete.label.button'))
                        ->modalHeading(fn (Model $record): string => __('app.users.actions.delete.modal.heading', ['name' => $record->getFilamentName()]))
                        ->modalDescription(__('app.users.actions.delete.modal.description'))
                        ->successNotificationTitle(fn (Model $record): string => __('app.users.actions.delete.notification.success', ['name' => $record->getFilamentName()]))
                        ->visible(fn (Model $record): bool => auth()->user()->id !== $record->id),
                ]),
            ]);
    }
}
