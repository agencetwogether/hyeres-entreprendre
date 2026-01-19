<?php

namespace App\Filament\Resources\Members\Pages;

use App\Filament\Resources\Members\MemberResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMember extends ViewRecord
{
    protected static string $resource = MemberResource::class;

    public function getTitle(): string
    {
        return __('app.members.page.title_view', ['name' => $this->record->company_name]);
    }

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->label(__('app.members.table.action.edit.label'))
                ->link(),
        ];
    }
}
