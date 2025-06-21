@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'rounded-md shadow-xs border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200/5']) !!}>
