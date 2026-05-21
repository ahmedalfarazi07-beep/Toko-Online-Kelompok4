@props(['disabled' => false])
<button {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'inline-flex items-center px-6 py-2.5 bg-accent hover:bg-highlight text-white font-medium rounded-xl transition-all duration-300 hover:shadow-[0_0_20px_rgba(124,58,237,0.4)] disabled:opacity-50 disabled:cursor-not-allowed']) !!}>
    {{ $slot }}
</button>
