<?php

namespace App\Filters\Idea;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Url;

trait SearchFilter
{
    #[Url(as: 'q', except: '')]
    public string $searchQuery = '';

    public function setSearchQuery(string $newSearchQuery): void
    {
        $this->searchQuery = $newSearchQuery;
        if (method_exists(self::class, 'resetPage')) {
            $this->resetPage();
        }
    }

    public function applySearchFilter(Builder $query): void
    {
        $query->when($this->isSearchFilterActive(), function (Builder $query) {
            $searchQueryLowercase = mb_strtolower($this->searchQuery);
            $query->where(DB::raw('lower(title)'), 'like', "%$searchQueryLowercase%");
        });
    }

    public function resetSearchFilter(): void
    {
        $this->searchQuery = '';
    }

    public function isSearchFilterActive(): bool
    {
        return mb_strlen($this->searchQuery) >= 3;
    }

    public function updatingSearchQuery()
    {
        $this->resetPage();
    }
}
