@props(['src'])

<img
    src="{{ $src }}"
    alt="Avatar"
    {{ $attributes->class('w-16 rounded-xl aspect-square') }}
/>
