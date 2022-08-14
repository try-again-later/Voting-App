@props(['idea', 'voted', 'votesCount'])

<article class="bg-white rounded-xl shadow-md flex flex-col min-h-[10rem] sm:flex-row">
    <div @class([
        'p-4 border-b-2 border-gray-200 flex flex-wrap flex-row items-center justify-start gap-1',
        'sm:border-r-2 sm:border-b-0 sm:flex-col',
        'text-purple-500' => $voted,
    ])>
        <div class="sm:text-2xl font-bold">{{ $votesCount }}</div>
        <div class="sm:min-w-[6rem] sm:text-center">Votes</div>
        <x-ideas.card.vote-button :voted="$voted" class="mt-auto ml-auto sm:ml-0" />
    </div>
    <div class="w-full flex flex-col justify-between p-4 gap-4">
        <div class="flex gap-4">
            <div>
                <x-ideas.card.avatar :src="$idea->user->avatar()" />
            </div>
            <div class="flex-1">
                <div class="flex flex-wrap gap-x-2 gap-y-4 items-start mb-4">
                    <x-ideas.card.heading
                        :href="route('idea.show', $idea->slug)"
                        class="order-0 w-min flex-1"
                    >
                        {{ $idea->title }}
                    </x-ideas.card.heading>

                    <x-ideas.card.status
                        class="w-full text-center order-2 sm:ml-auto sm:w-auto sm:order-1"
                        :href="route('idea.show', $idea->slug)"
                        :status="$idea->status"
                    />

                    <x-ideas.card.menu class="order-1 ml-auto sm:ml-0 sm:order-2" />
                </div>
                <p class="line-clamp-5">{{ $idea->description }}</p>
            </div>
        </div>

        <x-ideas.card.footer :idea="$idea" :comments-count="42" />
    </div>
</article>
