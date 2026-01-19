<x-filament::section icon="phosphor-info" icon-color="info" collapsible collapsed compact>
    <x-slot name="heading">
        {{ __('app.members.table.legend.heading') }}
    </x-slot>
    <div class="prose prose-sm max-w-full">
        <p>{{ __('app.members.table.legend.description') }}</p>
        <p>
            <span
                class="border-l-4! border-l-danger-600! dark:border-l-danger-500! hover:bg-danger-50! dark:hover:bg-danger-950! mr-2"></span>
            {{ __('app.members.table.legend.should_approved') }}
        </p>
        <p>
            <span
                class="border-l-4! border-l-warning-600! dark:border-l-warning-500! hover:bg-warning-50! dark:hover:bg-warning-950! mr-2"></span>
            {{ __('app.members.table.legend.should_paid') }}
        </p>
    </div>

</x-filament::section>
