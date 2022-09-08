<x-app-layout>
    <livewire:idea-show
        :idea="$idea"
        :votes-count="$votesCount"
        :voted="$voted"
        :back-url="$backUrl"
    />

    <livewire:edit-idea-form />

    <livewire:delete-idea-confirmation-modal redirect-on-delete="{{ $backUrl }}" />
</x-app-layout>
