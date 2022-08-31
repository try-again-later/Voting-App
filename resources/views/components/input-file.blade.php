@props([
  'id',
])

<div {{ $attributes->class('group') }}>
  <label
    for="{{ $id }}"
    class="flex items-center justify-center gap-1 px-1 py-2 bg-gray-100 text-sm font-semibold rounded-xl cursor-pointer hover:bg-gray-200 transition-colors group-focus-within:ring-2 ring-purple-500 ring-offset-2"
  >
    <x-icon.paper-clip class="w-6 h-6 text-gray-400" />
    <span>Attach</span>
  </label>
  <input
    type="file"
    id="{{ $id }}"
    class="sr-only"

    {{ $attributes->whereDoesntStartWith('class') }}
  />
</div>
