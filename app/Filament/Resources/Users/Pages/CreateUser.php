<?php

namespace App\Filament\Resources\Users\Pages;

use App\Events\CreateUser as CreateUserEvent;
use App\Filament\Resources\Users\Schemas\Components\UserFields;
use App\Filament\Resources\Users\UserResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\HtmlString;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected static bool $canCreateAnother = false;

    public function getTitle(): string
    {
        return __('app.users.page.title_create');
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return __('app.users.actions.add.notification.success', ['name' => $this->record->getFilamentName()]);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['force_renew_password'] = true;

        return $data;
    }

    protected function getCreateFormAction(): Action
    {
        return parent::getCreateFormAction()
            ->label(__('app.users.actions.add.label.submit'))
            ->schema([
                UserFields::getFieldSendEmail()
                    ->label(__('app.users.form.label.yes_send_email_after_create')),
            ])
            ->modalHeading(__('app.users.actions.add.modal.heading'))
            ->modalDescription(new HtmlString(__('app.users.actions.add.modal.description')))
            ->modalSubmitActionLabel(__('app.users.actions.add.label.submit'))
            ->action(fn () => $this->create());
    }

    protected function afterCreate(): void
    {
        $action = $this->getMountedAction();
        if ($action->getName() === 'create') {

            $dataForm = $this->form->getState();
            $dataModal = $action->getData();

            if ($dataModal['sendEmail']) {
                CreateUserEvent::dispatch($this->record, $dataForm['password']);
            }
        }
    }
}
