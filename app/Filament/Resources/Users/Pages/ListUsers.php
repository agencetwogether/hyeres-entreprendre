<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\Actions\InviteUser;
use App\Filament\Resources\Users\UserResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    public function getTitle(): string
    {
        return __('app.users.page.title_list');
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label(__('app.users.actions.add.label.button'))
                ->outlined(),
            InviteUser::make(),
        ];
    }
}
