<form>
    @csrf

    <div class="mb-8">
        @foreach ([
            ['open', 'text-status-open', 'group-hover:bg-status-hover-open'],
            ['considering', 'text-status-considering', 'group-hover:bg-status-hover-considering'],
            ['in-progress', 'text-status-in-progress', 'group-hover:bg-status-hover-in-progress'],
            ['implemented', 'text-status-implemented', 'group-hover:bg-status-hover-implemented'],
            ['closed', 'text-status-closed', 'group-hover:bg-status-hover-closed'],
        ] as [$status, $textColor, $hoverColor])
            <div class="mb-4 last:mb-0 flex items-center gap-2 group w-fit">
                <input
                    type="radio"
                    name="status"
                    value="{{ $status }}"
                    id="{{ $status }}"
                    class="{{ $textColor }} {{ $hoverColor }} bg-white h-6 w-6 transition-colors cursor-pointer"
                />
                <label for="{{ $status }}" class="cursor-pointer">
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
