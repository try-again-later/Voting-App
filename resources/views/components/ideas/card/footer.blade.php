@props(['idea', 'commentsCount'])

<div {{ $attributes->class('flex gap-y-1 flex-wrap text-gray-400 justify-end') }}>
    <div class="flex">
        <div class="text-gray-700 font-semibold">{{ $idea->user->name }}</div>
        <x-icon.mid-dot class="w-6 h-6 text-gray-300" />
    </div>
    <div class="flex">
        <time datetime="{{ $idea->created_at }}" class="whitespace-nowrap">
            {{ $idea->created_at->diffForHumans() }}
        </time>
        <x-icon.mid-dot class="w-6 h-6 text-gray-300" />
    </div>
    <div class="flex">
        <div class="whitespace-nowrap">{{ $idea->category->name }}</div>
        <x-icon.mid-dot class="w-6 h-6 text-gray-300" />
    </div>
    <div class="flex">
        <div class="whitespace-nowrap">
            <span class="font-bold">{{ $commentsCount }}</span> {{ Str::plural('comment', $commentsCount) }}
        </div>
        <x-icon.mid-dot class="w-6 h-6 text-gray-300 xl:hidden" />
    </div>
</div>
