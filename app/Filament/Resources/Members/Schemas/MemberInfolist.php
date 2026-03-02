<?php

namespace App\Filament\Resources\Members\Schemas;

use App\Filament\Resources\Members\Schemas\Components\MemberEntries;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;

class MemberInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                MemberEntries::getSectionCurrentSubscription()
                    ->visible(fn (Model $record) => filled($record->onePlanSubscriptions)),
                MemberEntries::getSectionNoSubscription()
                    ->visible(fn (Model $record) => blank($record->onePlanSubscriptions)),
                MemberEntries::getSectionPastSubscriptions()
                    ->visible(fn (Model $record) => filled($record->onePlanSubscriptions)),
                Group::make()
                    ->schema([
                        MemberEntries::getSectionCompany(),
                        MemberEntries::getSectionMember(),
                    ])
                    ->columnSpanFull(),
                MemberEntries::getSectionSocials(),
            ]);
    }
}
