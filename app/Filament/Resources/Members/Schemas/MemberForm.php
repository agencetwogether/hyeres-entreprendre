<?php

namespace App\Filament\Resources\Members\Schemas;

use App\Filament\Resources\Members\Schemas\Components\MemberFields;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class MemberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Tabs')
                    ->tabs([
                        Tab::make(__('app.members.form.tabs.member'))
                            ->icon('phosphor-identification-badge')
                            ->columns()
                            ->schema([
                                MemberFields::getUser(),
                                Grid::make()
                                    ->schema([
                                        MemberFields::getAvatar()
                                            ->columnSpan(1),
                                        Group::make()
                                            ->schema([
                                                MemberFields::getFirstName(),
                                                MemberFields::getName(),
                                            ])
                                            ->columnSpan(3),
                                    ])
                                    ->columnSpanFull()
                                    ->columns(4),
                                MemberFields::getJob(),
                                MemberFields::getPhone()
                                    ->columnSpan(1),
                                MemberFields::getEmail()
                                    ->columnSpan(1),
                                MemberFields::getIsPublished(),
                            ]),
                        Tab::make(__('app.members.form.tabs.company'))
                            ->icon('phosphor-building-office')
                            ->schema([
                                Grid::make()
                                    ->schema([
                                        MemberFields::getCompanyLogo()
                                            ->columnSpan(1),
                                        Group::make()
                                            ->schema([
                                                MemberFields::getCompanyName(),
                                                MemberFields::getCompanyActivity(),
                                                MemberFields::getCompanyWebsite(),
                                            ])
                                            ->columnSpan(3),
                                    ])
                                    ->columns(4),
                                MemberFields::getCompanyDescription(),
                                MemberFields::getCompanyAddress(),
                            ]),
                        Tab::make(__('app.members.form.tabs.socials'))
                            ->icon('phosphor-share-network')
                            ->schema([
                                MemberFields::getSocials(),
                            ]),
                        Tab::make(__('app.members.form.tabs.member_type'))
                            ->icon('phosphor-tag')
                            ->schema([
                                MemberFields::getMemberType(),
                                MemberFields::getOfficeRole(),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
