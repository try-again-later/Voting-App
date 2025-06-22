<?php

namespace App\Livewire;

use App\Models\Idea;
use App\Services\CategoriesService;
use Livewire\Attributes\On;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class EditIdeaForm extends Component
{
    public ?Idea $idea = null;
    public $category = 'none';
    public $title = '';
    public $description = '';

    protected $rules = [
        'category' => ['required', 'integer', 'exists:categories,id'],
        'title' => ['required', 'max:255'],
        'description' => ['required'],
    ];

    #[On('edit:idea')]
    public function handleEditIdea(int $ideaId)
    {
        $idea = Idea::find($ideaId);

        if ($idea == null || !Auth::check() || Auth::user()->cannot('update', $idea)) {
            return;
        }

        $this->idea = $idea;
        $this->category = $idea->category->id;
        $this->title = $idea->title;
        $this->description = $idea->description;
    }

    public function updateIdea()
    {
        if (!isset($this->idea)) {
            return;
        }

        if (!Auth::check() || Auth::user()->cannot('update', $this->idea)) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $this->validate();

        $this->idea->update([
            'category_id' => $this->category,
            'title' => $this->title,
            'description' => $this->description,
        ]);
        $this->dispatch('update:idea', $this->idea);
    }

    public function render(CategoriesService $categories)
    {
        return view('livewire.edit-idea-form', [
            'categories' => $categories->all(),
        ]);
    }
}
