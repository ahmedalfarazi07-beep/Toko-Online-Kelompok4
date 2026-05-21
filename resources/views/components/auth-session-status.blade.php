@props(['status'])
@if ($status)
    <div {{ $attributes->merge(['class' => 'text-sm text-green-400 bg-green-500/10 border border-green-500/20 rounded-xl px-4 py-3']) }}>
        {{ $status }}
    </div>
@endif
