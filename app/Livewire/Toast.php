<?php

namespace App\Livewire;

use App\Models\Comment;
use App\Models\Idea;
use Livewire\Attributes\On;
use Livewire\Component;

class Toast extends Component
{
    #[On('update:idea')]
    public function addIdeaUpdateAlert(Idea $idea)
    {
        $this->dispatch(
            'create:alert',
            title: "Idea \"{$idea->title}\" successfully edited!"
        );
    }

    #[On('update:status')]
    public function addStatusUpdateAlert(Idea $idea, string $newStatus)
    {
        $this->dispatch(
            'create:alert',
            title: "Status of the idea \"{$idea->title}\" successfully changed to \"{$newStatus}\"!"
        );
    }

    #[On('destroy:idea')]
    public function addDestroyIdeaAlert(string $ideaTitle)
    {
        $this->dispatch(
            'create:alert',
            title: "Idea \"$ideaTitle\" successfully deleted..."
        );
    }

    #[On('create:comment')]
    public function addCreateCommentAlert($newComment) {
        $ideaTitle = $newComment['idea']['title'];
        $this->dispatch(
            'create:alert',
            title: "Successfully commented on idea \"{$ideaTitle}\""
        );
    }

    public function render()
    {
        return view('livewire.toast');
    }
}
