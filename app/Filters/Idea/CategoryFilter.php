<?php

namespace App\Filters\Idea;

use App\Models\Idea;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Url;

trait CategoryFilter
{
    #[Url(as: 'category', except: 'all')]
    public string $categoryFilter = 'all';

    public function updatingCategoryFilter(): void
    {
        $this->resetPage();
    }

    public function setCategoryFilter(string $newCategoryFilter): void
    {
        $this->categoryFilter = $newCategoryFilter;
        $this->resetPage();
    }

    /**
     * @param Builder<Idea> $query
     */
    public function applyCategoryFilter(Builder $query): void
    {
        $query->when($this->isCategoryFilterActive(), function (Builder $query) {
            $query->where('category_id', $this->categoryFilter);
        });
    }

    public function resetCategoryFilter(): void
    {
        $this->categoryFilter = 'all';
    }

    public function isCategoryFilterActive(): bool
    {
        return $this->categoryFilter !== 'all';
    }
}
