<?php

namespace App\Livewire;

use App\Models\Idea;
use Livewire\Component;

class IdeaShow extends Component
{
    public Idea $idea;
    public int $votesCount;
    public bool $voted;

    public function mount(Idea $idea, int $votesCount, bool $voted = false)
    {
        $this->idea = $idea;
        $this->votesCount = $votesCount;
        $this->voted = $voted;
    }

    public function getAvatarSrcProperty()
    {
        return $this->idea->user->avatar();
    }

    public function getIdeaLinkProperty()
    {
        return route('idea.show', $this->idea);
    }

    public function render()
    {
        return view('livewire.idea-show');
    }
}
