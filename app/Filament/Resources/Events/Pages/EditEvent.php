<?php

namespace App\Filament\Resources\Events\Pages;

use App\Filament\Resources\Events\EventResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditEvent extends EditRecord
{
    protected static string $resource = EventResource::class;

    public function getTitle(): string
    {
        return __('app.events.page.title_edit', ['title' => $this->record->title]);
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->link()
                ->modalHeading(__('app.events.table.action.delete.modal.heading', ['title' => $this->record->title]))
                ->modalDescription(__('app.events.table.action.delete.modal.description'))
                ->successNotificationTitle(__('app.events.table.action.delete.modal.notification_success', ['title' => $this->record->title])),
        ];
    }

    protected function getSaveFormAction(): Action
    {
        return parent::getSaveFormAction()
            ->label(__('app.events.table.action.edit.submit'));
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return __('app.events.table.action.edit.notification_success');
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
