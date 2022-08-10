@props([
  'href',
  'first' => false,
  'last' => false,
  'active' => false
])

<div {{ $attributes->merge(['class' => 'group w-full sm:w-min']) }}>
  <a
    href="{{ $href }}"
    @class([
      'block mb-4 px-4 uppercase font-bold transition-colors whitespace-nowrap text-center cursor-pointer',
      'text-gray-700' => $active,
      'text-gray-400 group-hover:text-gray-600' => !$active
    ])
  >
    {{ $slot }}
  </a>
  <div
    @class([
      'h-1.5 transition-colors w-full',
      'lg:rounded-l-full' => $first,
      'lg:rounded-r-full' => $last,
      'bg-purple-500' => $active,
      'bg-gray-300 group-hover:bg-purple-400' => !$active
    ])
  >
  </div>
</div>
