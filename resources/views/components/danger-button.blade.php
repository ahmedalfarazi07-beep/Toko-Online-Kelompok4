@props(['disabled' => false])
<button {{ $disabled ? 'disabled' : '' }} {{ $attributes->merge(['class' => 'inline-flex items-center px-6 py-2.5 bg-red-600 hover:bg-red-500 text-white font-medium rounded-xl transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed']) }}>
    {{ $slot }}
</button>
