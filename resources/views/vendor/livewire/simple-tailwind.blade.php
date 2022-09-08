<div x-data>
    @if ($paginator->hasPages())
        <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-between">
            <span>
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <x-pagination.button direction="previous" disabled />
                @else
                    @if(method_exists($paginator,'getCursorName'))
                        <x-pagination.button
                            direction="previous"
                            dusk="previousPage"
                            wire:click="setPage('{{$paginator->previousCursor()->encode()}}','{{ $paginator->getCursorName() }}')"
                            wire:loading.attr="disabled"
                        />
                    @else
                        <x-pagination.button
                            direction="previous"
                            wire:click="previousPage('{{ $paginator->getPageName() }}')"
                            wire:loading.attr="disabled"
                            dusk="previousPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}"
                        />
                    @endif
                @endif
            </span>

            <span>
                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    @if(method_exists($paginator,'getCursorName'))
                        <x-pagination.button
                            direction="next"
                            dusk="nextPage"
                            wire:click="setPage('{{$paginator->nextCursor()->encode()}}','{{ $paginator->getCursorName() }}')"
                            wire:loading.attr="disabled"
                        />
                    @else
                        <x-pagination.button
                            direction="next"
                            wire:click="nextPage('{{ $paginator->getPageName() }}')"
                            wire:loading.attr="disabled"
                            dusk="nextPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}"
                        />
                    @endif
                @else
                    <x-pagination.button direction="next" disabled />
                @endif
            </span>
        </nav>
    @endif
</div>
