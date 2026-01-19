<?php

namespace App\Filament\Resources\Categories\Pages;

use App\Filament\Resources\Categories\CategoryResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCategory extends EditRecord
{
    protected static string $resource = CategoryResource::class;

    public function getTitle(): string
    {
        return __('app.categories.page.title_edit', ['name' => $this->record->name]);
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->link()
                ->modalHeading(__('app.categories.table.action.delete.modal.heading', ['name' => $this->record->name]))
                ->modalDescription(__('app.categories.table.action.delete.modal.description'))
                ->successNotificationTitle(__('app.categories.table.action.delete.modal.notification_success', ['name' => $this->record->name])),
        ];
    }

    protected function getSaveFormAction(): Action
    {
        return parent::getSaveFormAction()
            ->label(__('app.categories.table.action.edit.submit'));
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return __('app.categories.table.action.edit.notification_success');
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
