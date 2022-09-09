<x-app-layout>
    <livewire:idea-show
        :idea="$idea"
        :votes-count="$votesCount"
        :voted="$voted"
        :back-url="$backUrl"
    />

    <livewire:edit-idea-form />

    <div class="mt-8 flex flex-col gap-8">
        @foreach ($idea->comments as $comment)
            <x-ideas.comment
                :comment="$comment"
            />
        @endforeach
    </div>

    <livewire:delete-idea-confirmation-modal :redirect-on-delete="$backUrl" />
</x-app-layout>
