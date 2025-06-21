<form
    method="post"
    wire:submit="createIdea"
    x-data="{ attachment: null }"
>
    @csrf

    <div class="mb-4">
        <input
            wire:model="title"
            type="text"
            placeholder="Your idea"
            required
            class="py-2 px-4 shadow-none bg-gray-100 w-full rounded-xl border-none"
        />

        @error ('title')
            <x-forms.error>{{ $message }}</x-forms.error>
        @enderror
    </div>

    <div class="mb-4">
        <select
            wire:model="category"
            required
            class="w-full rounded-xl border-none bg-gray-100 text-gray-500 cursor-pointer"
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
        <x-textarea
            wire:model="description"
            name="description"
            :required="true"
            placeholder="Describe your data"
        />

        @error ('description')
            <x-forms.error>{{ $message }}</x-forms.error>
        @enderror
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <x-input-file
            id="create-idea-attachment"
            wire:model="attachment"
            @change="attachment = $event.target?.files?.[0]?.name"
        />
        <x-submit-button class="flex-1">Submit</x-submit-button>
    </div>

    <div
        x-show="attachment != null"
        class="mt-4 flex flex-wrap gap-2 items-center text-sm"
        x-cloak
    >
        <button
            type="button"
            @@click="
                attachment = null;
                $wire.attachment = null;
            "
            class="relative circle-background-hover"
        >
            <x-icon.x class="w-4 h-4 text-red-700" />
            <span class="sr-only">Remove attached file</span>
        </button>
        <span>Attached file: </span>
        <span class="text-gray-400 break-all" x-text="attachment"></span>
    </div>
</form>
