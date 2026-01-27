<?php

namespace App\Services;

use App\Enums\IntervalPeriod;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;
use Laravelcm\Subscriptions\Services\Period;

class PlanService
{
    public function getTextPlanDiscounted(Model $record): HtmlString
    {
        $newPrice = $record->plan->price * (1 - $record->discount_rate->value / 100);

        return new HtmlString(__('app.members.form.label.plan_type_label_discounted', ['name' => $record->name, 'period' => $record->plan->invoice_period, 'interval' => IntervalPeriod::from($record->plan->invoice_interval)->getLabel(), 'price' => $record->plan->price, 'currency' => $record->plan->currency, 'discount_rate' => $record->discount_rate->getLabel(), 'new_price' => $newPrice]));
    }

    public function getTextPlan(Model $record): HtmlString
    {
        return new HtmlString(__('app.members.form.label.plan_type_label', ['name' => $record->name, 'period' => $record->plan->invoice_period, 'interval' => IntervalPeriod::from($record->plan->invoice_interval)->getLabel(), 'price' => $record->plan->price, 'currency' => $record->plan->currency]));
    }

    public function calculateNewPeriod(string $invoice_interval = '', ?int $invoice_period = null, ?Carbon $start = null): array
    {
        if (empty($invoice_interval)) {
            $invoice_interval = $this->plan->invoice_interval;
        }

        if (empty($invoice_period)) {
            $invoice_period = $this->plan->invoice_period;
        }

        $period = new Period(
            interval: $invoice_interval,
            count: $invoice_period,
            start: $start ?? Carbon::now()
        );

        return [
            'starts_at' => $period->getStartDate(),
            'ends_at' => $period->getEndDate(),
        ];
    }
}
