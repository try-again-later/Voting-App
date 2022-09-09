@props([
    'comment',
])

<article
    {{-- @class([
        'flex gap-4 p-4 bg-white rounded-xl sm:ml-32 relative max-w-2xl ring-2 ring-gray-200',
        'before:hidden sm:before:block before:h-1 before:w-16 before:bg-gray-200 before:absolute before:-left-[5rem] before:top-1/2',
        'after:hidden sm:after:block after:w-1 after:bg-gray-200 after:absolute after:-left-[5rem] after:-bottom-8 after:top-0',
        'last:after:bottom-1/2 first:after:-top-4',
        'ring-status-open' => isset($comment->newIdeaStatus) && $comment->newIdeaStatus->name === 'open',
        'ring-status-in-progress' => isset($comment->newIdeaStatus) && $comment->newIdeaStatus->name === 'in-progress',
        'ring-status-implemented' => isset($comment->newIdeaStatus) && $comment->newIdeaStatus->name === 'implemented',
        'ring-status-considering' => isset($comment->newIdeaStatus) && $comment->newIdeaStatus->name === 'considering',
        'ring-status-closed' => isset($comment->newIdeaStatus) && $comment->newIdeaStatus->name === 'closed',
    ]) --}}

    class="
        flex gap-4 p-4 rounded-xl sm:ml-32 relative max-w-2xl ring-2
        before:hidden sm:before:block before:h-1 before:w-16 before:bg-gray-200 before:absolute before:-left-[5rem] before:top-1/2
        after:hidden sm:after:block after:w-1 after:bg-gray-200 after:absolute after:-left-[5rem] after:-bottom-8 after:top-0
        last:after:bottom-1/2 first:after:-top-4
        @isset ($comment->newIdeaStatus)
            @switch ($comment->newIdeaStatus->name)
                @case ('open')
                    ring-status-open
                    bg-gray-50
                    @break
                @case ('in-progress')
                    ring-status-in-progress
                    bg-yellow-50
                    @break
                @case ('implemented')
                    ring-status-implemented
                    bg-emerald-50
                    @break
                @case ('considering')
                    ring-status-considering
                    bg-indigo-50
                    @break
                @case ('closed')
                    ring-status-closed
                    bg-rose-50
                    @break
            @endswitch
        @else
            ring-gray-200
            bg-white
        @endisset
    "
>
    @isset ($comment->newIdeaStatus)
        <div class="
            absolute z-10 bg-white shadow-sm rounded-full w-12 h-12 top-1/2 -left-[5rem]
            -translate-y-[1.375rem] -translate-x-[1.375rem]

            before:absolute before:left-1/2 before:top-1/2 before:-translate-x-1/2
            before:-translate-y-1/2 before:z-20 before:w-8 before:h-8 before:rounded-full

            @switch ($comment->newIdeaStatus->name)
                @case ('open')
                    before:bg-status-open
                    @break
                @case ('in-progress')
                    before:bg-status-in-progress
                    @break
                @case ('implemented')
                    before:bg-status-implemented
                    @break
                @case ('considering')
                    before:bg-status-considering
                    @break
                @case ('closed')
                    before:bg-status-closed
                    @break
            @endswitch
        ">
        </div>
    @endisset

    <div class="self-start flex flex-col gap-1 items-center">
        <x-ideas.card.avatar :src="$comment->author->avatar()" />

        @if ($comment->author->isAdmin())
            <div class="uppercase text-xs font-bold text-purple-500">Admin</div>
        @endif
    </div>

    <div class="flex flex-col gap-4 w-full">
        @isset ($comment->newIdeaStatus)
            <p class="text-xl font-semibold leading-4">
                Status changed to
                @switch ($comment->newIdeaStatus->name)
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

        @isset ($comment->body)
            <p>{{ $comment->body }}</p>
        @endisset

        <div class="flex flex-wrap gap-x-4 gap-y-1 items-center mt-auto">
            <div @class([
                'font-semibold w-full sm:w-auto',
                'text-purple-500' => $comment->author->isAdmin(),
                'text-gray-700' => !$comment->author->isAdmin(),
            ])>
                {{ $comment->author->name }}
            </div>
            <time datetime="{{ $comment->created_at }}">
                {{ $comment->created_at->diffForHumans() }}
            </time>
            <x-ideas.card.menu class="self-end ml-auto">
                <x-ideas.card.menu-item>
                    Mark as spam
                </x-ideas.card.menu-item>
            </x-ideas.card.menu>
        </div>
    </div>
</article>
