@props([
    'first' => false,
    'last' => false,
])

<button
    type="button"
    {{ $attributes->class([
        'block py-1.5 hover:bg-gray-200 bg-gray-100 transition-colors border-gray-300',
        'border-b-[1px]' => !$last,
        'rounded-t-md' => $first,
        'rounded-b-md' => $last,
    ]) }}
>
    {{ $slot }}
</button>
