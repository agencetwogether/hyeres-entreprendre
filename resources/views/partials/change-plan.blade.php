@php
    use App\Enums\IntervalPeriod;
@endphp
<div class="prose">
    @if($record->onePlanSubscriptions)
        <h4>
            @if($record->onePlanSubscriptions->discount_rate)
                {!! __('app.members.form.label.plan_type_label_discounted', ['name' => $record->onePlanSubscriptions->name, 'period' => $record->onePlanSubscriptions->plan->invoice_period, 'interval' => IntervalPeriod::from($record->onePlanSubscriptions->plan->invoice_interval)->getLabel(), 'price' => $record->onePlanSubscriptions->plan->price, 'currency' => $record->onePlanSubscriptions->plan->currency, 'discount_rate' => $record->onePlanSubscriptions->discount_rate->getLabel(), 'new_price' => $record->onePlanSubscriptions->plan->price * (1 - $record->onePlanSubscriptions->discount_rate->value / 100)]) !!}
            @else
                {{ __('app.members.form.label.plan_type_label', ['name' => $record->onePlanSubscriptions->name, 'period' => $record->onePlanSubscriptions->plan->invoice_period, 'interval' => IntervalPeriod::from($record->onePlanSubscriptions->plan->invoice_interval)->getLabel(), 'price' => $record->onePlanSubscriptions->plan->price, 'currency' => $record->onePlanSubscriptions->plan->currency]) }}
            @endif</h4>

        {{ $record->onePlanSubscriptions->starts_at->format('d/m/Y') }}
        - {{ $record->onePlanSubscriptions->ends_at->format('d/m/Y') }}
    @else
        <h4>{{ __('app.actions.change_plan.form.placeholder.no_plan') }}</h4>
    @endif
</div>
