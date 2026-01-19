<?php

namespace App\Filament\Resources\Members\Actions;

use App\Filament\Resources\Members\Schemas\Components\MemberFields;
use App\Mails\ConfirmMemberCreated;
use Arr;
use Filament\Actions\Action;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class Approve extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'approve';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->successNotificationTitle(__('app.actions.approve.notification.success'));

        $this->failureNotificationTitle(__('app.actions.approve.notification.failed'));

        $this->label(__('app.actions.approve.label.button'));

        $this->color('success');

        $this->icon('phosphor-check');

        $this->fillForm(fn (Model $record): array => [
            'firstname' => $record->firstname,
            'name' => $record->name,
            'job' => $record->job,
            'phone' => $record->phone,
            'email' => $record->email,
            'member_type' => $record->member_type,
            'company_name' => $record->company_name,
            'company_activity' => $record->company_activity,
            'company_description' => $record->company_description,
            'company_street' => $record->company_street,
            'company_ext_street' => $record->company_ext_street,
            'company_postal_code' => $record->company_postal_code,
            'company_city' => $record->company_city,
            'company_website' => $record->company_website,
            'company_socials' => $record->company_socials,
            'has_discount' => false,
        ]);

        $this->schema([
            Section::make(__('app.members.form.tabs.member'))
                ->icon('phosphor-identification-badge')
                ->iconColor('primary')
                ->description(__('app.members.form.tabs.member_description'))
                ->schema([
                    Grid::make()
                        ->schema([
                            MemberFields::getAvatar()
                                ->columnSpan(1),
                            Group::make()
                                ->schema([
                                    MemberFields::getFirstName(),
                                    MemberFields::getName(),
                                ])
                                ->columnSpan(3),
                        ])
                        ->columns(4),
                    MemberFields::getJob(),
                    MemberFields::getPhone()
                        ->columnSpan(1),
                    MemberFields::getEmail()
                        ->columnSpan(1),
                ])
                ->collapsible(),
            Section::make(__('app.members.form.tabs.company'))
                ->icon('phosphor-building-office')
                ->iconColor('primary')
                ->description(__('app.members.form.tabs.company_description'))
                ->schema([
                    Grid::make()
                        ->schema([
                            MemberFields::getCompanyLogo()
                                ->columnSpan(1),
                            Group::make()
                                ->schema([
                                    MemberFields::getCompanyName(),
                                    MemberFields::getCompanyActivity(),
                                    MemberFields::getCompanyWebsite(),
                                ])
                                ->columnSpan(3),
                        ])
                        ->columns(4),
                    MemberFields::getCompanyDescription(),
                    Fieldset::make(__('app.members.form.label.address'))
                        ->schema([
                            MemberFields::getCompanyStreet()
                                ->columnSpan(1),
                            MemberFields::getCompanyExtStreet()
                                ->columnSpan(1),
                            MemberFields::getCompanyPostalCode()
                                ->columnSpan(1),
                            MemberFields::getCompanyCity()
                                ->columnSpan(1),
                        ])
                        ->columns(),
                ])
                ->collapsed(),
            Section::make(__('app.members.form.tabs.socials'))
                ->icon('phosphor-share-network')
                ->iconColor('primary')
                ->description(__('app.members.form.tabs.socials_description_approve'))
                ->schema([
                    MemberFields::getSocials(),
                ])
                ->collapsed(),
            Section::make(__('app.members.form.tabs.plans_description_approve'))
                ->icon('phosphor-tag')
                ->iconColor('primary')
                ->schema([
                    MemberFields::getPlan(),
                    MemberFields::getApplyDiscount()
                        ->hidden(fn (Model $record): bool => filled($record->onePlanSubscriptions->discount_rate)),
                    MemberFields::getMemberType(),
                    MemberFields::getOfficeRole(),
                ])
                ->collapsed(fn (?Model $record): bool => filled($record->member_type)),
        ]);

        $this->action(function (array $data, Model $record): void {

            $data = Arr::add($data, 'is_draft', false);

            $result = $record->update($data);

            if (data_get($data, 'has_discount', false)) {
                $record->onePlanSubscriptions->update([
                    'discount_rate' => $data['discount_rate'],
                ]);
            }

            // send email au membre pour lui dire que son inscription est approuvée avec piece jointe RIB
            Mail::to($record->email, $record->getFullName())
                ->send(new ConfirmMemberCreated($data, $record));

            if (! $result) {
                $this->failure();

                return;
            }
            $this->success();
            $this->dispatch('refreshTableMembers');

        });

        $this->modalHeading(fn (Model $record): string => __('app.actions.approve.modal.heading', ['member' => $record->firstname.' '.$record->name]));

        $this->modalDescription(__('app.actions.approve.modal.description'));

        $this->modalSubmitActionLabel(__('app.actions.approve.label.submit'));

        $this->modalSubmitAction(fn (Action $action): Action => $action->color('success'));

        $this->extraModalFooterActions([
            Deapprove::make()
                ->cancelParentActions(),
        ]);

        $this->modalAutofocus(false);

        $this->slideOver();

        $this->visible(function (Model $record): bool {

            if (
                auth()->user()->can('Approve:Member')
                && $record->is_draft
            ) {
                return true;
            }

            return false;
        });

    }
}
