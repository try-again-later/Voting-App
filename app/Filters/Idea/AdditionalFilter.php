<?php

namespace App\Filters\Idea;

use App\Models\Idea;
use App\Models\Vote;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;

trait AdditionalFilter
{
    #[Url(as: 'filter', except: 'no-filter')]
    public string $additionalFilter = 'no-filter';

    public function updatingAdditionalFilter(string $newAdditionalFilter): void
    {
        $this->resetPage();

        if (
            !Auth::check() &&
            in_array($newAdditionalFilter, ['my-ideas', 'voted-for'], strict: true)
        ) {
            $this->redirect(route('login'));
        }
    }

    /**
     * @param Builder<Idea> $query
     */
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
            if ($this->additionalFilter === 'most-commented') {
                $query
                    ->orderByDesc('comments_count')
                    ->orderByDesc('ideas.id');
                return;
            }

            if ($this->additionalFilter === 'my-ideas') {
                $query
                    ->where('user_id', Auth::user()->id);
                return;
            }

            if ($this->additionalFilter === 'voted-for') {
                $query
                    ->whereIn('ideas.id', Vote::select('votes.idea_id')
                        ->where('votes.user_id', Auth::id())
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
