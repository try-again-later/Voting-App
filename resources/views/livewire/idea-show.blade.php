<div>
    @if ($showPreview)
        <article class="bg-white rounded-xl shadow-md flex flex-col min-h-[10rem] sm:flex-row">
            <div @class([
                'p-4 border-b-2 border-gray-200 flex flex-wrap flex-row items-center justify-start gap-1',
                'sm:border-r-2 sm:border-b-0 sm:flex-col',
                'text-purple-500' => $voted,
            ])>
                <div class="sm:text-2xl font-bold">{{ $votesCount }}</div>
                <div class="sm:min-w-[6rem] sm:text-center">Votes</div>
                <x-ideas.card.vote-button
                    wire:click.prevent="vote"
                    :voted="$voted"
                    class="mt-auto ml-auto sm:ml-0"
                />
            </div>

            <x-ideas.card.main-content
                class="w-full"
                :idea="$idea"
                :avatar-src="$this->avatarSrc"
                :idea-link="$this->ideaLink"
                :show-preview="true"
            />
        </article>
    @else
        <article class="bg-white rounded-xl shadow-md mb-4">
            <x-ideas.card.main-content
                class="w-full"
                :idea="$idea"
                :avatar-src="$this->avatarSrc"
                :idea-link="$this->ideaLink"
            />
        </article>

        <div class="flex flex-wrap gap-2">
            <x-floating-window class="flex-1 lg:max-w-[16rem]">
                <x-slot:button
                    class="w-full px-4 py-2 rounded-xl bg-purple-500 text-white font-semibold hover:bg-purple-400 transition-colors sm:text-lg"
                >
                    Reply
                </x-slot>

                <x-slot:window class="w-[24rem]">
                    <x-ideas.reply-form />
                </x-slot>
            </x-floating-window>

            @if (auth()->check() && auth()->user()->isAdmin())
                <x-floating-window class="flex-1 lg:max-w-[16rem]">
                    <x-slot:button class="w-full flex justify-center items-center gap-2 bg-gray-200 hover:bg-gray-300 transition-colors rounded-xl px-4 py-2 sm:text-lg">
                        <span class="whitespace-nowrap font-semibold">Set status</span>
                        <x-icon.chevron-down class="w-4 h-4" />
                    </x-slot>
                    <x-slot:window class="w-[24rem]" x-on:update:status="setOpened(false)">
                        <livewire:set-status-form :idea="$idea" />
                    </x-slot>
                </x-floating-window>
            @endif

            <div class="flex sm:justify-end sm:ml-auto flex-wrap w-full sm:w-auto gap-2">
                <div @class([
                    'flex flex-1 sm:flex-none items-center rounded-xl px-4 py-2 sm:ml-auto sm:text-lg justify-center transition-colors',
                    'bg-white text-gray-700' => !$voted,
                    'bg-purple-200 text-purple-700' => $voted,
                ])>
                    <span class="font-semibold">{{ $votesCount }}&nbsp;</span>votes
                </div>

                <x-ideas.card.vote-button
                    wire:click.prevent="vote"
                    :voted="$voted"
                    class="sm:w-min"
                />
            </div>
        </div>
    @endif
</div>
