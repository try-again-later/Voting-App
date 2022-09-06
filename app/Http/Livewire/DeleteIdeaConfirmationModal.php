<?php

namespace App\Http\Livewire;

use App\Models\Idea;
use Livewire\Component;

class DeleteIdeaConfirmationModal extends Component
{
    public ?Idea $idea = null;

    protected $listeners = ['open-delete-modal:idea' => 'openModal'];

    public function openModal(Idea $idea)
    {
        $this->idea = $idea;
        $this->dispatchBrowserEvent('open-delete-modal:idea');
    }

    public function render()
    {
        return view('livewire.delete-idea-confirmation-modal');
    }
}
