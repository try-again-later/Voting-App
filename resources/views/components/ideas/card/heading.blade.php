@props([
  'href',
])

<h3 class="font-bold text-xl text-purple-500 underline hover:no-underline">
  <a href="{{ $href }}">{{ $slot }}</a>
</h3>
