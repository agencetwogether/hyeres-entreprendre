<?php

namespace App\Filament\Resources\Members\Pages;

use App\Filament\Resources\Members\MemberResource;
use App\Filament\Resources\Members\Schemas\Components\MemberFields;
use App\Mails\ConfirmMemberCreatedBackEnd;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\CreateRecord\Concerns\HasWizard;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Mail;
use Laravelcm\Subscriptions\Models\Plan;

class CreateMember extends CreateRecord
{
    use HasWizard;

    protected static string $resource = MemberResource::class;

    protected static bool $canCreateAnother = false;

    public function getTitle(): string
    {
        return __('app.members.page.title_create');
    }

    protected function getCreateFormAction(): Action
    {
        return parent::getCreateFormAction()
            ->label(__('app.members.table.action.create.submit'));
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return __('app.members.table.action.create.notification_success');
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    public function form(Schema $schema): Schema
    {
        return parent::form($schema)
            ->schema([
                Wizard::make($this->getSteps())
                    ->startOnStep($this->getStartStep())
                    ->cancelAction($this->getCancelFormAction())
                    ->submitAction($this->getSubmitFormAction())
                    ->skippable($this->hasSkippableSteps())
                    ->contained(),
            ])
            ->columns(null);
    }

    protected function getSteps(): array
    {
        return [
            Step::make(__('app.members.form.tabs.member'))
                ->icon('phosphor-identification-badge')
                ->schema([
                    MemberFields::getUser(),
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
                        ->columnSpanFull()
                        ->columns(4),
                    MemberFields::getJob(),
                    MemberFields::getPhone()
                        ->columnSpan(1),
                    MemberFields::getEmail()
                        ->columnSpan(1),
                ])
                ->columns(),

            Step::make(__('app.members.form.tabs.company'))
                ->icon('phosphor-building-office')
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
                    MemberFields::getCompanyAddress(),
                ]),

            Step::make(__('app.members.form.tabs.socials'))
                ->icon('phosphor-share-network')
                ->schema([
                    MemberFields::getSocials(),
                ]),
            Step::make(__('app.members.form.tabs.plans_back'))
                ->icon('phosphor-bookmarks')
                ->schema([
                    MemberFields::getApplyDiscount(),
                    MemberFields::getPlans(),
                    MemberFields::getMemberType(),
                    MemberFields::getOfficeRole(),
                    MemberFields::getIsPublished(),
                    MemberFields::getSendMemberNotification(),
                ]),
        ];
    }

    protected function afterCreate(): void
    {
        // Subscribe to plan chosen
        $plan = Plan::find($this->data['plan_id']);

        $subscription = $this->record->newPlanSubscription($plan->name, $plan, Carbon::now()->startOfYear());

        // check if a discount have to apply
        $hasDiscount = $this->data['has_discount'];
        if ($hasDiscount) {
            $subscription->update([
                'discount_rate' => $this->data['discount_rate'],
            ]);
        }

        if ($this->data['send_notification']) {
            Mail::to($this->record->email, $this->record->getFullName())
                ->send(new ConfirmMemberCreatedBackEnd($this->data, $this->record));
        }
    }
}
