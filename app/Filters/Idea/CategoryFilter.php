<?php

namespace App\Filters\Idea;

use Illuminate\Database\Eloquent\Builder;

trait CategoryFilter
{
    public string $categoryFilter = 'all';

    public function setCategoryFilter(string $newCategoryFilter): void
    {
        $this->categoryFilter = $newCategoryFilter;
        if (method_exists(self::class, 'resetPage')) {
            $this->resetPage();
        }
    }

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
