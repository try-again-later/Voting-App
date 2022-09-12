<?php

namespace App\Http\Livewire;

use App\Jobs\NotifyAllVoters;
use App\Models\Idea;
use App\Models\Status;
use Illuminate\Http\Response;
use Livewire\Component;

class SetStatusForm extends Component
{
    public Idea $idea;

    public $status = null;
    public $comment = '';
    public $notifyVoters = false;

    public function mount(
        Idea $idea,
    )
    {
        $this->idea = $idea;
        $this->status = $this->idea->status->name;
    }

    public function render()
    {
        return view('livewire.set-status-form');
    }

    public function changeStatus()
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $newStatus = Status::query()->where('name', $this->status)->firstOrFail();
        if ($newStatus->id === $this->idea->status->id) {
            return;
        }

        $this->idea->status_id = $newStatus->id;
        $this->idea->save();

        if ($this->notifyVoters && env('SEND_EMAILS', default: true)) {
            NotifyAllVoters::dispatch($this->idea);
        }

        $this->emit('update:status', $this->idea, $newStatus->human_name);
    }
}
