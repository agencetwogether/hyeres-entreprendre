<x-filament-forms::field-wrapper :id="$getId()" :label="$getLabel()" :label-sr-only="$isLabelHidden()" :helper-text="$getHelperText()"
    :hint="$getHint()" :hint-icon="$getHintIcon()" :required="$isRequired()" :state-path="$getStatePath()">
    <div class="w-full h-full flex flex-col">
        <div class="w-full h-11 rounded-t-lg bg-gray-200 flex justify-start items-center space-x-1.5 px-3">
            <span class="w-3 h-3 rounded-full bg-red-400"></span>
            <span class="w-3 h-3 rounded-full bg-yellow-400"></span>
            <span class="w-3 h-3 rounded-full bg-green-400"></span>
        </div>
        <div class="bg-gray-100 border-t-0 w-full relative flex flex-col flex-1">
            <div class="bg-gray-50 border-t-0 w-full border-b-2">
                <div class="w-full mx-auto px-3">
                    <dl class="divide-y divide-gray-200">
                        <div class="py-2 flex justify-between">
                            <div class="flex items-center gap-3">
                                <dt class="text-sm font-medium leading-6 text-gray-900">
                                    {{ __('app.email_templates.preview.header_fake_email_client.from') }}</dt>
                                <dd class="text-sm leading-6 text-gray-700">{{ getAppEmailNameFrom() }}</dd>
                            </div>
                            @if ($sent)
                                <div class="flex items-center gap-3">
                                    <dt class="text-sm font-medium leading-6 text-gray-900">
                                        {{ __('app.email_templates.preview.header_fake_email_client.sent') }}</dt>
                                    <dd class="text-sm leading-6 text-gray-700">{{ $sent }}</dd>
                                </div>
                            @endif

                        </div>
                        <div class="py-2 flex gap-3 items-center">
                            <dt class="text-sm font-medium leading-6 text-gray-900">
                                {{ __('app.email_templates.preview.header_fake_email_client.to') }}</dt>
                            <dd class="text-sm leading-6 text-gray-700 flex flex-col sm:flex-row gap-2">
                                <x-filament::badge>
                                    {{ $to }}
                                </x-filament::badge>
                            </dd>
                        </div>
                        <div class="py-2 flex gap-3 items-center">
                            <dt class="text-sm font-medium leading-6 text-gray-900">
                                {{ __('app.email_templates.preview.header_fake_email_client.subject') }}</dt>
                            <dd class="text-sm leading-6 text-gray-700">{{ $subject }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <div class="flex-1">
                <iframe class="w-full h-full" srcdoc=" {{ $getState() }}" seamless frameborder="0"></iframe>
            </div>
        </div>
    </div>
</x-filament-forms::field-wrapper>
