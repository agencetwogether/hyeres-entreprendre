<?php

namespace App\Filament\Resources\Contacts\Pages;

use App\Filament\Resources\Contacts\ContactResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;

class ViewContact extends ViewRecord
{
    protected static string $resource = ContactResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('app.contacts.page.title_view', ['model' => $this->record->name]);
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->link()
                ->modalHeading(__('app.contacts.action.modal.delete_title', ['model' => $this->record->name]))
                ->successNotificationTitle(__('app.contacts.notification.deleted', ['model' => $this->record->name])),
        ];
    }
}
