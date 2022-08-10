@props(['title', 'description', 'votesCount', 'category', 'commentsCount', 'status', 'href', 'time', 'datetime', 'author', 'voted' => false])

<article class="bg-white rounded-xl shadow-md flex flex-col min-h-[10rem] sm:flex-row">
    <div @class([
        'p-4 border-b-2 border-gray-200 flex flex-wrap flex-row items-center justify-start gap-1 sm:border-r-2 sm:border-b-0 sm:flex-col',
        'text-purple-500' => $voted,
    ])>
        <div class="sm:text-2xl font-bold">{{ $votesCount }}</div>
        <div class="sm:min-w-[6rem] sm:text-center">Votes</div>
        <x-ideas.card.vote-button :voted="$voted" class="mt-auto ml-auto sm:ml-0" />
    </div>
    <div>
        <div class="flex">
            <div class="py-4 pl-4">
                <x-ideas.card.avatar src="https://unsplash.it/400/400" />
            </div>
            <div class="flex-1 p-4">
                <div class="flex flex-wrap justify-between gap-3 mb-4 sm:items-center">
                    <x-ideas.card.heading :href="$href">{{ $title }}</x-ideas.card.heading>

                    <div class="flex flex-wrap gap-3 justify-end items-center">
                        <x-ideas.card.status />
                        <x-ideas.card.menu />
                    </div>
                </div>
                <p class="line-clamp-5">{{ $description }}</p>
            </div>
        </div>

        <x-ideas.card.footer class="px-4 pb-4" />
    </div>
</article>