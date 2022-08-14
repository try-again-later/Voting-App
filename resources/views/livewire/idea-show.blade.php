<div>
    <article class="bg-white rounded-xl shadow-md grid grid-cols-[auto,_1fr] p-4 gap-4 mb-4">
        <x-ideas.card.avatar :src="$this->avatarSrc" class="self-start" />

        <div>
            <div class="flex flex-wrap gap-x-2 gap-y-4 items-start sm:items-center mb-4">
                <x-ideas.card.heading :href="$this->ideaLink" class="order-0 w-min flex-1">
                    {{ $this->idea->title }}
                </x-ideas.card.heading>
                <x-ideas.card.status
                    class="w-full text-center order-2 sm:ml-auto sm:w-auto sm:order-1"
                    :href="$this->ideaLink"
                    :status="$this->idea->status"
                />
                <x-ideas.card.menu class="order-1 ml-auto sm:ml-0 sm:order-2" />
            </div>

            <p class="flex flex-col gap-4">{{ $this->idea->description }}</p>
        </div>

        <x-ideas.card.footer :idea="$this->idea" :comments-count="42" class="col-span-2 mt-2" />
    </article>


    <div class="flex flex-wrap gap-2">
        <x-floating-window class="flex-1">
            <x-slot:button
                class="w-full px-4 py-2 rounded-xl bg-purple-500 text-white font-semibold hover:bg-purple-400 transition-colors sm:text-lg"
            >
                Reply
            </x-slot>

            <x-slot:window class="w-[24rem]">
                <x-ideas.reply-form />
            </x-slot>
        </x-floating-window>

        <x-floating-window class="flex-1">
            <x-slot:button class="w-full flex justify-center items-center gap-2 bg-gray-200 hover:bg-gray-300 transition-colors rounded-xl px-4 py-2 sm:text-lg">
                <span class="whitespace-nowrap font-semibold">Set status</span>
                <x-icon.chevron-down class="w-4 h-4" />
            </x-slot>
            <x-slot:window class="w-[24rem]">
                <x-ideas.set-status-form />
            </x-slot>
        </x-floating-window>

        <div class="flex sm:justify-end sm:flex-grow-[1] flex-wrap w-full sm:w-auto gap-2">
            <div class="flex flex-1 sm:flex-none items-center bg-white rounded-xl px-4 py-2 sm:ml-auto sm:text-lg justify-center">
                <span class="font-semibold">{{ $this->votesCount }}&nbsp;</span>votes
            </div>

            <x-ideas.card.vote-button :voted="$this->voted" class="sm:w-min" />
        </div>
    </div>
</div>
