<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\{Category, Idea, Vote};
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
                ->addSelect(['auth_user_vote_id' => Vote::select('id')
                    ->where('user_id', Auth::id())
                    ->whereColumn('idea_id', 'ideas.id')
                    ->take(1)
                ])
                ->withCount('votes')
                ->orderBy('id', 'desc')
                ->orderBy('created_at', 'desc')
                ->simplePaginate(5)
                ->withPath(route('idea.index'))
                ->withQueryString(),

            'categories' => Category::all(),
        ]);
    }
}
