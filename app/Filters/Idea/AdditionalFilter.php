<?php

namespace App\Filters\Idea;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;

trait AdditionalFilter
{
    public string $additionalFilter = 'no-filter';

    public function updatingAdditionalFilter(string $newAdditionalFilter)
    {
        if (method_exists(self::class, 'resetPage')) {
            $this->resetPage();
        }
        if (method_exists(self::class, 'redirect')) {
            if (!auth()->check() && $newAdditionalFilter === 'my-ideas') {
                $this->redirect(route('login'));
            }
        }
    }

    public function applyAdditionalFilter(Builder $query): ?RedirectResponse
    {
        if (!$this->isAdditionalFilterActive()) {
            $query
                ->orderByDesc('ideas.created_at')
                ->orderByDesc('ideas.id');
        }

        $query->when($this->isAdditionalFilterActive(), function (Builder $query) {
            if ($this->additionalFilter === 'top-voted') {
                $query
                    ->orderByDesc('votes_count')
                    ->orderByDesc('ideas.id');
                return;
            }

            if ($this->additionalFilter === 'my-ideas') {
                $query
                    ->where('user_id', auth()->user()->id);
            }
        });

        return null;
    }

    public function resetAdditionalFilter(): void
    {
        $this->additionalFilter = 'no-filter';
    }

    public function isAdditionalFilterActive(): bool
    {
        return $this->additionalFilter !== 'no-filter';
    }
}
