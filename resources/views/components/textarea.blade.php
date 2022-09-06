@props([
    'name',
    'placeholder' => '',
    'value' => '',
    'required' => false,
    'rows' => 3,
])

<textarea
    name="{{ $name }}"
    rows="{{ $rows }}"
    placeholder="{{ $placeholder }}"
    {{ $attributes->class('resize-none w-full border-none bg-gray-100 rounded-xl px-4') }}
    @if ($required) required @endif
>{{ $value }}</textarea>
