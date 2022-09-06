<?php

namespace App\Http\Livewire;

use App\Models\Idea;
use Livewire\Component;

class IdeaShow extends Component
{
    public Idea $idea;
    public int $votesCount;
    public bool $voted;
    public bool $showPreview;

    protected $listeners = [
        'update:status' => '$refresh',
        'update:idea' => 'handleUpdate',
    ];

    public function mount(
        Idea $idea,
        int $votesCount = 0,
        bool $voted = false,
        bool $showPreview = false,
    )
    {
        $this->idea = $idea;
        $this->votesCount = $votesCount;
        $this->voted = $voted;
        $this->showPreview = $showPreview;
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

    public function render()
    {
        return view('livewire.idea-show');
    }
}
