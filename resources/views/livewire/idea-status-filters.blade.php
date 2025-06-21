<div class="flex flex-wrap gap-y-4 justify-center xl:justify-start mb-8 w-full">
    <x-ideas.filter-item
        filter-name="all"
        :active="$statusFilter == 'all'"
        :first="true"
    >
        All ideas ({{ $ideasCountByStatus['all'] }})
    </x-ideas.filter-item>

    <x-ideas.filter-item
        filter-name="open"
        :active="$statusFilter == 'open'"
    >
        Open ({{ $ideasCountByStatus['open'] }})
    </x-ideas.filter-item>

    <x-ideas.filter-item
        filter-name="considering"
        :active="$statusFilter == 'considering'"
    >
        Considering ({{ $ideasCountByStatus['considering'] }})
    </x-ideas.filter-item>

    <x-ideas.filter-item
        filter-name="in-progress"
        :active="$statusFilter == 'in-progress'"
        :last="true"
    >
        In progress ({{ $ideasCountByStatus['in-progress'] }})
    </x-ideas.filter-item>

    <x-ideas.filter-item
        filter-name="implemented"
        :active="$statusFilter == 'implemented'"
        :first="true"
        class="xl:ml-auto"
    >
        Implemented ({{ $ideasCountByStatus['implemented'] }})
    </x-ideas.filter-item>

    <x-ideas.filter-item
        filter-name="closed"
        :active="$statusFilter == 'closed'"
        :last="true"
    >
        Closed ({{ $ideasCountByStatus['closed'] }})
    </x-ideas.filter-item>
</div>
