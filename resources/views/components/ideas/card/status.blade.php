@aware(['href', 'name', 'humanName'])

<a
    href="{{ $href }}"
    {{ $attributes->class([
        'block uppercase text-sm font-bold px-3 py-1 rounded-full transition-colors whitespace-nowrap',
        'bg-status-open text-status-text-open hover:bg-status-hover-open' => $name == 'open',
        'bg-status-in-progress text-status-text-in-progress hover:bg-status-hover-in-progress' => $name == 'in-progress',
        'bg-status-closed text-status-text-closed hover:bg-status-hover-closed' => $name == 'closed',
        'bg-status-implemented text-status-text-implemented hover:bg-status-hover-implemented' => $name == 'implemented',
        'bg-status-considering text-status-text-considering hover:bg-status-hover-considering' => $name == 'considering',
    ]) }}
>
    {{ $humanName }}
</a>
