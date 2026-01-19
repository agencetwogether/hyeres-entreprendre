@php
    use Illuminate\Support\HtmlString;
    $listInvoices = $getRecord()->onePlanSubscriptions->loadMissing('invoices');
@endphp

@if ($listInvoices->invoices->isNotEmpty())
    @php
        $filteredListInvoices = $listInvoices->invoices->where(
            'starts_at',
            '!=',
            $getRecord()->onePlanSubscriptions->starts_at,
        );
    @endphp
    @if ($filteredListInvoices->isNotEmpty())
        <ul>
            @foreach ($filteredListInvoices as $invoice)
                <li class="flex flex-col gap-3 px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="grid flex-1 gap-y-1">
                            <h3
                                class="fi-section-header-heading text-base font-semibold leading-6 text-gray-950 dark:text-white">
                                {{ __('app.pages.my-subscription.past-subscription.name', ['name' => $invoice->subscription->plan->name]) }}
                            </h3>
                            <p>{{ __('app.pages.my-subscription.past-subscription.period', ['from' => $invoice->starts_at->format('d/m/Y'), 'to' => $invoice->ends_at->format('d/m/Y')]) }}
                            </p>
                            @if ($invoice->discount_rate)
                                <p>{{ __('app.pages.my-subscription.past-subscription.amount') }} : <span
                                        class="line-through">{{ $invoice->amount }}
                                        {{ $invoice->subscription->plan->currency }}</span>
                                    {{ __('app.pages.my-subscription.past-subscription.discount') }}
                                    <span class="text-success-600">{{ $invoice->discount_rate->getLabel() }}</span>
                                    {{ __('app.pages.my-subscription.past-subscription.either') }}
                                    {{ $invoice->amount * (1 - $invoice->discount_rate->value / 100) }}
                                    {{ $invoice->subscription->plan->currency }}
                                </p>
                            @else
                            @endif
                            <p>
                                {{ new HtmlString(__('app.pages.my-subscription.past-subscription.payment_received', ['payment' => $invoice->payment_mode->getLabel(), 'date' => $invoice->payment_received_at->format('d/m/Y - H:i')])) }}
                            </p>
                        </div>

                        <div class="gap-3 flex flex-wrap items-center justify-start">
                            @livewire('generate-invoice', ['invoice' => $invoice])
                            @livewire('send-invoice', ['invoice' => $invoice])
                        </div>

                    </div>
                </li>
            @endforeach

        </ul>
    @else
        {{ __('app.pages.my-subscription.past-subscription.no-subscription') }}
    @endif
@else
    {{ __('app.pages.my-subscription.past-subscription.no-subscription') }}
@endif
