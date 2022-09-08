<?php

namespace App\Filters\Idea;

use App\Models\Vote;
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
            if (
                !auth()->check() &&
                in_array($newAdditionalFilter, ['my-ideas', 'voted-for'], strict: true)
            ) {
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
                return;
            }

            if ($this->additionalFilter === 'voted-for') {
                $query
                    ->whereIn('ideas.id', Vote::select('votes.idea_id')
                        ->where('votes.user_id', auth()->id())
                    );
                return;
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
