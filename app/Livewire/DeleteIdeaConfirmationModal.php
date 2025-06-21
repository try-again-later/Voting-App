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

    public function deleteIdea(int $ideaId)
    {
        $idea = Idea::find($ideaId);

        if ($idea == null || !Auth::check() || Auth::user()->cannot('delete', $idea)) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $idea->delete();
        $this->dispatch('destroy:idea', ideaTitle: $idea->title);

        if (isset($this->redirectOnDelete)) {
            return redirect()
                ->to($this->redirectOnDelete)
                ->with('alerts', [
                    ['title' => "Idea \"{$idea->title}\" successfully deleted..."],
                ]);
        }
    }

    public function render()
    {
        return view('livewire.delete-idea-confirmation-modal');
    }
}
