<div
    x-data="{ open: false }"
    @@edit:idea="open = true"
    @@update:idea="open = false"
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
        class="fixed z-100 bottom-0 left-1/2 -translate-x-1/2 bg-white max-h-[80vh] overflow-auto min-h-[25vh] min-w-[min(40rem,_90vw)] rounded-t-xl p-8"
        x-cloak
        x-transition:enter="transition delay-150 ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-16"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-16"
    >
        <div class="flex justify-end">
            <button
                @@click="open = false"
                class="p-1 rounded-full transition bg-gray-100 hover:bg-gray-200"
            >
                <x-icon.x class="text-red-500 w-6 h-6" />
                <span class="sr-only">Close</span>
            </button>
        </div>

        @isset($idea)
            <h3 class="text-center font-semibold text-xl break-all">
                Editing idea "{{ $idea->title }}"
            </h3>

            <p class="text-sm text-gray-400 text-center mt-2">You have one hour to edit your idea from the time you created it.</p>

            <form
                wire:submit.prevent="updateIdea"
                method="post"
                class="mt-8"
            >
                <div class="mb-4">
                    <label
                        class="px-4 text-sm text-gray-500"
                        for="edit-idea-title"
                    >
                        Title
                    </label>
                    <input
                        wire:model="title"
                        type="text"
                        placeholder="Your idea"
                        required
                        id="edit-idea-title"
                        class="py-2 px-4 mt-1 shadow-none bg-gray-100 w-full rounded-xl border-none"
                    />

                    @error ('title')
                        <x-forms.error>{{ $message }}</x-forms.error>
                    @enderror
                </div>

                <div class="mb-4">
                    <label
                        class="px-4 text-sm text-gray-500"
                        for="edit-idea-category"
                    >
                        Category
                    </label>
                    <select
                        wire:model="category"
                        required
                        id="edit-idea-category"
                        class="mt-1 w-full rounded-xl border-none bg-gray-100 text-gray-500 cursor-pointer"
                    >
                        <option value="none" disabled selected>Select a category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>

                    @error ('category')
                        <x-forms.error>{{ $message }}</x-forms.error>
                    @enderror
                </div>

                <div class="mb-4">
                    <label
                        class="px-4 text-sm text-gray-500"
                        for="edit-idea-description"
                    >
                        Description
                    </label>
                    <x-textarea
                        wire:model="description"
                        name="description"
                        :required="true"
                        :rows="8"
                        placeholder="Describe your data"
                        id="edit-idea-description"
                        class="mt-1"
                    />

                    @error ('description')
                        <x-forms.error>{{ $message }}</x-forms.error>
                    @enderror
                </div>

                <div class="flex justify-center">
                    <x-submit-button>Submit</x-submit-button>
                </div>
            </form>

        @endisset
    </div>
</div>
