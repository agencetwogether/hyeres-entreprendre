<?php

namespace App\Filament\Resources\Users;

use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\Pages\EditUserPermission;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Filament\Resources\Users\Schemas\UserForm;
use App\Filament\Resources\Users\Tables\UsersTable;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $slug = 'utilisateurs';

    protected static string|null|BackedEnum $navigationIcon = 'heroicon-o-users';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'full_name';

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->isSuperAdmin() || auth()->user()->isAdmin();
    }

    public static function getNavigationGroup(): ?string
    {
        return __('app.general.navigation.groups.administration');
    }

    public static function getModelLabel(): string
    {
        return __('app.users.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('app.users.plural');
    }

    public static function getNavigationLabel(): string
    {
        return __('app.users.plural');
    }

    public static function form(Schema $schema): Schema
    {
        return UserForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UsersTable::configure($table);
    }

    public static function getEloquentQuery(): Builder
    {

        $query = parent::getEloquentQuery();

        if (auth()->user()->id === 1) {

            return $query;
        }

        return $query->whereNot('id', 1);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
            'edit-permission' => EditUserPermission::route('/{record}/edit/permission'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'firstname', 'email'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        /** @var User $record */
        return [__('app.users.global_search.email') => $record->email];
    }
}
