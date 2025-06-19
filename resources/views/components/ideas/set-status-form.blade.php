<form>
    @csrf

    <div class="mb-8">
        @foreach ([
            ['open', 'text-gray-400'],
            ['considering', 'text-indigo-400'],
            ['in-progress', 'text-yellow-400'],
            ['implemented', 'text-emerald-400'],
            ['closed', 'text-red-400'],
        ] as [$status, $accent])
            <div class="mb-4 last:mb-0 flex items-center gap-2">
                <input
                    type="radio"
                    name="status"
                    value="{{ $status }}"
                    id="{{ $status }}"
                    class="{{ $accent }} border-0 bg-gray-200 h-6 w-6"
                />
                <label for="{{ $status }}">
                    {{ ucwords(str_replace('-', ' ', $status)) }}
                </label>
            </div>
        @endforeach
    </div>

    <x-textarea name="comment" placeholder="Add an update comment (optional)" class="mb-4" />

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
        <x-input-file
            class="flex-1"
            name="attachment"
        />

        <x-submit-button class="flex-1">Submit</x-submit-button>
    </div>

    <div class="flex items-center gap-2">
        <input
            type="checkbox"
            name="notify-all-voters"
            id="notify-all-voters"
            checked
            class="w-6 h-6 rounded-lg text-purple-500 border-purple-500 border-2"
        />
        <label for="notify-all-voters">Notify all voters</label>
    </div>
</form>
