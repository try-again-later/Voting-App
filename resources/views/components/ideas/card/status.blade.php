@aware(['categoryButtonRedirect'])

@props(['status'])

<button
    x-data
    {{ $attributes->class([
        'block uppercase text-sm font-bold px-3 py-1 rounded-full transition-colors whitespace-nowrap',
        'bg-status-open text-status-text-open hover:bg-status-hover-open' => $status->name == 'open',
        'bg-status-in-progress text-status-text-in-progress hover:bg-status-hover-in-progress' => $status->name == 'in-progress',
        'bg-status-closed text-status-text-closed hover:bg-status-hover-closed' => $status->name == 'closed',
        'bg-status-implemented text-status-text-implemented hover:bg-status-hover-implemented' => $status->name == 'implemented',
        'bg-status-considering text-status-text-considering hover:bg-status-hover-considering' => $status->name == 'considering',
    ]) }}
    type="button"
    wire:click.prevent="$dispatch('update:status-filter', { statusFilter: '{{ addslashes($status->name) }}' })"
    @@click="scrollTo({top: 0, behavior: 'smooth'})"
>
    {{ $status->human_name }}
</button>
