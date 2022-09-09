<div
    x-data="{ open: false }"
    x-show="open"
    x-cloak
    x-transition:enter="transition-opacity ease-out duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-35"
    x-transition:leave="transition-opacity ease-in duration-300"
    x-transition:leave-start="opacity-35"
    x-transition:leave-end="opacity-0"
    @@open-delete-modal:idea="open = true"
    @@close-delete-modal:idea="open = false"
    @@click.self="open = false"
    @@keydown.escape.window="open = false"
    class="fixed px-4 left-0 top-0 right-0 min-h-screen bg-black bg-opacity-25 z-50 isolate grid place-items-center overflow-hidden"
>
    @isset($this->idea)
        <div
            x-show="open"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="
                grid gap-4 grid-cols-1 grid-rows-none
                sm:grid-cols-[repeat(4,_auto)] sm:grid-rows-[repeeat(3,_auto)]
                p-6 bg-white shadow-lg rounded-xl
                max-w-[40rem]
            "
        >
            <h3 class="sm:col-span-3 sm:text-start text-lg text-center font-semibold">
                Are you sure you want to delete idea "{{ $idea->title }}"?
            </h3>

            <x-icon.exclamation
                class="-order-1 justify-self-center sm:row-span-3 w-10 h-10 text-red-600 p-2 bg-red-200 rounded-full"
            />

            <p class="text-gray-400 text-center sm:text-start sm:col-span-3">
                This action cannot be undone.
            </p>

            <button
                wire:click="deleteIdea"
                class="justify-self-center bg-red-500 text-white font-bold px-4 py-1 rounded-lg transition hover:bg-red-400"
            >
                Delete
            </button>

            <button
                @@click="open = false"
                class="justify-self-center ring-1 text-gray-700 ring-gray-400 px-4 py-1 rounded-lg transition hover:bg-gray-200"
            >
                Cancel
            </button>
        </div>
    @endisset
</div>
