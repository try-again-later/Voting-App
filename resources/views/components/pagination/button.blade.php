@props([
    'direction' => 'next',
])

<button
    type="button"
    title="{{ $direction === 'next' ? 'Next page' : 'Previous page' }}"
    @@click="scrollTo({top: 0, behavior: 'smooth'})"
    {{ $attributes->class('bg-purple-500 text-white rounded-full p-2 w-10 h-10 transition hover:bg-purple-400 disabled:bg-gray-200 disabled:text-gray-400') }}
>
    @if ($direction === 'next')
        <x-icon.chevron-right />
        <span class="sr-only">{!! __('pagination.next') !!}</span>
    @elseif ($direction === 'previous')
        <x-icon.chevron-left />
        <span class="sr-only">{!! __('pagination.previous') !!}</span>
    @endif
</button>
