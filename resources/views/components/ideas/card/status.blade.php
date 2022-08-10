@aware(['href', 'status'])

<a href="{{ $href }}" {{ $attributes->class([
    'block uppercase text-sm font-bold px-3 py-1 rounded-full transition-colors whitespace-nowrap',
    'bg-gray-200 text-gray-700 hover:bg-gray-300' =>
        strtolower($status) == 'open',
    'bg-yellow-400 text-white hover:bg-yellow-300' =>
        strtolower($status) == 'in-progress',
    'bg-red-400 text-white hover:bg-red-300' => strtolower($status) == 'closed',
    'bg-emerald-400 text-white hover:bg-emerald-300' =>
        strtolower($status) == 'implemented',
    'bg-indigo-400 text-white hover:bg-indigo-300' =>
        strtolower($status) == 'considering',
]) }}>
    {{ str_replace('-', ' ', $status) }}
</a>
