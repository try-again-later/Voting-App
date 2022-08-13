@props([
  'href'
])

<a
    href="{{ $href }}"
    {{ $attributes->class('block py-2 px-4 rounded-lg font-semibold transition-colors text-center') }}
>
    {{ $slot }}
</a>
