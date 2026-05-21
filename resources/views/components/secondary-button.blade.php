@props(['disabled' => false, 'type' => 'button'])
<button {{ $disabled ? 'disabled' : '' }} type="{{ $type }}" {{ $attributes->merge(['class' => 'inline-flex items-center px-6 py-2.5 border border-accent/30 text-text-muted hover:text-white hover:bg-accent/10 font-medium rounded-xl transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed']) }}>
    {{ $slot }}
</button>
