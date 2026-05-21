@props(['align' => 'right', 'width' => '48', 'contentClasses' => 'py-2 bg-surface'])

@php
switch ($align) {
    case 'left':
        $alignmentClasses = 'start-0 ltr:origin-top-left rtl:origin-top-right';
        break;
    case 'top':
        $alignmentClasses = 'origin-top';
        break;
    default:
        $alignmentClasses = 'end-0 ltr:origin-top-right rtl:origin-top-left';
        break;
}

switch ($width) {
    case '48':
        $widthClasses = 'w-48';
        break;
}
@endphp

<div class="relative" x-data="{ open: false }" @click.away="open = false" @close.stop="open = false">
    <div @click="open = ! open">
        {{ $trigger }}
    </div>

    <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute z-50 mt-2 {{ $alignmentClasses }} {{ $widthClasses }} rounded-xl glow-border shadow-2xl" style="display: none;" @click="open = false">
        <div class="{{ $contentClasses }}">
            {{ $content }}
        </div>
    </div>
</div>
