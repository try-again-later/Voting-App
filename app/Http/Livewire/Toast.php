<?php

namespace App\Http\Livewire;

use App\Models\Idea;
use Livewire\Component;

class Toast extends Component
{
    protected $listeners = [
        'update:idea' => 'addIdeaUpdateAlert',
        'update:status' => 'addStatusUpdateAlert',
        'destroy:idea' => 'addDestroyIdeaAlert',
    ];

    public function addIdeaUpdateAlert(Idea $idea)
    {
        $this->dispatchBrowserEvent('create:alert', [
            'title' => "Idea \"{$idea->title}\" successfully edited!",
        ]);
    }

    public function addStatusUpdateAlert(Idea $idea, string $newStatus)
    {
        $this->dispatchBrowserEvent('create:alert', [
            'title' => "Status of the idea \"{$idea->title}\" successfully changed to \"{$newStatus}\"!",
        ]);
    }

    public function addDestroyIdeaAlert(string $ideaTitle)
    {
        $this->dispatchBrowserEvent('create:alert', [
            'title' => "Idea \"$ideaTitle\" successfully deleted...",
        ]);
    }

    public function render()
    {
        return view('livewire.toast');
    }
}
