<button
    type="button"
    {{ $attributes->class([
        'block py-1.5 hover:bg-gray-100 bg-white transition-colors ring-gray-300 ring-1 border-b-[1px] first:rounded-t-md last:rounded-b-md last:border-b-0',
    ]) }}
>
    {{ $slot }}
</button>
