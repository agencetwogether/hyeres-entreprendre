<div class="">
    <form wire:submit.prevent="create">
        <x-honeypot livewire-model="extraFields" />
        {{ $this->form }}
        <div class="mt-8 w-full px-3 text-center">
            <button wire:loading.attr="disabled" wire:target="create" type="submit"
                class="group inline-flex rounded-2xl py-4 px-7 text-center text-sm font-extrabold uppercase transition duration-300 items-center justify-center gap-4 bg-primary dark:bg-primary-800 text-white hover:bg-primary-400 dark:hover:bg-primary-700 hover:text-white dark:text-white">
                <div wire:loading wire:target="create">
                    <svg class="-ml-1 mr-3 h-5 w-5 animate-spin text-white" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                </div>
                {{ __('app.pages.contact-page.submit') }}
            </button>
            @if (session()->has('successContactForm'))
                <div class="mt-6 rounded-sm bg-green-300 p-2 text-green-800">
                    {{ session('successContactForm') }}
                </div>
            @endif
        </div>
    </form>
</div>
