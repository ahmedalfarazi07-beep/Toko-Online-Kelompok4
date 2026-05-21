@props([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
    'disabled' => false,
])

@php
    $base = 'inline-flex items-center justify-center font-medium rounded-xl transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-accent/50';

    $variants = [
        'primary' => 'bg-accent hover:bg-highlight text-white btn-glow',
        'outline' => 'border border-accent text-accent hover:bg-accent/10',
        'ghost' => 'text-accent hover:bg-accent/10',
    ];

    $sizes = [
        'sm' => 'px-3 py-1.5 text-sm',
        'md' => 'px-5 py-2.5 text-sm',
        'lg' => 'px-7 py-3 text-base',
    ];

    $classes = trim("{$base} {$variants[$variant]} {$sizes[$size]}");
@endphp

<button
    type="{{ $type }}"
    @disabled($disabled)
    {{ $attributes->merge(['class' => $classes]) }}
>
    {{ $slot }}
</button>
