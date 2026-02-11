<?php

namespace App\Filament\Resources\Members\Pages;

use App\Enums\MemberType;
use App\Filament\Resources\Members\MemberResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMember extends EditRecord
{
    protected static string $resource = MemberResource::class;

    public function getTitle(): string
    {
        return __('app.members.page.title_edit', ['name' => $this->record->company_name]);
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->link()
                ->modalHeading(__('app.members.table.action.delete.modal.heading', ['name' => $this->record->name]))
                ->modalDescription(__('app.members.table.action.delete.modal.description'))
                ->successNotificationTitle(__('app.members.table.action.delete.modal.notification_success', ['name' => $this->record->name])),
        ];
    }

    protected function getSaveFormAction(): Action
    {
        return parent::getSaveFormAction()
            ->label(__('app.members.table.action.edit.submit'));
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return __('app.members.table.action.edit.notification_success');
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if ($data['member_type'] != MemberType::OFFICE->value) {
            $data['office_role'] = null;
        }

        return $data;
    }

    protected function afterSave(): void
    {
        if (filled($user = $this->record->user)) {
            $user->update([
                'firstname' => $this->data['firstname'],
                'name' => $this->data['name'],
                'phone' => $this->data['phone'],
                'email' => $this->data['email'],
            ]);
        }
    }
}
