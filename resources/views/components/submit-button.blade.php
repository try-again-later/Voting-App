<button
    type="submit"
    {{ $attributes->class('min-h-[2.5rem] bg-purple-500 hover:bg-purple-400 px-4 transition-colors text-white rounded-xl disabled:bg-gray-100 disabled:text-gray-400') }}
>
    {{ $slot }}
</button>
