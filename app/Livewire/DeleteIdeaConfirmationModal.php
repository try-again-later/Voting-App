<?php

namespace App\Livewire;

use App\Models\Idea;
use Livewire\Attributes\On;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DeleteIdeaConfirmationModal extends Component
{
    public ?string $redirectOnDelete = null;

    public ?Idea $idea = null;

    #[On('open-delete-modal:idea')]
    public function openModal(Idea $idea)
    {
        if (!Auth::check() || Auth::user()->cannot('delete', $idea)) {
            return;
        }

        $this->idea = $idea;
    }

    public function deleteIdea()
    {
        if (!isset($this->idea)) {
            return;
        }

        if (!Auth::check() || Auth::user()->cannot('delete', $this->idea)) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $this->idea->delete();
        $this->dispatch('destroy:idea', $this->idea->title);

        if (isset($this->redirectOnDelete)) {
            return redirect()
                ->to($this->redirectOnDelete)
                ->with('alerts', [
                    ['title' => "Idea \"{$this->idea->title}\" successfully deleted..."],
                ]);
        }
    }

    public function render()
    {
        return view('livewire.delete-idea-confirmation-modal');
    }
}
