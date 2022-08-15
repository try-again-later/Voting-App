<x-app-layout>
    <div class="flex flex-wrap gap-4 mb-8">
        <select
            name="category-filter"
            class="border-none rounded-xl cursor-pointer w-full sm:w-auto"
        >
            <option value="default" selected disabled>Category</option>
            <option value="some-category">Some category</option>
            <option value="some-other-category">Some other category</option>
        </select>

        <select name="other-filter" class="border-none rounded-xl cursor-pointer w-full sm:w-auto">
            <option value="default" selected disabled>Other filters</option>
            <option value="the-other-filter">The other filter</option>
            <option value="something-else">Something else</option>
        </select>

        <div class="flex flex-1 max-w-xl ml-auto">
            <div class="flex items-center bg-white pl-2 rounded-l-xl">
                <x-icon.search class="w-5 h-5 text-gray-700" />
            </div>
            <input type="search" name="search" placeholder="Find an idea"
                class="border-none rounded-r-xl w-full pl-2" />
        </div>
    </div>

    <ul class="flex flex-col gap-4 sm:gap-8 mb-4">
        @foreach ($ideas as $idea)
            <li>
                <livewire:idea-show
                    :idea="$idea"
                    :show-preview="true"
                    :votes-count="$idea->votes_count"
                    :voted="isset($idea->auth_user_vote_id) ? true : false"
                />
            </li>
        @endforeach
    </ul>

    <div>
        {{ $ideas->links() }}
    </div>
</x-app-layout>
