@props([
    'voted' => false
])

<button type="button" {{ $attributes->class([
    'rounded-xl text-sm px-4 py-2 uppercase font-bold transition-colors sm:text-base',
    'bg-gray-200 hover:bg-gray-300 text-gray-700' => !$voted,
    'bg-purple-500 hover:bg-purple-400 text-white' => $voted,
]) }}>
    @if ($voted)
        Voted
    @else
        Vote
    @endif
</button>
