@if (session('error'))
    <div class="flex items-center p-4 mb-4 text-sm text-danger-900 border border-danger-300 rounded-lg bg-danger-50 dark:bg-danger-950 dark:text-danger-100 dark:border-danger-300"
        role="alert">
        <x-icon class="flex-shrink-0 inline w-4 h-4 me-3 self-start" name="phosphor-x" />
        <span class="sr-only">Info</span>
        <div class="flex flex-col gap-2">
            <span class="text-sm font-medium">{{ session('error')['title'] }}</span>
            <p class="text-sm">{{ session('error')['content'] }}</p>
            <a class="font-semibold hover:underline text-center text-primary-600 dark:text-primary-400"
                href="{{ session('error')['action']['url'] }}">{{ session('error')['action']['label'] }}</a>
        </div>
    </div>
@endif
