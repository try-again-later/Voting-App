<?php

namespace App\Filters\Idea;

use Illuminate\Database\Eloquent\Builder;

trait StatusFilter
{
    public string $statusFilter = 'all';

    public function setStatusFilter(string $newStatusFilter): void
    {
        $this->statusFilter = $newStatusFilter;
        if (method_exists(self::class, 'resetPage')) {
            $this->resetPage();
        }
    }

    public function applyStatusFilter(Builder $query): void
    {
        $query->when($this->isStatusFilterActive(), function (Builder $query) {
            $query
                ->join('statuses', 'ideas.status_id', '=', 'statuses.id')
                ->where('statuses.name', $this->statusFilter);
        });
    }

    public function resetStatusFilter(): void
    {
        $this->statusFilter = 'all';
    }

    public function isStatusFilterActive(): bool
    {
        return $this->statusFilter !== 'all';
    }
}
