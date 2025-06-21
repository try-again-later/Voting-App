<?php

namespace App\Http\Livewire;

use App\Models\Idea;
use Illuminate\Support\Facades\Route;
use Livewire\Component;

class IdeaShow extends Component
{
    use IdeasCountByStatus;

    public Idea $idea;
    public int $votesCount;
    public bool $voted;
    public bool $showPreview;

    public string $backUrl;
    public string $currentRouteName;

    protected $listeners = [
        'update:status' => 'updateIdeasCounts',
        'update:idea' => 'handleUpdate',
        'status-filter-redirect' => 'redirectToIdeasList',
    ];

    public function mount(
        Idea $idea,
        int $votesCount = 0,
        bool $voted = false,
        bool $showPreview = false,
        string $backUrl = '/',
    )
    {
        $this->idea = $idea;
        $this->votesCount = $votesCount;
        $this->voted = $voted;
        $this->showPreview = $showPreview;
        $this->backUrl = $backUrl;

        $this->updateIdeasCounts();
    }

    public function redirectToIdeasList(string $statusFilter)
    {
        $this->redirect(route('idea.index', [
            'status' => $statusFilter,
        ]));
    }

    public function handleUpdate(Idea $updatedIdea)
    {
        if ($this->idea->id !== $updatedIdea->id) {
            return;
        }
        $this->idea->refresh();
    }

    public function vote()
    {
        if (!auth()->check()) {
            return redirect(route('login'));
        }

        $success = false;
        if ($this->voted) {
            $success = $this->idea->unvote(auth()->user());
        } else {
            $success = $this->idea->vote(auth()->user());
        }
        if ($success) {
            $this->voted = !$this->voted;
            $this->votesCount += $this->voted ? 1 : -1;
        }
    }

    public function getAvatarSrcProperty()
    {
        return $this->idea->user->avatar();
    }

    public function getIdeaLinkProperty()
    {
        return route('idea.show', $this->idea);
    }

    public function editIdea()
    {
        $this->emit('edit:idea', $this->idea);
    }

    public function deleteIdea()
    {
        $this->emit('open-delete-modal:idea', $this->idea);
    }

    public function render()
    {
        return view('livewire.idea-show');
    }
}
