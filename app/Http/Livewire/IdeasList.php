<?php

namespace App\Http\Livewire;

use App\Filters\Idea\{AdditionalFilter, CategoryFilter, StatusFilter, SearchFilter};
use Livewire\Component;
use App\Models\{Idea, Vote};
use App\Services\CategoriesService;
use Livewire\WithPagination;

class IdeasList extends Component
{
    use WithPagination;
    use IdeasCountByStatus;
    use StatusFilter, SearchFilter, CategoryFilter, AdditionalFilter;

    protected $queryString = [
        'statusFilter' => [
            'as' => 'status',
            'except' => 'all',
        ],
        'categoryFilter' => [
            'as' => 'category',
            'except' => 'all',
        ],
        'additionalFilter' => [
            'as' => 'filter',
            'except' => 'no-filter',
        ],
        'searchQuery' => [
            'as' => 'q',
            'except' => '',
        ],
    ];

    protected $listeners = [
        'update:status-filter' => 'setStatusFilter',
        'update:status' => 'updateIdeasCounts',
        'destroy:idea' => 'updateIdeasCounts',
    ];

    public function mount()
    {
        if (!auth()->check() && $this->additionalFilter === 'my-ideas') {
            $this->redirect(route('login'));
        }

        $this->updateIdeasCounts();
    }

    public function getNoFiltersAreActiveProperty()
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
                ->where('user_id', auth()->id())
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
