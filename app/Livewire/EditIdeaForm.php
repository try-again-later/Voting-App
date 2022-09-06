<?php

namespace App\Livewire;

use App\Models\Idea;
use App\Services\CategoriesService;
use Livewire\Attributes\On;
use Livewire\Component;

class EditIdeaForm extends Component
{
    public ?Idea $idea = null;
    public string $category = 'none';
    public string $title = '';
    public string $description = '';

    protected $rules = [
        'category' => ['required', 'integer', 'exists:categories,id'],
        'title' => ['required', 'max:255'],
        'description' => ['required'],
    ];

    #[On('edit:idea')]
    public function handleEditIdea(Idea $idea)
    {
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

        $this->validate();

        $this->idea->update([
            'category_id' => $this->category,
            'title' => $this->title,
            'description' => $this->description,
        ]);
        $this->dispatch('update:idea');
    }

    public function render(CategoriesService $categories)
    {
        return view('livewire.edit-idea-form', [
            'categories' => $categories->all(),
        ]);
    }
}
