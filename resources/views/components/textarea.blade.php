@props([
    'name',
    'placeholder' => '',
    'value' => '',
    'required' => false,
])

<textarea
    name="{{ $name }}"
    rows="3"
    placeholder="{{ $placeholder }}"
    {{ $attributes->class('resize-none w-full border-none bg-gray-100 rounded-xl') }}
    @if ($required) required @endif
>{{ $value }}</textarea>
