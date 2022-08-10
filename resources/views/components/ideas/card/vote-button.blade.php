@props([
    'voted' => false
])

<button type="button" {{ $attributes->class([
    'rounded-xl px-3 py-2 uppercase font-bold text-xs transition-colors',
    'bg-gray-200 hover:bg-gray-300 text-gray-700' => !$voted,
    'bg-purple-500 hover:bg-purple-400 text-white' => $voted,
]) }}>
    @if ($voted)
        Unvote
    @else
        Vote
    @endif
</button>
