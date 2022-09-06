<?php

namespace App\Http\Livewire;

use App\Models\Idea;
use Illuminate\Http\Response;
use Livewire\Component;

class DeleteIdeaConfirmationModal extends Component
{
    public ?string $redirectOnDelete = null;

    public ?Idea $idea = null;

    protected $listeners = ['open-delete-modal:idea' => 'openModal'];

    public function openModal(Idea $idea)
    {
        if (!auth()->check() || auth()->user()->cannot('delete', $idea)) {
            return;
        }

        $this->idea = $idea;
        $this->dispatchBrowserEvent('open-delete-modal:idea');
    }

    public function deleteIdea()
    {
        if (!isset($this->idea)) {
            return;
        }

        if (!auth()->check() || auth()->user()->cannot('delete', $this->idea)) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $deletedIdeaTitle = $this->idea->title;
        Idea::destroy($this->idea->id);

        $this->dispatchBrowserEvent('close-delete-modal:idea');
        $this->emit('destroy:idea', $deletedIdeaTitle);
        $this->idea = null;

        if (isset($this->redirectOnDelete)) {
            return redirect()
                ->to($this->redirectOnDelete)
                ->with('alerts', [
                    ['title' => "Idea \"$deletedIdeaTitle\" successfully deleted..."],
                ]);
        }
    }

    public function render()
    {
        return view('livewire.delete-idea-confirmation-modal');
    }
}
