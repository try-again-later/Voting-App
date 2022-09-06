<?php

namespace App\Http\Livewire;

use App\Models\Idea;
use App\Services\CategoriesService;
use Livewire\Component;

class EditIdeaForm extends Component
{
    public ?Idea $idea = null;
    public string $category = 'none';
    public string $title = '';
    public string $description = '';

    protected $listeners = ['edit:idea' => 'handleEditIdea'];

    protected $rules = [
        'category' => ['required', 'integer', 'exists:categories,id'],
        'title' => ['required', 'max:255'],
        'description' => ['required'],
    ];

    public function handleEditIdea(Idea $idea)
    {
        $this->idea = $idea;
        $this->category = $idea->category->id;
        $this->title = $idea->title;
        $this->description = $idea->description;
        $this->dispatchBrowserEvent('edit:idea');
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
        $this->emit('update:idea');
        $this->dispatchBrowserEvent('update:idea');
    }

    public function render(CategoriesService $categories)
    {
        return view('livewire.edit-idea-form', [
            'categories' => $categories->all(),
        ]);
    }
}
