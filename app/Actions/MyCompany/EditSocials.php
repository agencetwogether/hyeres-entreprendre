<?php

namespace App\Actions\MyCompany;

use App\Filament\Resources\Members\Schemas\Components\MemberFields;
use Filament\Actions\Action;
use Illuminate\Database\Eloquent\Model;

class EditSocials extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'editSocials';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->successNotificationTitle(__('app.actions.edit_socials.notification.success'));

        $this->failureNotificationTitle(__('app.actions.edit_socials.notification.failed'));

        $this->label(__('app.actions.edit_socials.label.button'));

        $this->color('warning');

        $this->icon('heroicon-m-pencil-square');

        $this->fillForm(fn (Model $record): array => [
            'company_socials' => $record->company_socials,
        ]);

        $this->schema([
            MemberFields::getSocials(),
        ]);

        $this->action(function (array $data, Model $record): void {
            $result = $record->update($data);
            if (! $result) {
                $this->failure();

                return;
            }
            $this->success();
        });

        $this->modalHeading(fn (Model $record): string => __('app.actions.edit_socials.modal.heading'));

        $this->modalDescription(__('app.actions.edit_socials.modal.description'));

        $this->modalSubmitActionLabel(__('app.actions.edit_socials.label.submit'));

        $this->modalSubmitAction(fn (Action $action): Action => $action->color('primary'));

        $this->link();

        $this->slideOver();

        $this->modalAutofocus(false);
    }
}
