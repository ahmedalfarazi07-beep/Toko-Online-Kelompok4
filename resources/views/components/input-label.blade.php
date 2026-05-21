@props(['value', 'for' => null])
<label for="{{ $for }}" {{ $attributes->merge(['class' => 'block text-sm font-medium text-text-muted']) }}>
    {{ $value ?? $slot }}
</label>
