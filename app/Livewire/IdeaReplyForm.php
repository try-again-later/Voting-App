<?php

namespace App\Livewire;

use App\Models\Idea;
use Barryvdh\Debugbar\Facades\Debugbar;
use Barryvdh\Debugbar\Middleware\DebugbarEnabled;
use Illuminate\Support\Facades\Auth;
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
        if (!Auth::check()) {
            return $this->redirect(route('login'));
        }

        $this->validate();

        $newComment = $this->idea->leaveReply(Auth::user(), $this->body);

        $this->dispatch('create:comment', newComment: $newComment);
        $this->body = '';
    }

    public function render()
    {
        return view('livewire.idea-reply-form');
    }
}
