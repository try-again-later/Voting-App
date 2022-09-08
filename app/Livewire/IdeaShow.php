<?php

namespace App\Livewire;

use App\Models\Idea;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Route;
use Livewire\Component;

#[On('update:idea')]
#[On('update:status')]
class IdeaShow extends Component
{
    public Idea $idea;
    public int $votesCount;
    public bool $voted;
    public bool $showPreview;
    public string $backUrl;
    public string $currentRouteName;

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
    }

    #[On('status-filter-redirect')]
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
        if (!Auth::check()) {
            return redirect(route('login'));
        }

        $success = false;
        if ($this->voted) {
            $success = $this->idea->unvote(Auth::user());
        } else {
            $success = $this->idea->vote(Auth::user());
        }
        if ($success) {
            $this->voted = !$this->voted;
            $this->votesCount += $this->voted ? 1 : -1;
        }
    }

    #[Computed]
    public function avatarSrc()
    {
        return $this->idea->user->avatar();
    }

    #[Computed]
    public function ideaLink()
    {
        return route('idea.show', $this->idea);
    }

    public function editIdea()
    {
        $this->dispatch('edit:idea', $this->idea)->to(EditIdeaForm::class);
    }

    public function deleteIdea()
    {
        $this
            ->dispatch('open-delete-modal:idea', $this->idea)
            ->to(DeleteIdeaConfirmationModal::class);
    }

    public function render()
    {
        return view('livewire.idea-show');
    }
}
