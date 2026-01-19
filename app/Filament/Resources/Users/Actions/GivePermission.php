<?php

namespace App\Filament\Resources\Users\Actions;

use App\Filament\Resources\Users\Pages\EditUserPermission;
use Filament\Actions\Action;
use Illuminate\Database\Eloquent\Model;

class GivePermission extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'give-permission';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('app.users.actions.give-permission.label.button'));

        $this->icon('heroicon-m-key');

        $this->color('warning');

        $this->url(fn (Model $record): string => EditUserPermission::getUrl([$record]));

        $this->visible(auth()->user()->can('UpdateCustomPermission:User'));
    }
}
