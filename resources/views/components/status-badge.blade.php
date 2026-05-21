@props(['status' => 'pending'])

@php
    $classes = match ($status) {
        'pending' => 'bg-yellow-500/10 text-yellow-400 border border-yellow-500/30',
        'processing' => 'bg-blue-500/10 text-blue-400 border border-blue-500/30',
        'shipped' => 'bg-purple-500/10 text-purple-400 border border-purple-500/30',
        'delivered' => 'bg-green-500/10 text-green-400 border border-green-500/30',
        'cancelled' => 'bg-red-500/10 text-red-400 border border-red-500/30',
        default => 'bg-gray-500/10 text-gray-400 border border-gray-500/30',
    };

    $labels = [
        'pending' => 'Pending',
        'processing' => 'Diproses',
        'shipped' => 'Dikirim',
        'delivered' => 'Selesai',
        'cancelled' => 'Dibatalkan',
    ];
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold ' . $classes]) }}>
    <span class="w-1.5 h-1.5 rounded-full currentColor"></span>
    {{ $labels[$status] ?? ucfirst($status) }}
</span>
