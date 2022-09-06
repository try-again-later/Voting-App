<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\{Category, Idea, Vote};
use App\Services\CategoriesService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\WithPagination;

class IdeasList extends Component
{
    use WithPagination;

    #[Url(as: 'status', except: 'all')]
    public $statusFilter = 'all';

    #[Url(as: 'category', except: 'all')]
    public $categoryFilter = 'all';

    #[Url(as: 'filter', except: 'no-filter')]
    public $additionalFilter = 'no-filter';

    #[Url(as: 'q', except: '')]
    public $searchQuery = '';

    #[On('update:status-filter')]
    public function handleStatusFilterUpdate($statusFilter)
    {
        $this->statusFilter = $statusFilter;
        $this->resetPage();
    }

    public function updatingCategoryFilter()
    {
        $this->resetPage();
    }

    public function updatingAdditionalFilter()
    {
        $this->resetPage();
    }

    public function updatingSearchQuery()
    {
        $this->resetPage();
    }

    public function updatedAdditionalFilter()
    {
        if ($this->additionalFilter === 'my-ideas' && !Auth::check()) {
            return redirect()->route('login');
        }
    }

    public function render(CategoriesService $categories)
    {
        return view('livewire.ideas-list', [
            'ideas' => Idea::query()
                ->with('user', 'category', 'status')
                ->when($this->statusFilter, function ($query, $status) {
                    if ($status === 'all') {
                        return;
                    }

                    $query
                        ->join('statuses', 'ideas.status_id', '=', 'statuses.id')
                        ->where('statuses.name', $status);
                })
                ->when($this->categoryFilter, function ($query, $category) {
                    if ($category === 'all') {
                        return;
                    }

                    $query->where('category_id', $category);
                })
                ->when($this->additionalFilter, function ($query, $filter) {
                    if ($filter === 'top-voted') {
                        $query
                            ->orderByDesc('votes_count')
                            ->orderByDesc('id');
                        return;
                    }

                    $query
                        ->orderByDesc('created_at')
                        ->orderByDesc('id');

                    if ($filter === 'my-ideas' && Auth::check()) {
                        $query
                            ->where('user_id', Auth::id());
                    }
                })
                ->when($this->searchQuery, function ($query, $searchQuery) {
                    // just ignore short search queries
                    if (mb_strlen($searchQuery) < 3) {
                        return;
                    }

                    $searchQuery = mb_strtolower($searchQuery);
                    $query->where(DB::raw('lower(title)'), 'like', "%$searchQuery%");
                })
                ->when($this->searchQuery, function ($query, $searchQuery) {
                    // just ignore short search queries
                    if (mb_strlen($searchQuery) < 3) {
                        return;
                    }

                    $searchQuery = mb_strtolower($searchQuery);
                    $query->where(DB::raw('lower(title)'), 'like', "%$searchQuery%");
                })
                ->addSelect(['auth_user_vote_id' => Vote::select('id')
                    ->where('user_id', Auth::id())
                    ->whereColumn('idea_id', 'ideas.id')
                    ->take(1)
                ])
                ->withCount('votes')
                ->simplePaginate(5)
                ->withPath(route('idea.index'))
                ->withQueryString(),

            'categories' => $categories->all(),
        ]);
    }
}
