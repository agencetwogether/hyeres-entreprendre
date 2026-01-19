<?php

namespace App\Filament\Resources\Members\Schemas;

use App\Filament\Resources\Members\Schemas\Components\MemberEntries;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Schema;

class MemberInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                MemberEntries::getSectionCurrentSubscription(),
                MemberEntries::getSectionPastSubscriptions(),
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
