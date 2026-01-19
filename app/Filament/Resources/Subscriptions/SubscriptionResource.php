<?php

namespace App\Filament\Resources\Subscriptions;

use App\Filament\Resources\Subscriptions\Pages\ListSubscriptions;
use App\Filament\Resources\Subscriptions\Schemas\SubscriptionForm;
use App\Filament\Resources\Subscriptions\Tables\SubscriptionsTable;
use App\Models\Subscription;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Laravelcm\Subscriptions\Models\Plan;

class SubscriptionResource extends Resource
{
    protected static ?string $model = Subscription::class;

    protected static ?string $slug = 'abonnements';

    protected static string|null|BackedEnum $navigationIcon = 'phosphor-credit-card';

    public static function getNavigationGroup(): ?string
    {
        return __('app.general.navigation.groups.administration');
    }

    public static function getModelLabel(): string
    {
        return __('app.subscriptions.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('app.subscriptions.plural');
    }

    public static function getNavigationLabel(): string
    {
        return __('app.subscriptions.navigation_label');
    }

    public static function form(Schema $schema): Schema
    {
        return SubscriptionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SubscriptionsTable::configure($table);

    }

    public static function getPages(): array
    {
        return [
            'index' => ListSubscriptions::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    /*public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['plan']);
    }*/

    /*public static function getGloballySearchableAttributes(): array
    {
        return ['slug', 'title', 'plan.name'];
    }*/

    /*public static function getGlobalSearchResultDetails(Model $record): array
    {
        $details = [];

        if ($record->plan) {
            $details['Plan'] = $record->plan->name;
        }

        return $details;
    }*/
}
