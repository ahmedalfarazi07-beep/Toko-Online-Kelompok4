@props(['active' => false, 'href' => '#'])
<a href="{{ $href }}" {{ $attributes->class(['block w-full px-4 py-2 text-sm font-medium transition-colors', 'text-highlight bg-accent/10' => $active, 'text-text-muted hover:text-white hover:bg-accent/5' => !$active]) }}>
    {{ $slot }}
</a>
