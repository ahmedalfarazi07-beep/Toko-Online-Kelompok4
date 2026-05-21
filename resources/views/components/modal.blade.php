@props(['show' => false, 'maxWidth' => '2xl', 'closeable' => true])

@php
$maxWidthClasses = match ($maxWidth) {
    'sm' => 'max-w-sm',
    'md' => 'max-w-md',
    'lg' => 'max-w-lg',
    'xl' => 'max-w-xl',
    '2xl' => 'max-w-2xl',
    '3xl' => 'max-w-3xl',
    '4xl' => 'max-w-4xl',
    '5xl' => 'max-w-5xl',
    default => 'max-w-2xl',
};
@endphp

<div x-data="{ show: @js($show) }" x-init="$watch('show', value => { if (value) document.body.classList.add('overflow-y-hidden'); else document.body.classList.remove('overflow-y-hidden'); })" x-on:open-modal.window="$event.detail == '{{ $attributes->wire('model')->value ?? '' }}' ? show = true : null" x-on:close-modal.window="$event.detail == '{{ $attributes->wire('model')->value ?? '' }}' ? show = false : null" x-on:keydown.escape.window="{{ $closeable ? 'show = false' : '' }}" x-show="show" class="fixed inset-0 z-[100] overflow-y-auto" style="display: none;">
    <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black/60 backdrop-blur-sm"></div>

    <div class="flex min-h-full items-center justify-center p-4">
        <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 scale-95" x-transition:enter-end="opacity-100 translate-y-0 scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 scale-100" x-transition:leave-end="opacity-0 translate-y-4 scale-95" @click.away="{{ $closeable ? 'show = false' : '' }}" class="{{ $maxWidthClasses }} w-full backdrop-blur-xl bg-surface/95 border border-accent/20 rounded-2xl p-6 shadow-2xl">
            {{ $slot }}
        </div>
    </div>
</div>
