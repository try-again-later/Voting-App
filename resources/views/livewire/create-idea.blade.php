<form
    method="post"
    wire:submit="createIdea"
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
        <x-submit-button class="col-1 sm:col-2">Submit</x-submit-button>
    </div>
</form>
