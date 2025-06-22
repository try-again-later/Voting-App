<?php

namespace App\Livewire;

use App\Models\Idea;
use App\Models\Status;
use Illuminate\Support\Facades\Auth;
use App\Services\CategoriesService;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Symfony\Component\HttpFoundation\Response;

class CreateIdea extends Component
{
    public $title;
    public $category = 'none';
    public $description;

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

    public function render(CategoriesService $categories)
    {
        return view('livewire.create-idea', [
            'categories' => $categories->all(),
        ]);
    }

    public function createIdea()
    {
        if (!Auth::check()) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $this->validate();

        $status = Status::default();
        if (!isset($status)) {
            abort(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $newIdea = Idea::create([
            'user_id' => Auth::id(),
            'category_id' => $this->category,
            'status_id' => Status::default()->id,
            'title' => $this->title,
            'description' => $this->description,
        ]);

        return redirect()->route('idea.show', $newIdea);
    }
}
