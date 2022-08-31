<x-app-layout>
    <a
        href="{{ $backUrl }}"
        class="text-lg font-bold hover:underline inline-flex items-center gap-2 mb-4"
    >
        <x-icon.chevron-left class="w-4 h-4" />
        <span>Back to all ideas</span>
    </a>

    <livewire:idea-show
        :idea="$idea"
        :votes-count="$votesCount"
        :voted="$voted"
    />
</x-app-layout>
