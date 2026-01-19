<?php

namespace App\Filament\Resources\Members;

use App\Filament\Resources\Members\Pages\CreateMember;
use App\Filament\Resources\Members\Pages\EditMember;
use App\Filament\Resources\Members\Pages\ListMembers;
use App\Filament\Resources\Members\Pages\ViewMember;
use App\Filament\Resources\Members\Schemas\MemberForm;
use App\Filament\Resources\Members\Schemas\MemberInfolist;
use App\Filament\Resources\Members\Tables\MembersTable;
use App\Filament\Resources\Members\Widgets\MemberStats;
use App\Models\Member;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class MemberResource extends Resource
{
    protected static ?string $model = Member::class;

    protected static ?string $slug = 'membres';

    protected static string|null|BackedEnum $navigationIcon = 'phosphor-users-three';

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'company_name';

    public static function getNavigationGroup(): ?string
    {
        return __('app.general.navigation.groups.site');
    }

    public static function getModelLabel(): string
    {
        return __('app.members.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('app.members.plural');
    }

    public static function getNavigationLabel(): string
    {
        return __('app.members.navigation');
    }

    public static function form(Schema $schema): Schema
    {
        return MemberForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return MemberInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MembersTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMembers::route('/'),
            'create' => CreateMember::route('/create'),
            'view' => ViewMember::route('/{record}'),
            'edit' => EditMember::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            MemberStats::class,
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'firstname', 'company_name'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            __('app.members.global_search.member') => $record->firstname.' '.$record->name,
        ];
    }

    public static function getGlobalSearchResultUrl(Model $record): string
    {
        return self::getUrl('view', ['record' => $record]);
    }
}
