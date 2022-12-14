<x-floating-window
    @close-create-comment-form="
        setOpened(false);
        scrollTo({top: document.body.scrollHeight, behavior: 'smooth'});
    "
    class="flex-1 max-w-[16rem]"
>
    <x-slot:button
        class="w-full px-4 py-2 rounded-xl bg-purple-500 text-white font-semibold hover:bg-purple-400 transition-colors sm:text-lg"
    >
        Reply
    </x-slot>

    <x-slot:window class="w-[24rem]">
        <form
            wire:submit.prevent="sendReply"
            class="flex flex-col gap-4"
        >
            <div>
                <x-textarea
                    wire:model.defer="body"
                    name="comment"
                    placeholder="Give your feedback on this idea..."
                />
                @error('body')
                    <x-forms.error>{{ $message }}</x-forms.error>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <x-input-file
                    id="reply-attachment"
                    class="flex-1"
                    name="attachment"
                />

                <x-submit-button class="flex-1">
                    Submit
                </x-submit-button>
            </div>
        </form>
    </x-slot>
</x-floating-window>
