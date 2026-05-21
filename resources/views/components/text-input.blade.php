@props(['disabled' => false])
<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'w-full bg-dark-bg/50 border border-accent/30 rounded-xl px-4 py-2.5 text-white placeholder-gray-500 focus:border-accent focus:ring-2 focus:ring-accent/30 focus:outline-none transition-all duration-300']) !!}>
