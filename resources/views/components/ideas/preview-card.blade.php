@props(['title', 'description', 'votesCount', 'category', 'commentsCount', 'status', 'href', 'time', 'datetime', 'voted' => false])

<article class="bg-white rounded-xl shadow-md flex flex-col min-h-[10rem] sm:flex-row">
    <div @class([
        'p-4 border-b-2 border-gray-200 flex flex-row items-center justify-start gap-1 sm:border-r-2 sm:border-b-0 sm:flex-col',
        'text-purple-500' => $voted,
    ])>
        <div class="sm:text-2xl font-bold">{{ $votesCount }}</div>
        <div class="min-w-[6rem] sm:text-center">Votes</div>
        <button type="button" @class([
            'mt-auto rounded-xl px-3 py-2 uppercase font-bold text-xs transition-colors ml-auto sm:ml-0',
            'bg-gray-200 hover:bg-gray-300 text-gray-700' => !$voted,
            'bg-purple-500 hover:bg-purple-400 text-white' => $voted,
        ])>
            @if ($voted)
                Unvote
            @else
                Vote
            @endif
        </button>
    </div>
    <div>
        <div class="flex">
            <div class="py-4 pl-4">
                <img src="https://unsplash.it/400/400" alt="Avatar" class="w-16 rounded-xl aspect-square" />
            </div>
            <div class="flex-1 p-4">
                <div class="flex flex-wrap justify-between gap-3 mb-4 sm:items-center">
                    <h3 class="font-bold text-xl text-purple-500 underline hover:no-underline">
                        <a href="{{ $href }}">{{ $title }}</a>
                    </h3>
                    <div class="flex flex-wrap gap-3 justify-end items-center">
                        <a href="{{ $href }}" @class([
                            'block uppercase text-sm font-bold px-3 py-1 rounded-full transition-colors whitespace-nowrap',
                            'bg-gray-200 text-gray-700 hover:bg-gray-300' =>
                                strtolower($status) == 'open',
                            'bg-yellow-400 text-white hover:bg-yellow-300' =>
                                strtolower($status) == 'in-progress',
                            'bg-red-400 text-white hover:bg-red-300' => strtolower($status) == 'closed',
                            'bg-emerald-400 text-white hover:bg-emerald-300' =>
                                strtolower($status) == 'implemented',
                            'bg-indigo-400 text-white hover:bg-indigo-300' =>
                                strtolower($status) == 'considering',
                        ])>
                            {{ str_replace('-', ' ', $status) }}
                        </a>
                        <x-dropdown>
                            <x-slot:trigger>
                                <button class="bg-gray-200 rounded-full px-2 hover:bg-gray-300 transition-colors">
                                    <x-icon.dots-horizontal class="w-6 h-6" />
                                </button>
                            </x-slot>
                            <x-slot:content>
                                <div class="flex flex-col">
                                    <button type="button" class="block py-1 hover:bg-gray-200">
                                        Mark as spam
                                    </button>
                                    <button type="button" class="block py-1 hover:bg-gray-200">
                                        Delete post
                                    </button>
                                </div>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </div>
                <p class="line-clamp-3">{{ $description }}</p>
            </div>
        </div>

        <div class="flex gap-y-1 flex-wrap text-gray-400 justify-end px-4 pb-4 gap-4 sm:gap-0">
            <time datetime="{{ $datetime }}" class="whitespace-nowrap">{{ $time }}</time>
            <x-icon.mid-dot class="w-6 h-6 text-gray-300 hidden sm:block" />
            <div class="whitespace-nowrap">{{ $category }}</div>
            <x-icon.mid-dot class="w-6 h-6 text-gray-300 hidden sm:block" />
            <div class="whitespace-nowrap">
                <span class="font-bold">{{ $commentsCount }}</span> comments
            </div>
        </div>
    </div>
</article>
