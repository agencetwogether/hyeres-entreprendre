<?php

namespace App\Filament\Resources\Members\Tables;

use App\Filament\Resources\Members\Actions\Approve;
use App\Filament\Resources\Members\Actions\Cancel;
use App\Filament\Resources\Members\Actions\ChangePlan;
use App\Filament\Resources\Members\Actions\CreateUser;
use App\Filament\Resources\Members\Actions\DeclarePaymentReceived;
use App\Filament\Resources\Members\Actions\Renew;
use App\Filament\Resources\Members\Actions\RenewWhenCanceled;
use App\Filament\Resources\Members\Actions\RenewWhenCanceledImmediately;
use App\Filament\Resources\Members\Actions\ResendCredentials;
use App\Filament\Resources\Members\Actions\Subscribe;
use App\Filament\Resources\Members\MemberResource;
use App\Filament\Resources\Members\Tables\Components\MemberColumns;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\Width;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class MembersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->recordUrl(fn (Model $record) => $record->is_draft ? null : MemberResource::getUrl('view', ['record' => $record]))
            ->defaultGroup(Group::make('member_type')
                ->titlePrefixedWithLabel(false)
                ->collapsible())
            ->columns([
                MemberColumns::getCompanyLogo(),
                MemberColumns::getCompanyName(),
                MemberColumns::getFullName(),
                MemberColumns::getIsPublished(),
                MemberColumns::getHasPlanActive(),
                MemberColumns::getPlanPaid(),
                MemberColumns::getPlanStartsAt(),
                MemberColumns::getPlanEndsAt(),
                MemberColumns::getPlanCanceledAt(),
            ])
            ->filters([
                Filter::make('is_draft')
                    ->label(__('app.members.table.filter.is_draft'))
                    ->query(fn (Builder $query): Builder => $query->where('is_draft', true)),
                Filter::make('has_no_payment')
                    ->label(__('app.members.table.filter.has_no_payment'))
                    ->query(fn (Builder $query): Builder => $query
                        ->whereDoesntHave('onePlanSubscriptions', function (Builder $query) {
                            $query->where('payment_received_at', '!=', null);
                        })
                        ->where('is_draft', false)
                    ),
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make()
                        ->label(__('app.members.table.action.view.label'))
                        ->color('success')
                        ->visible(function (Model $record): bool {
                            if (
                                auth()->user()->can('Approve:Member')
                                && $record->is_draft
                            ) {
                                return false;
                            }

                            return true;
                        }),
                    EditAction::make()
                        ->label(__('app.members.table.action.edit.label'))
                        ->hidden(fn (Model $record): bool => $record->is_draft),
                    DeleteAction::make()
                        ->label(__('app.members.table.action.delete.label'))
                        ->modalHeading(fn (Model $record): string => __('app.members.table.action.delete.modal.heading', ['name' => $record->name]))
                        ->modalDescription(__('app.members.table.action.delete.modal.description'))
                        ->successNotificationTitle(fn (Model $record): string => __('app.members.table.action.delete.modal.notification_success', ['name' => $record->name])),
                    ActionGroup::make([
                        Approve::make(),
                        CreateUser::make(),
                        ResendCredentials::make(),
                    ])
                        ->dropdown(false),
                    ActionGroup::make([
                        Subscribe::make(),
                        DeclarePaymentReceived::make(),
                        ChangePlan::make(),
                        Renew::make(),
                        RenewWhenCanceledImmediately::make(),
                        RenewWhenCanceled::make(),
                        Cancel::make(),
                    ])
                        ->visible(fn (Model $record) => ! $record->is_draft)
                        ->dropdown(false),
                ])->dropdownWidth(Width::ExtraSmall),
            ])
            ->recordClasses(function (Model $record) {
                if (! filled($record->company_name) || $record->is_draft) {
                    return 'border-l-4! border-l-danger-600! dark:border-l-danger-500! hover:bg-danger-50! dark:hover:bg-danger-950!';
                }
                if (! $record->onePlanSubscriptions?->paid()) {
                    return 'border-l-4! border-l-warning-600! dark:border-l-warning-500! hover:bg-warning-50! dark:hover:bg-warning-950!';
                }
            })
            ->emptyStateIcon(MemberResource::getNavigationIcon())
            ->emptyStateHeading(__('app.members.table.empty_state.heading'))
            ->emptyStateDescription(__('app.members.table.empty_state.description'))
            ->paginated([5, 10, 25])
            ->defaultPaginationPageOption(10);
        // ->deferLoading();
    }
}
