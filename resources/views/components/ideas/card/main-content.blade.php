@props(['idea', 'avatarSrc', 'ideaLink', 'showPreview' => false])

<div {{ $attributes->class('grid grid-cols-[auto,_1fr] p-4 gap-y-4 gap-x-4 sm:gap-x-8') }}>
    <x-ideas.card.avatar :src="$avatarSrc" class="self-start" />

    <div class="flex flex-wrap gap-x-2 gap-y-4 items-start">
        <x-ideas.card.heading :href="$ideaLink" class="order-0 w-min flex-1">
            {{ $idea->title }}
        </x-ideas.card.heading>
        <x-ideas.card.status
            class="w-full text-center order-2 sm:ml-auto sm:w-auto sm:order-1"
            :href="$ideaLink"
            :status="$idea->status"
        />
        <x-ideas.card.menu class="order-1 ml-auto sm:ml-0 sm:order-2" />
    </div>

    <p @class([
        'flex flex-col gap-4 col-span-2 sm:col-start-2 sm:col-span-1',
        'line-clamp-5' => $showPreview,
    ])>
        {{ $idea->description }}
    </p>

    <x-ideas.card.footer :idea="$idea" :comments-count="42" class="col-span-2 mt-2" />
</div>
