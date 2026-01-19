<?php

namespace App\Filament\Resources\Contacts\Tables;

use App\Filament\Resources\Contacts\Tables\Components\ContactColumns;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ContactsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                ContactColumns::getStatus(),
                ContactColumns::getCompleteName(),
                ContactColumns::getEmail(),
                ContactColumns::getPhone(),
                ContactColumns::getCreatedAt(),
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    DeleteAction::make()
                        ->modalHeading(fn (Model $record): string => __('app.contacts.action.modal.delete_title', ['model' => $record->name]))
                        ->successNotificationTitle(fn (Model $record): string => __('app.contacts.notification.deleted', ['model' => $record->name])),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
