<?php

namespace App\Livewire;

use App\Filters\Idea\{AdditionalFilter, CategoryFilter, StatusFilter, SearchFilter};
use Livewire\Component;
use App\Models\{Idea, Vote};
use App\Services\CategoriesService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\WithPagination;

class IdeasList extends Component
{
    use WithPagination;
    use StatusFilter, SearchFilter, CategoryFilter, AdditionalFilter;

    public array $ideasCountByStatus = [
        'all' => 0,
        'open' => 0,
        'considering' => 0,
        'in-progress' => 0,
        'implemented' => 0,
        'closed' => 0,
    ];

    public function updateIdeasCounts()
    {
        $this->ideasCountByStatus = [
            ...$this->ideasCountByStatus,
            ...Idea::getCountsByStatuses(),
        ];
    }

    public function mount()
    {
        if (!Auth::check() && $this->additionalFilter === 'my-ideas') {
            $this->redirect(route('login'));
        }

        $this->updateIdeasCounts();
    }

    #[Computed]
    public function noFiltersAreActive()
    {
        return
            !$this->isStatusFilterActive() &&
            !$this->isSearchFilterActive() &&
            !$this->isCategoryFilterActive() &&
            !$this->isAdditionalFilterActive();
    }

    public function resetFilters()
    {
        $this->resetStatusFilter();
        $this->resetSearchFilter();
        $this->resetCategoryFilter();
        $this->resetAdditionalFilter();
    }

    public function render(CategoriesService $categories)
    {
        $ideas = Idea::query()
            ->with('user', 'category', 'status')
            ->withCount('votes')
            ->addSelect(['auth_user_vote_id' => Vote::select('id')
                ->where('user_id', Auth::id())
                ->whereColumn('idea_id', 'ideas.id')
                ->take(1)
            ]);

        $this->applyStatusFilter($ideas);
        $this->applySearchFilter($ideas);
        $this->applyCategoryFilter($ideas);
        $this->applyAdditionalFilter($ideas);

        return view('livewire.ideas-list', [
            'ideas' => $ideas
                ->simplePaginate(5)
                ->withPath(route('idea.index'))
                ->withQueryString(),
            'categories' => $categories->all(),
        ]);
    }
}
