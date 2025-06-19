@props([
    'userName',
    'time',
    'datetime',
    'comment' => null,
    'newStatus' => null,
    'isAdmin' => false,
])

<article
    @class([
        'flex gap-4 p-4 bg-white rounded-xl sm:ml-32 relative',
        'before:hidden sm:before:block before:h-1 before:w-16 before:bg-gray-200 before:absolute before:-left-[5rem] before:top-1/2',
        'after:hidden sm:after:block after:w-1 after:bg-gray-200 after:absolute after:-left-[5rem] after:-bottom-8 after:top-0',
        'last:after:bottom-1/2 first:after:-top-4',
        'ring-2 ring-purple-500' => $isAdmin,
    ])
>
    @isset ($newStatus)
        <div class="
            absolute z-10 bg-white shadow-sm rounded-full w-12 h-12 top-1/2 -left-[5rem]
            -translate-y-[1.375rem] -translate-x-[1.375rem]

            before:absolute before:left-1/2 before:top-1/2 before:-translate-x-1/2
            before:-translate-y-1/2 before:z-20 before:w-8 before:h-8 before:rounded-full

            @switch ($newStatus)
            @case ('open')
                before:bg-gray-300
                @break
            @case ('in-progress')
                before:bg-yellow-400
                @break
            @case ('implemented')
                before:bg-emerald-400
                @break
            @case ('considering')
                before:bg-indigo-400
                @break
            @case ('closed')
                before:bg-red-400
                @break
            @endswitch
        ">
        </div>
    @endisset

    <div class="self-start flex flex-col gap-1 items-center">
        <x-ideas.card.avatar src="https://unsplash.it/400/400" />

        @if ($isAdmin)
            <div class="uppercase text-xs font-bold text-purple-500">Admin</div>
        @endif
    </div>

    <div class="flex flex-col gap-4 w-full">
        @isset ($newStatus)
            <p class="text-xl font-semibold leading-4">
                Status changed to
                @switch ($newStatus)
                    @case ('open')
                        "Open"
                        @break
                    @case ('in-progress')
                        "In Progress"
                        @break
                    @case ('implemented')
                        "Implemented"
                        @break
                    @case ('considering')
                        "Under Consideration"
                        @break
                    @case ('closed')
                        "Closed"
                        @break
                    @default
                        "Unknown"
                @endswitch
            </p>
        @endisset

        @isset ($comment)
            <p>{{ $comment }}</p>
        @endisset

        <div class="flex flex-wrap gap-x-4 gap-y-1 items-center mt-auto">
            <div @class([
                'font-semibold w-full sm:w-auto',
                'text-purple-500' => $isAdmin,
                'text-gray-700' => !$isAdmin,
            ])>
                {{ $userName }}
            </div>
            <time datetime="{{ $datetime }}">{{ $time }}</time>
            <x-ideas.card.menu class="self-end ml-auto" />
        </div>
    </div>
</article>
