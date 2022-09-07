<div class="flex flex-wrap gap-y-4 justify-center 2xl:justify-start {{ $class }}">
    <x-ideas.filter-item
        wire:click.prevent="setStatusFilter('all')"
        :active="$statusFilter == 'all'"
        :first="true"
    >
        All ideas ({{ $ideasCountByStatus['all'] }})
    </x-ideas.filter-item>

    <x-ideas.filter-item
        wire:click.prevent="setStatusFilter('open')"
        :active="$statusFilter == 'open'"
    >
        Open ({{ $ideasCountByStatus['open'] }})
    </x-ideas.filter-item>

    <x-ideas.filter-item
        wire:click.prevent="setStatusFilter('considering')"
        :active="$statusFilter == 'considering'"
    >
        Considering ({{ $ideasCountByStatus['considering'] }})
    </x-ideas.filter-item>

    <x-ideas.filter-item
        wire:click.prevent="setStatusFilter('in-progress')"
        :active="$statusFilter == 'in-progress'"
        :last="true"
    >
        In progress ({{ $ideasCountByStatus['in-progress'] }})
    </x-ideas.filter-item>

    <x-ideas.filter-item
        wire:click="setStatusFilter('implemented')"
        :active="$statusFilter == 'implemented'"
        class="xl:ml-auto"
        :first="true"
    >
        Implemented ({{ $ideasCountByStatus['implemented'] }})
    </x-ideas.filter-item>

    <x-ideas.filter-item
        wire:click="setStatusFilter('closed')"
        :active="$statusFilter == 'closed'"
        :last="true"
    >
        Closed ({{ $ideasCountByStatus['closed'] }})
    </x-ideas.filter-item>
</div>
