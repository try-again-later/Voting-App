<div>
    <section class="flex flex-wrap gap-4 mb-8">
        <h2 class="sr-only">Ideas filters</h2>

        <x-ideas.status-filters
            :status-filter="$this->statusFilter"
            :ideas-count-by-status="$this->ideasCountByStatus"
            class="w-full"
        />

        @if (!$this->noFiltersAreActive)
            <button
                wire:click="resetFilters"
                type="button"
                title="Reset all filters and go to first page"
                class="flex gap-2 items-center text-gray-600 group"
            >
                <span class="sm:sr-only">
                    Reset all filters and go to first page
                </span>
                <x-icon.backspace
                    class="w-8 h-8 text-gray-300 transition group-hover:text-gray-400 -order-1"
                    aria-hidden="true"
                />
            </button>
        @endif

        <select
            name="category-filter"
            @class([
                'border-none rounded-xl cursor-pointer w-full sm:w-auto',
                'ring-2 ring-purple-200' => $this->categoryFilter !== 'all',
                'ring-0' => $this->categoryFilter === 'all',
            ])
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
            @class([
                'border-none rounded-xl cursor-pointer w-full sm:w-auto',
                'ring-2 ring-purple-200' => $this->additionalFilter !== 'no-filter',
                'ring-0' => $this->additionalFilter === 'no-filter',
            ])
        >
            <option value="default" disabled class="text-gray-300">
                Additional filters
            </option>

            <option value="no-filter" selected>No filter</option>
            <option value="top-voted">Top voted</option>
            <option value="most-commented">Most commented</option>

            @auth
                <option value="my-ideas">My Ideas</option>
                <option value="voted-for">Ideas I voted for</option>
            @endauth
        </select>

        <div
            x-data
            @class([
                'flex flex-1 max-w-xl ml-auto',
                'ring-2 ring-purple-200 rounded-xl' => strlen($this->searchQuery) > 0,
                'ring-0' => strlen($this->searchQuery) === 0,
            ])
        >
            <div class="flex items-center bg-white pl-2 rounded-l-xl">
                <x-icon.search class="w-5 h-5 text-gray-700" />
            </div>
            <input
                wire:model.debounce.500ms="searchQuery"
                type="search"
                name="search"
                placeholder="Find an idea"
                class="border-none w-full pl-2 z-10 placeholder:italic placeholder:text-gray-400"
            />
            <div class="flex items-center bg-white rounded-r-xl px-2">
                <button
                    x-show="$wire.searchQuery !== ''"
                    x-cloak
                    @@click="$wire.searchQuery = ''"
                >
                    <span class="sr-only">Clear the search query</span>
                    <x-icon.x class="w-5 h-5 text-red-700" />
                </button>
            </div>
        </div>
    </section>

    <section class="flex flex-col gap-4 sm:gap-8">
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

        <livewire:edit-idea-form />

        <livewire:delete-idea-confirmation-modal />

        <div>
            {{ $ideas->links() }}
        </div>
    </section>
</div>
