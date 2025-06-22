<?php

namespace App\Filters\Idea;

use App\Models\Idea;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;

trait StatusFilter
{
    #[Url(as: 'status', except: 'all')]
    public string $statusFilter = 'all';

    /**
     * @param Builder<Idea> $query
     */
    public function applyStatusFilter(Builder $query): void
    {
        $query->when($this->isStatusFilterActive(), function (Builder $query) {
            $query
                ->join('statuses', 'ideas.status_id', '=', 'statuses.id')
                ->where('statuses.name', $this->statusFilter);
        });
    }

    #[On('update:status-filter')]
    public function handleStatusFilterUpdate(string $statusFilter): void
    {
        $this->statusFilter = $statusFilter;
        $this->resetPage();
    }

    public function resetStatusFilter(): void
    {
        $this->dispatch('update:status-filter', statusFilter: 'all');
    }

    public function isStatusFilterActive(): bool
    {
        return $this->statusFilter !== 'all';
    }
}
