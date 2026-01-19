<?php

namespace App\Filament\Resources\Contacts\Schemas\Components;

use Filament\Infolists\Components\TextEntry;
use Illuminate\Database\Eloquent\Model;
use Ysfkaya\FilamentPhoneInput\Infolists\PhoneEntry;

class ContactEntries
{
    public static function getCompleteName(): TextEntry
    {
        return TextEntry::make('complete_name')
            ->label(__('app.contacts.form.label.name'))
            ->state(fn (Model $record): string => $record->firstname.' '.$record->name);
    }

    public static function getEmail(): TextEntry
    {
        return TextEntry::make('email')
            ->label(__('app.contacts.form.label.email'))
            ->copyable()
            ->copyMessage(__('app.general.copy_email'));
    }

    public static function getPhone(): PhoneEntry
    {
        return PhoneEntry::make('phone')
            ->label(__('app.contacts.form.label.phone'));
    }

    public static function getCreatedAt(): TextEntry
    {
        return TextEntry::make('created_at')
            ->label(__('app.contacts.form.label.created_at'))
            ->date('l j F Y')
            ->badge()
            ->color('warning');
    }

    public static function getContent(): TextEntry
    {
        return TextEntry::make('content')
            ->label(__('app.contacts.form.label.content'))
            ->prose()
            ->markdown()
            ->hiddenLabel()
            ->columnSpanFull();
    }

    public static function getCompany(): TextEntry
    {
        return TextEntry::make('company')
            ->label(__('app.contacts.form.label.company'))
            ->inlineLabel();
    }

    public static function getActivity(): TextEntry
    {
        return TextEntry::make('activity')
            ->label(__('app.contacts.form.label.activity'))
            ->inlineLabel();
    }

    public static function getStreet(): TextEntry
    {
        return TextEntry::make('street')
            ->label(__('app.contacts.form.label.street'))
            ->hiddenLabel()
            ->columnSpanFull();
    }

    public static function getStreetExt(): TextEntry
    {
        return TextEntry::make('street_ext')
            ->label(__('app.contacts.form.label.street_ext'))
            ->hiddenLabel()
            ->columnSpanFull();
    }

    public static function getPostalCity(): TextEntry
    {
        return TextEntry::make('postal_code_and_city')
            ->state(fn (Model $record): string => $record->postal_code.' '.$record->city)
            ->label(__('app.contacts.form.label.postal_code'))
            ->hiddenLabel()
            ->columnSpanFull();
    }

    public static function getResponseDate(): TextEntry
    {
        return TextEntry::make('response_date')
            ->label(__('app.contacts.form.label.response_date'))
            ->date('l j F Y - H:i');
    }

    public static function getResponseSubject(): TextEntry
    {
        return TextEntry::make('response_subject')
            ->label(__('app.contacts.form.label.response_subject'));
    }

    public static function getResponseContent(): TextEntry
    {
        return TextEntry::make('response_content')
            ->label(__('app.contacts.form.label.response_content'))
            ->html();
    }

    public static function getStatus(): TextEntry
    {
        return TextEntry::make('status')
            ->badge();
    }
}
