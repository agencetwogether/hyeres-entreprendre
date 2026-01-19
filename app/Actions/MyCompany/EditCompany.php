<?php

namespace App\Actions\MyCompany;

use App\Filament\Resources\Members\Schemas\Components\MemberFields;
use Filament\Actions\Action;
use Illuminate\Database\Eloquent\Model;

class EditCompany extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'editCompany';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->successNotificationTitle(__('app.actions.edit_company.notification.success'));

        $this->failureNotificationTitle(__('app.actions.edit_company.notification.failed'));

        $this->label(__('app.actions.edit_company.label.button'));

        $this->color('warning');

        $this->icon('heroicon-m-pencil-square');

        $this->fillForm(fn (Model $record): array => [
            'company_logo' => $record->getFirstMediaUrl('company_logo'),
            'company_name' => $record->company_name,
            'company_activity' => $record->company_activity,
            'company_description' => $record->company_description,
            'company_street' => $record->company_street,
            'company_ext_street' => $record->company_ext_street,
            'company_postal_code' => $record->company_postal_code,
            'company_city' => $record->company_city,
            'company_website' => $record->company_website,
        ]);

        $this->schema([
            MemberFields::getCompanyLogo(),
            MemberFields::getCompanyName(),
            MemberFields::getCompanyActivity(),
            MemberFields::getCompanyDescription(),
            MemberFields::getCompanyAddress(),
            MemberFields::getCompanyWebsite(),
        ]);

        $this->action(function (array $data, Model $record): void {
            $result = $record->update($data);
            if (! $result) {
                $this->failure();

                return;
            }
            $this->success();
        });

        $this->modalHeading(fn (Model $record): string => __('app.actions.edit_company.modal.heading'));

        $this->modalDescription(__('app.actions.edit_company.modal.description'));

        $this->modalSubmitActionLabel(__('app.actions.edit_company.label.submit'));

        $this->modalSubmitAction(fn (Action $action): Action => $action->color('primary'));

        $this->link();

        $this->slideOver();

        $this->modalAutofocus(false);
    }
}
