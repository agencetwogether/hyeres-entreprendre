<?php

namespace App\Filament\Pages;

use App\Actions\MyCompany\EditCompany;
use App\Actions\MyCompany\EditManager;
use App\Actions\MyCompany\EditSocials;
// use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use App\Filament\Resources\Members\Schemas\Components\MemberEntries;
use BackedEnum;
use Filament\Facades\Filament;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Filament\Pages\Page;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class MyCompany extends Page
{
    use InteractsWithFormActions;

    protected static string|null|BackedEnum $navigationIcon = 'phosphor-building-office';

    protected static ?string $slug = 'mon-entreprise';

    protected string $view = 'filament.pages.my-company.my-company';

    public function getTitle(): string|Htmlable
    {
        return __('app.pages.my-company.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('app.pages.my-company.navigation_title');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return self::getAccess();
    }

    public static function canAccess(): bool
    {
        return self::getAccess();
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->record($this->getUser()->member)
            ->components([
                Group::make()
                    ->schema([
                        Section::make(__('app.members.infolist.section.company.title'))
                            ->description(__('app.members.infolist.section.company.description'))
                            ->icon('phosphor-building-office')
                            ->iconColor('primary')
                            ->headerActions([
                                EditCompany::make(),
                            ])
                            ->schema([
                                Grid::make(4)
                                    ->schema([
                                        MemberEntries::getCompanyLogo()
                                            ->imageSize('100%')
                                            ->columnSpan(1),
                                        Group::make()
                                            ->schema([
                                                MemberEntries::getCompanyName(),
                                                MemberEntries::getCompanyActivity(),
                                                MemberEntries::getCompanyDescription()
                                                    ->columnSpanFull(),
                                                MemberEntries::getCompanyAddress()
                                                    ->columnSpanFull(),
                                                MemberEntries::getCompanyWebsite(),
                                            ])
                                            ->columns()
                                            ->columnSpan(3),
                                    ]),
                                // MemberEntries::getIsPublished(),
                                // MemberEntries::getAccountCreated(),
                            ])
                            ->collapsible()
                            ->persistCollapsed(),
                        Section::make(__('app.members.infolist.section.member.title'))
                            ->description(__('app.members.infolist.section.member.description'))
                            ->icon('phosphor-identification-badge')
                            ->iconColor('primary')
                            ->headerActions([
                                EditManager::make(),
                            ])
                            ->schema([
                                Grid::make(4)
                                    ->schema([
                                        MemberEntries::getAvatar()
                                            ->columnSpan(1),
                                        Group::make()
                                            ->schema([
                                                MemberEntries::getName()
                                                    ->columnSpan(1),
                                                MemberEntries::getFirstName()
                                                    ->columnSpan(1),
                                                MemberEntries::getJob()
                                                    ->columnSpanFull(),
                                                MemberEntries::getPhone()
                                                    ->columnSpan(1),
                                                MemberEntries::getEmail()
                                                    ->columnSpan(1),
                                            ])
                                            ->columns()
                                            ->columnSpan(3),
                                    ]),
                            ])
                            ->collapsible()
                            ->persistCollapsed(),
                    ])
                    ->columnSpan(['lg' => 2]),

                Section::make(__('app.members.infolist.section.socials.title'))
                    ->description(__('app.members.infolist.section.socials.description'))
                    ->icon('phosphor-share-network')
                    ->iconColor('primary')
                    ->headerActions([
                        EditSocials::make(),
                    ])
                    ->schema([
                        MemberEntries::getSocials(),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    protected function getUser(): Authenticatable&Model
    {
        $user = Filament::auth()->user();

        if (! $user instanceof Model) {
            throw new Exception('The authenticated user object must be an Eloquent model to allow the profile page to update it.');
        }

        return $user;
    }

    private static function getAccess(): bool
    {
        return (bool) auth()->user()->member;
    }
}
