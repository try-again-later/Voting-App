@props([
  'filterName',
  'first' => false,
  'last' => false,
  'active' => false,
])

<div class="{{ $attributes['class'] }} group w-full sm:w-min">
  <button
    type="button"
    wire:click="setStatusFilter('{{ $filterName }}')"
    @class([
      'block mx-auto mb-4 px-3 uppercase font-bold transition-colors whitespace-nowrap text-center cursor-pointer',
      'text-gray-700' => $active,
      'text-gray-400 group-hover:text-gray-600' => !$active
    ])
  >
    {{ $slot }}
  </button>
  <div
    @class([
      'h-1.5 transition-colors w-full rounded-full sm:rounded-none',
      'lg:rounded-l-full' => $first,
      'lg:rounded-r-full' => $last,
      'bg-purple-500' => $active,
      'bg-gray-300 group-hover:bg-purple-400' => !$active
    ])
  >
  </div>
</div>
