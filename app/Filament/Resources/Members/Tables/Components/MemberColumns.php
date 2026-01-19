<?php

namespace App\Filament\Resources\Members\Tables\Components;

use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Ysfkaya\FilamentPhoneInput\PhoneInputNumberType;
use Ysfkaya\FilamentPhoneInput\Tables\PhoneColumn;

class MemberColumns
{
    public static function getAvatar(): SpatieMediaLibraryImageColumn
    {
        return SpatieMediaLibraryImageColumn::make('avatar')
            ->label(__('app.members.table.label.avatar'))
            ->collection('avatar')
            ->conversion('webp')
            ->circular();
    }

    public static function getFirstname(): TextColumn
    {
        return TextColumn::make('firstname')
            ->label(__('app.members.table.label.firstname'))
            ->searchable()
            ->sortable();
    }

    public static function getName(): TextColumn
    {
        return TextColumn::make('name')
            ->label(__('app.members.table.label.name'))
            ->searchable()
            ->sortable();
    }

    public static function getFullName(): TextColumn
    {
        return TextColumn::make('fullname')
            ->label(__('app.members.table.label.fullname'))
            ->state(function (Model $record): string {
                return "{$record->firstname} {$record->name}";
            })
            ->searchable(query: function (Builder $query, string $search): Builder {
                return $query
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('firstname', 'like', "%{$search}%");
            })
            ->sortable(['firstname', 'name']);
    }

    public static function getJob(): TextColumn
    {
        return TextColumn::make('job')
            ->label(__('app.members.table.label.job'));
    }

    public static function getPhone(): PhoneColumn
    {
        return PhoneColumn::make('phone')
            ->label(__('app.members.table.label.phone'))
            ->displayFormat(PhoneInputNumberType::NATIONAL);
    }

    public static function getEmail(): TextColumn
    {
        return TextColumn::make('email')
            ->label(__('app.members.table.label.email'))
            ->searchable();
    }

    public static function getCompanyName(): TextColumn
    {
        return TextColumn::make('company_name')
            ->label(__('app.members.table.label.company_name'))
            ->searchable()
            ->sortable();
    }

    public static function getIsPublished(): ToggleColumn
    {
        return ToggleColumn::make('is_published')
            ->label(__('app.members.table.label.is_published'))
            ->disabled(fn (Model $record) => ! $record->onePlanSubscriptions?->paid() || $record->is_draft);
    }

    /*public static function getIsPublished(): IconColumn
    {
        return IconColumn::make('is_published')
            ->label(__('app.members.table.label.is_published'))
            ->boolean();
    }*/

    public static function getCompanyLogo(): SpatieMediaLibraryImageColumn
    {
        return SpatieMediaLibraryImageColumn::make('company_logo')
            // ->label(__('app.members.table.label.company_logo'))
            ->label('#')
            ->collection('company_logo')
            ->conversion('square')
            ->circular();
    }

    public static function getCompanyActivity(): TextColumn
    {
        return TextColumn::make('company_activity')
            ->label(__('app.members.table.label.company_activity'))
            ->searchable()
            ->sortable();
    }

    public static function getCompanyDescription(): TextColumn
    {
        return TextColumn::make('company_description')
            ->label(__('app.members.table.label.company_description'))
            ->limit(10);
    }

    public static function getCompanyStreet(): TextColumn
    {
        return TextColumn::make('company_street')
            ->label(__('app.members.table.label.company_street'));
    }

    public static function getCompanyExtStreet(): TextColumn
    {
        return TextColumn::make('company_ext_street')
            ->label(__('app.members.table.label.company_ext_street'));
    }

    public static function getCompanyPostalCode(): TextColumn
    {
        return TextColumn::make('company_postal_code')
            ->label(__('app.members.table.label.company_postal_code'));
    }

    public static function getCompanyCity(): TextColumn
    {
        return TextColumn::make('company_city')
            ->label(__('app.members.table.label.company_city'));
    }

    public static function getCompanyWebsite(): TextColumn
    {
        return TextColumn::make('company_website')
            ->label(__('app.members.table.label.company_website'));
    }

    public static function getHasPlanActive(): IconColumn
    {
        return IconColumn::make('active')
            ->label(__('app.members.table.label.has_plan'))
            ->state(fn (Model $record) => $record->onePlanSubscriptions?->active())
            ->boolean();
    }

    public static function getPlanStartsAt(): TextColumn
    {
        return TextColumn::make('onePlanSubscriptions.starts_at')
            ->label(__('app.members.table.label.plan_starts_at'))
            ->headerTooltip(__('app.members.table.tooltip.plan_starts_at'))
            ->date(getDisplayDate())
            ->toggleable(isToggledHiddenByDefault: true)
            ->sortable()
            ->searchable();
    }

    public static function getPlanEndsAt(): TextColumn
    {
        return TextColumn::make('onePlanSubscriptions.ends_at')
            ->label(__('app.members.table.label.plan_ends_at'))
            ->headerTooltip(__('app.members.table.tooltip.plan_ends_at'))
            ->date(getDisplayDate())
            ->toggleable(isToggledHiddenByDefault: true)
            ->sortable()
            ->searchable();
    }

    public static function getPlanCanceledAt(): TextColumn
    {
        return TextColumn::make('onePlanSubscriptions.canceled_at')
            ->label(__('app.members.table.label.plan_canceled_at'))
            ->headerTooltip(__('app.members.table.tooltip.plan_canceled_at'))
            ->date(getDisplayDate())
            ->toggleable(isToggledHiddenByDefault: true)
            ->sortable()
            ->searchable();
    }

    public static function getPlanPaid(): TextColumn
    {
        return TextColumn::make('onePlanSubscriptions.payment_received_at')
            ->label(__('app.members.table.label.plan_payment_received_at'))
            ->date('d/m/Y H:i')
            ->placeholder('-')
            ->sortable()
            ->searchable();
    }
}
