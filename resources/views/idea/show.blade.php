<x-app-layout>
    <a href="/" class="text-lg font-bold hover:underline inline-flex items-center gap-2 mb-4">
        <x-icon.chevron-left class="w-4 h-4" />
        <span>Back to all ideas</span>
    </a>

    <x-ideas.card
        title="{{ $idea->title }}"
        :description="[
            $idea->description,
        ]"
        :category="$idea->category->name"
        :votesCount="12"
        :voted="true"
        :commentsCount="6"
        :status="$idea->status"
        :href="route('idea.show', $idea)"
        :time="$idea->created_at->diffForHumans()"
        :datetime="$idea->created_at"
        :author="$idea->user->name"
        :avatar-src="$idea->user->avatar()"
    />
</x-app-layout>
