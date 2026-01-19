@props([
    'type' => 'danger',
])
@php
    $text_color = match ($type) {
        'info' => 'prose-headings:text-info-800 text-info-800 dark:prose-headings:text-info-500 dark:text-info-500',
        'success'
            => 'prose-headings:text-success-800 text-success-800 dark:prose-headings:text-success-500 dark:text-success-500',
        'warning'
            => 'prose-headings:text-warning-800 text-warning-800 dark:prose-headings:text-warning-500 dark:text-warning-500',
        default
            => 'prose-headings:text-danger-800 text-danger-800 dark:prose-headings:text-danger-500 dark:text-danger-500',
    };
    $bg_color = match ($type) {
        'info' => 'bg-info-100 border-info-200 dark:bg-info-800/10 dark:border-info-900',
        'success' => 'bg-success-100 border-success-200 dark:bg-success-800/10 dark:border-success-900',
        'warning' => 'bg-warning-100 border-warning-200 dark:bg-warning-800/10 dark:border-warning-900',
        default => 'bg-danger-100 border-danger-200 dark:bg-danger-800/10 dark:border-danger-900',
    };
@endphp
<div class="my-4 border rounded-lg p-4 {{ $bg_color }}" role="alert">
    <div class="prose max-w-none {{ $text_color }}">
        {{ $slot }}
    </div>
</div>
