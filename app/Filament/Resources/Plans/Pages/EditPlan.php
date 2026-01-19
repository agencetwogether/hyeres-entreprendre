<?php

namespace App\Filament\Resources\Plans\Pages;

use App\Filament\Resources\Plans\PlanResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPlan extends EditRecord
{
    protected static string $resource = PlanResource::class;

    public function getTitle(): string
    {
        return __('app.plans.page.title_edit', ['name' => $this->record->name]);
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->link()
                ->modalHeading(__('app.plans.table.action.delete.modal.heading', ['name' => $this->record->name]))
                ->modalDescription(__('app.plans.table.action.delete.modal.description'))
                ->successNotificationTitle(__('app.plans.table.action.delete.modal.notification_success', ['name' => $this->record->name])),
        ];
    }

    protected function getSaveFormAction(): Action
    {
        return parent::getSaveFormAction()
            ->label(__('app.plans.table.action.edit.submit'));
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return __('app.plans.table.action.edit.notification_success');
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
