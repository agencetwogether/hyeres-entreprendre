<?php

namespace App\Filament\Resources\Members\Actions;

use App\Enums\DiscountRate;
use App\Filament\Resources\Members\Schemas\Components\MemberFields;
use App\Mails\ChangedPlan;
use Filament\Actions\Action;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Text;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\View as ViewComponent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Laravelcm\Subscriptions\Models\Plan;

class ChangePlan extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'changePlan';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->successNotificationTitle(fn (Model $record): string => __('app.actions.change_plan.notification.success', ['member' => $record->getFullName()]));

        $this->failureNotificationTitle(__('app.actions.change_plan.notification.failed'));

        $this->label(__('app.actions.change_plan.label.button'));

        $this->color('gray');

        $this->icon('phosphor-repeat');

        $this->fillForm([
            'has_discount' => false,
            'discount_rate' => null,
        ]);

        $this->schema([
            Section::make(__('app.actions.change_plan.form.section.current_plan.title'))
                ->description(fn (Model $record): string => __('app.actions.change_plan.form.section.current_plan.description', ['member' => $record->firstname.' '.$record->name]))
                ->icon('phosphor-tag')
                ->iconColor('info')
                ->extraAttributes(['class' => 'fix-padding'])
                ->schema([
                    ViewComponent::make('partials.change-plan')
                        ->viewData(fn (Model $record): array => ['record' => $record]),
                ]),
            ViewComponent::make('partials.arrow'),
            Section::make(__('app.actions.change_plan.form.section.available_plans.title'))
                ->description(fn (Model $record): string => __('app.actions.change_plan.form.section.available_plans.description', ['member' => $record->firstname.' '.$record->name]))
                ->icon('phosphor-calendar-dots')
                ->iconColor('primary')
                ->extraAttributes(['class' => 'fix-padding'])
                ->schema([
                    Fieldset::make(__('app.actions.send_document.label.fieldset_discount'))
                        ->schema([
                            Text::make(__('app.actions.change_plan.form.placeholder.info_discount'))
                                ->color('neutral')
                                ->columnSpanFull(),
                            Radio::make('has_discount')
                                ->label(__('app.actions.send_document.label.has_discount'))
                                ->hiddenLabel()
                                ->boolean()
                                ->inline()
                                ->live(),
                            Select::make('discount_rate')
                                ->label(__('app.actions.send_document.label.discount_rate'))
                                ->native(false)
                                ->selectablePlaceholder(false)
                                ->options(DiscountRate::class)
                                ->requiredIfAccepted('has_discount')
                                ->validationMessages([
                                    'required_if_accepted' => __('app.actions.send_document.validation.discount_rate'),
                                ])
                                ->live()
                                ->visible(fn (Get $get): bool => $get('has_discount')),
                        ]),
                    MemberFields::getPlans(removeCurrentPlan: true)
                        ->hiddenLabel()
                        ->columns(1),
                ]),
        ]);

        $this->action(function (array $data, Model $record): void {

            $newPlan = Plan::find($data['plan_id']);
            $newPlanDiscount = data_get($data, 'discount_rate');
            $newPlanDiscount = $newPlanDiscount instanceof DiscountRate ? $newPlanDiscount->value : $newPlanDiscount;

            $subscription = $record->onePlanSubscriptions;
            $oldPlan = $subscription->plan;
            $oldPlanDiscount = $subscription->discount_rate instanceof DiscountRate ? $subscription->discount_rate->value : null;

            if ($data['has_discount']) {
                if (filled($data['discount_rate'])) {
                    if ($data['discount_rate'] instanceof DiscountRate) {
                        $discountRate = $data['discount_rate']->value;
                    } else {
                        $discountRate = (int) $data['discount_rate'];
                    }
                } else {
                    $discountRate = null;
                }
            } else {
                $discountRate = null;
            }
            // Change subscription plan
            $result = $subscription->changePlan($newPlan, $discountRate);

            Mail::to($record->email, $record->firstname.' '.$record->name)
                ->send(new ChangedPlan($record, $newPlan, $newPlanDiscount, $oldPlan, $oldPlanDiscount));

            // TODO
            /*
             * Voir s'il faut editer facture existante
             */

            if (! $result) {
                $this->failure();

                return;
            }
            $this->success();
        });

        // $this->requiresConfirmation();

        $this->modalHeading(fn (Model $record): string => __('app.actions.change_plan.modal.heading', ['member' => $record->firstname.' '.$record->name]));

        $this->modalDescription(__('app.actions.change_plan.modal.description'));

        $this->modalSubmitActionLabel(__('app.actions.change_plan.label.submit'));

        $this->modalSubmitAction(fn (Action $action): Action => $action->color('success'));

        $this->modalAutofocus(false);

        $this->slideOver();

        $this->visible(function (Model $record): bool {
            if (
                auth()->user()->can('ChangeSubscription:Member')
                && (
                    $record->onePlanSubscriptions?->active()
                    && ! $record->onePlanSubscriptions?->canceled()
                    && $record->onePlanSubscriptions?->payment_received_at === null
                )
            ) {
                return true;
            }

            return false;
        });
    }
}
