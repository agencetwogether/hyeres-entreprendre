<?php

namespace App\Filament\Resources\Contacts\Schemas;

use App\Filament\Resources\Contacts\Actions\ResendInvitation;
use App\Filament\Resources\Contacts\Actions\SendDocument;
use App\Filament\Resources\Contacts\Schemas\Components\ContactEntries;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;

class ContactInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make(fn (Model $record): string => __('app.contacts.form.section.title', ['date' => $record->created_at->translatedFormat('l j F Y - H:i')]))
                    ->description(__('app.contacts.form.section.description'))
                    ->icon('phosphor-envelope-simple')
                    ->iconColor('primary')
                    ->headerActions([
                        SendDocument::make(),
                    ])
                    ->schema([
                        ContactEntries::getCompleteName(),
                        ContactEntries::getEmail(),
                        ContactEntries::getPhone(),
                        ContactEntries::getCreatedAt(),
                        Fieldset::make(__('app.contacts.form.label.content'))
                            ->schema([
                                ContactEntries::getContent(),
                            ])
                            ->columnSpanFull(),
                        Fieldset::make(__('app.contacts.form.label.interested'))
                            ->visible(fn (Model $record): bool => (bool) $record->interested)
                            ->schema([
                                ContactEntries::getCompany(),
                                ContactEntries::getActivity(),
                                Fieldset::make(__('app.contacts.form.label.address'))
                                    ->schema([
                                        ContactEntries::getStreet(),
                                        ContactEntries::getStreetExt(),
                                        ContactEntries::getPostalCity(),
                                    ]),
                            ])
                            ->columnSpanFull(),
                    ])
                    ->columns(),
                Section::make(fn (?Model $record): string => __('app.contacts.form.section.title_response', ['date' => $record?->response_date?->translatedFormat('l j F Y - H:i')]))
                    ->description(__('app.contacts.form.section.description_response'))
                    ->icon('phosphor-chat-circle-text')
                    ->iconColor('warning')
                    ->headerActions([
                        ResendInvitation::make(),
                    ])
                    ->schema([
                        ContactEntries::getResponseDate(),
                        ContactEntries::getResponseSubject(),
                        ContactEntries::getResponseContent(),
                        ContactEntries::getStatus(),
                    ])
                    ->visible(fn (Model $record): bool => $record->response_sent),
            ]);
    }
}
