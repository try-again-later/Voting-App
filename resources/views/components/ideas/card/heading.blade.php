@props([
  'href',
])

<h3 {{ $attributes->class("font-bold text-xl text-purple-500 underline hover:no-underline")}}>
  <a href="{{ $href }}" class="block">{{ $slot }}</a>
</h3>
