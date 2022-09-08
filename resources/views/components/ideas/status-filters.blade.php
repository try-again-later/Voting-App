@props([
    'statusFilter' => 'all',
    'ideasCountByStatus' => [
        'all' => 0,
        'open' => 0,
        'considering' => 0,
        'in-progress' => 0,
        'implemented' => 0,
        'closed' => 0,
    ],
    'redirect' => false,
])

<div {{ $attributes->class('flex flex-wrap gap-y-4 justify-center xl:justify-start') }}>
    <x-ideas.filter-item
        filter-name="all"
        :first="true"
    >
        All ideas ({{ $ideasCountByStatus['all'] }})
    </x-ideas.filter-item>

    <x-ideas.filter-item
        filter-name="open"
    >
        Open ({{ $ideasCountByStatus['open'] }})
    </x-ideas.filter-item>

    <x-ideas.filter-item
        filter-name="considering"
    >
        Considering ({{ $ideasCountByStatus['considering'] }})
    </x-ideas.filter-item>

    <x-ideas.filter-item
        filter-name="in-progress"
        :last="true"
    >
        In progress ({{ $ideasCountByStatus['in-progress'] }})
    </x-ideas.filter-item>

    <x-ideas.filter-item
        filter-name="implemented"
        :first="true"
        class="xl:ml-auto"
    >
        Implemented ({{ $ideasCountByStatus['implemented'] }})
    </x-ideas.filter-item>

    <x-ideas.filter-item
        filter-name="closed"
        :last="true"
    >
        Closed ({{ $ideasCountByStatus['closed'] }})
    </x-ideas.filter-item>
</div>
