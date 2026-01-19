<?php

namespace App\Filament\Resources\Contacts;

use App\Enums\StatusContact;
use App\Filament\Resources\Contacts\Pages\ListContacts;
use App\Filament\Resources\Contacts\Pages\ViewContact;
use App\Filament\Resources\Contacts\Schemas\ContactInfolist;
use App\Filament\Resources\Contacts\Tables\ContactsTable;
use App\Models\Contact;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?string $slug = 'contacts';

    protected static string|null|BackedEnum $navigationIcon = 'phosphor-envelope-simple';

    protected static ?int $navigationSort = 4;

    public static function getNavigationGroup(): ?string
    {
        return __('app.general.navigation.groups.site');
    }

    public static function getModelLabel(): string
    {
        return __('app.contacts.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('app.contacts.plural');
    }

    public static function getNavigationLabel(): string
    {
        return __('app.contacts.navigation_label');
    }

    private static function getCount(): ?string
    {
        return static::$model::where('status', StatusContact::CREATED)->count();
    }

    public static function getNavigationBadge(): ?string
    {

        return static::getCount() > 0 ? static::getCount() : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        return trans_choice('app.contacts.navigation_badge', static::getCount());
    }

    public static function infolist(Schema $schema): Schema
    {
        return ContactInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ContactsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListContacts::route('/'),
            'view' => ViewContact::route('/{record}'),
        ];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return Str::title($record->firstname.' '.$record->name);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'firstname', 'email'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            __('app.contacts.global_search.date') => $record->created_at->format('d/m/Y'),
        ];
    }
}
