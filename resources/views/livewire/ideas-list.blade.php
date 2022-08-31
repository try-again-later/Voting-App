<div>
    <section class="flex flex-wrap gap-4 mb-8">
        <h2 class="sr-only">Ideas filters</h2>

        <select
            name="category-filter"
            class="border-none rounded-xl cursor-pointer w-full sm:w-auto"
            wire:model="categoryFilter"
        >
            <option disabled class="text-gray-300">Select a category</option>
            <option value="all">All</option>

            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>

        <select
            wire:model="additionalFilter"
            name="other-filter"
            class="border-none rounded-xl cursor-pointer w-full sm:w-auto"
        >
            <option value="default" disabled class="text-gray-300">
                Additional filters
            </option>

            <option value="no-filter" selected>No filter</option>
            <option value="top-voted">Top Voted</option>

            @auth
                <option value="my-ideas">My Ideas</option>
            @endauth
        </select>

        <div class="flex flex-1 max-w-xl ml-auto">
            <div class="flex items-center bg-white pl-2 rounded-l-xl">
                <x-icon.search class="w-5 h-5 text-gray-700" />
            </div>
            <input
                wire:model.debounce.500ms="searchQuery"
                type="search"
                name="search"
                placeholder="Find an idea"
                class="border-none rounded-r-xl w-full pl-2"
            />
        </div>
    </section>

    <section class="flex flex-col gap-4 sm:gap-8 mb-4">
        <h2 class="sr-only">Ideas</h2>

        @forelse ($ideas as $idea)
            <livewire:idea-show
                :wire:key="$idea->id"
                :idea="$idea"
                :show-preview="true"
                :votes-count="$idea->votes_count"
                :voted="isset($idea->auth_user_vote_id) ? true : false"
            />
        @empty
            <div class="text-xl text-gray-400 italic min-h-[16rem] grid place-items-center">
                No ideas here...
            </div>
        @endforelse

        <div>
            {{ $ideas->links() }}
        </div>
    </section>
</div>
