@props(['active' => false, 'href' => '#'])
<a href="{{ $href }}" {{ $attributes->class(['inline-flex items-center px-3 py-2 text-sm font-medium rounded-xl transition-all duration-300', 'text-highlight bg-accent/10' => $active, 'text-text-muted hover:text-white hover:bg-accent/5' => !$active]) }}>
    {{ $slot }}
</a>
