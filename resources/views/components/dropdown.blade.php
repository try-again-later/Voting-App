@props(['align' => 'right', 'width' => '48', 'contentClasses' => 'bg-white', 'wrapperClasses' => ''])

@php
switch ($align) {
    case 'left':
        $alignmentClasses = 'origin-top-left left-0';
        break;
    case 'top':
        $alignmentClasses = 'origin-top';
        break;
    case 'right':
    default:
        $alignmentClasses = 'origin-top-right right-0';
        break;
}

switch ($width) {
    case '48':
        $width = 'w-48';
        break;
}
@endphp

<div class="relative {{ $wrapperClasses }}" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
    <div @click="open = ! open" class="flex items-center">
        {{ $trigger }}
    </div>

    <div x-show="open"
        x-transition:enter="transition delay-150 ease-out duration-150"
        x-transition:enter-start="opacity-0 scale-75"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-75"
        class="absolute z-50 mt-2 {{ $width }} rounded-md {{ $alignmentClasses }} bg-white"
        style="display: none;"
        @click="open = false"
    >
        {{ $content }}
    </div>
</div>
