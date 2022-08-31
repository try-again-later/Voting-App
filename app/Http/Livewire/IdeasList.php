<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\{Category, Idea, Vote};
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class IdeasList extends Component
{
    use WithPagination;

    public $statusFilter = 'all';
    public $categoryFilter = 'all';
    public $additionalFilter = 'no-filter';
    public $searchQuery = '';

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

    protected $listeners = ['update:status-filter' => 'handleStatusFilterUpdate'];

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

    public function updatingSearchquery()
    {
        $this->resetPage();
    }

    public function updatedAdditionalFilter()
    {
        if ($this->additionalFilter === 'my-ideas' && !auth()->check()) {
            return redirect()->route('login');
        }
    }

    public function render()
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

                    if ($filter === 'my-ideas' && auth()->check()) {
                        $query
                            ->where('user_id', auth()->user()->id);
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
                ->addSelect(['auth_user_vote_id' => Vote::select('id')
                    ->where('user_id', auth()->id())
                    ->whereColumn('idea_id', 'ideas.id')
                    ->take(1)
                ])
                ->withCount('votes')
                ->simplePaginate(5)
                ->withPath(route('idea.index'))
                ->withQueryString(),

            'categories' => Category::all(),
        ]);
    }
}
