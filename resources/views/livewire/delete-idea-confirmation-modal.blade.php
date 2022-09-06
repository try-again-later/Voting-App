<div
    x-data="{ open: false }"
    @@open-delete-modal:idea="open = true"
    @@keydown.escape.window="open = false"
>
    <div
        x-show="open"
        @@click.self="open = false"
        class="fixed z-50 inset-0 bg-black/25 overflow-hidden"
        x-cloak
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    >
    </div>

    <div
        x-show="open"
        x-transition:enter="transition delay-150 ease-out duration-150"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="
            fixed z-100 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 overflow-auto

            grid gap-4 grid-cols-1 grid-rows-none
            sm:grid-cols-[repeat(4,_auto)] sm:grid-rows-[repeat(3,_auto)]
            p-6 bg-white shadow-lg rounded-xl
            max-w-[40rem]
        "
    >
        <h3 class="sm:col-span-3 sm:text-start text-lg text-center font-semibold">
            Are you sure you want to delete your idea?
        </h3>

        <x-icon.exclamation
            class="-order-1 justify-self-center sm:row-span-3 w-10 h-10 text-red-600 p-2 bg-red-200 rounded-full"
        />

        <p class="text-gray-400 text-center sm:text-start sm:col-span-3">
            This action cannot be undone.
        </p>

        <button class="justify-self-center bg-red-500 text-white font-bold px-4 py-1 rounded-lg transition hover:bg-red-400">
            Delete
        </button>

        <button
            @@click="open = false"
            class="justify-self-center ring-1 text-gray-700 ring-gray-400 px-4 py-1 rounded-lg transition hover:bg-gray-200"
        >
            Cancel
        </button>
    </div>
</div>
