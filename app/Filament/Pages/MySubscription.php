<?php

namespace App\Filament\Pages;

use App\Filament\Resources\Members\Schemas\Components\MemberEntries;
use BackedEnum;
use Filament\Facades\Filament;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class MySubscription extends Page
{
    use InteractsWithFormActions;

    protected static string|null|BackedEnum $navigationIcon = 'phosphor-tag';

    protected static ?string $slug = 'mon-abonnement';

    protected string $view = 'filament.pages.my-subscription.my-subscription';

    public function getTitle(): string|Htmlable
    {
        return __('app.pages.my-subscription.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('app.pages.my-subscription.navigation_title');
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
                MemberEntries::getSectionCurrentSubscription(owner: true),
                MemberEntries::getSectionPastSubscriptions(),
            ]);
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
