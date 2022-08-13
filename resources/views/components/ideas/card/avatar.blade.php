@props(['src'])

<img
    src="{{ $src }}"
    alt="Avatar"
    {{ $attributes->class('w-16 rounded-xl aspect-square bg-gray-100 grid place-items-center') }}
/>
