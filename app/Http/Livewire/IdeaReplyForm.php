<?php

namespace App\Http\Livewire;

use App\Models\Idea;
use Barryvdh\Debugbar\Facades\Debugbar;
use Barryvdh\Debugbar\Middleware\DebugbarEnabled;
use Livewire\Component;

class IdeaReplyForm extends Component
{
    public Idea $idea;

    public string $body = '';

    protected $messages = [
        'body.required' => 'Please enter your comment',
    ];

    protected $rules = [
        'body' => ['required'],
    ];

    public function mount(Idea $idea)
    {
        $this->idea = $idea;
    }

    public function sendReply()
    {
        if (!auth()->check()) {
            return $this->redirect(route('login'));
        }

        $this->validate();

        $newComment = $this->idea->leaveReply(auth()->user(), $this->body);

        $this->emit('create:comment', $newComment);
        $this->dispatchBrowserEvent('close-create-comment-form', $newComment->id);
        $this->body = '';
    }

    public function render()
    {
        return view('livewire.idea-reply-form');
    }
}
