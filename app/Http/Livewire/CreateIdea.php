<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Idea;
use App\Models\Status;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Symfony\Component\HttpFoundation\Response;

class CreateIdea extends Component
{
    use WithFileUploads;

    public $title;
    public $category = 'none';
    public $description;
    public $attachment;

    protected $messages = [
        'category.not_in' => 'Please select a category.',
    ];

    protected function rules()
    {
        return [
            'title' => 'required',
            'category' => ['required', Rule::notIn(['none'])],
            'description' => 'required',
        ];
    }

    public function attachmentBasename()
    {
        if (!isset($this->attachment)) {
            return '';
        }
        return basename($this->attachment);
    }

    public function render()
    {
        return view('livewire.create-idea', [
            'categories' => Category::all(),
        ]);
    }

    public function createIdea()
    {
        if (!auth()) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $this->validate();

        $status = Status::default();
        if (!isset($status)) {
            abort(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $newIdea = Idea::create([
            'user_id' => auth()->user()->id,
            'category_id' => $this->category,
            'status_id' => Status::default()->id,
            'title' => $this->title,
            'description' => $this->description,
        ]);

        return redirect()->route('idea.show', $newIdea);
    }
}
