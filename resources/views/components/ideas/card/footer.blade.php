@aware(['author', 'datetime', 'time', 'category', 'commentsCount'])

<div {{ $attributes->class('flex gap-y-1 flex-wrap text-gray-400 justify-end') }}>
    <div class="flex">
        <div class="text-gray-700 font-semibold">{{ $author }}</div>
        <x-icon.mid-dot class="w-6 h-6 text-gray-300" />
    </div>
    <div class="flex">
        <time datetime="{{ $datetime }}" class="whitespace-nowrap">{{ $time }}</time>
        <x-icon.mid-dot class="w-6 h-6 text-gray-300" />
    </div>
    <div class="flex">
        <div class="whitespace-nowrap">{{ $category }}</div>
        <x-icon.mid-dot class="w-6 h-6 text-gray-300" />
    </div>
    <div class="flex">
        <div class="whitespace-nowrap">
            <span class="font-bold">{{ $commentsCount }}</span> comments
        </div>
        <x-icon.mid-dot class="w-6 h-6 text-gray-300 lg:hidden" />
    </div>
</div>
