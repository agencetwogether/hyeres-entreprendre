<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use STS\FilamentImpersonate\Actions\Impersonate;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    public function getTitle(): string
    {
        return __('app.users.page.title_edit', ['model' => $this->record->getFilamentName()]);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return __('app.users.actions.edit.notification.success', ['name' => $this->record->getFilamentName()]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Impersonate::make()
                ->outlined()
                ->record($this->record),
            DeleteAction::make()
                ->link()
                ->label(__('app.users.actions.delete.label.button'))
                ->modalHeading(__('app.users.actions.delete.modal.heading', ['name' => $this->record->getFilamentName()]))
                ->modalDescription(__('app.users.actions.delete.modal.description'))
                ->successNotificationTitle(__('app.users.actions.delete.notification.success', ['name' => $this->record->getFilamentName()]))
                ->visible(auth()->user()->id !== $this->record->id),
        ];
    }

    protected function getSaveFormAction(): Action
    {
        return parent::getSaveFormAction()
            ->label(__('app.users.actions.edit.label.submit'));
    }
}
