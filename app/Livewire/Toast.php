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
        'create:comment' => 'addCreateCommentAlert',
        'create:spam-report' => 'addCreateSpamReportAlert',
    ];

    public function addCreateSpamReportAlert()
    {
        $this->dispatchBrowserEvent('create:alert', [
            'title' => "Spam report has been sent!",
        ]);
    }

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

    public function addCreateCommentAlert($comment) {
        $ideaTitle = $comment['idea']['title'];
        $this->dispatchBrowserEvent('create:alert', [
            'title' => "Successfully commented on idea \"{$ideaTitle}\"",
        ]);
    }

    public function render()
    {
        return view('livewire.toast');
    }
}
