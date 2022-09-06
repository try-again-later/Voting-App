<?php

namespace App\Livewire;

use App\Models\Idea;
use Livewire\Attributes\On;
use Livewire\Component;

class DeleteIdeaConfirmationModal extends Component
{
    public ?Idea $idea = null;

    #[On('open-delete-modal:idea')]
    public function openModal(Idea $idea)
    {
        $this->idea = $idea;
    }

    public function render()
    {
        return view('livewire.delete-idea-confirmation-modal');
    }
}
