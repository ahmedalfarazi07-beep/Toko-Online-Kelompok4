@props(['href' => '#'])
<a href="{{ $href }}" {{ $attributes->merge(['class' => 'block w-full px-4 py-2 text-start text-sm text-text-muted hover:text-white hover:bg-accent/10 transition-colors']) }}>
    {{ $slot }}
</a>
