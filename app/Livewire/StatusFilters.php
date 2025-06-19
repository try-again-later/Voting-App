<?php

namespace App\Livewire;

use App\Models\Idea;
use Illuminate\Support\Facades\Route;
use Livewire\Attributes\On;
use Livewire\Component;

class StatusFilters extends Component
{
    public $class = '';
    public $currentRouteName;

    public $statusFilter;
    public $ideasCountByStatus = [
        'all' => 0,
        'considering' => 0,
        'in-progress' => 0,
        'implemented' => 0,
        'closed' => 0,
    ];

    public function mount()
    {
        $this->statusFilter = request('status') ?? 'all';

        $this->updateIdeasCounts();

        $this->currentRouteName = Route::currentRouteName();
    }

    #[On('update:status')]
    public function updateIdeasCounts()
    {
        $this->ideasCountByStatus = [
            ...$this->ideasCountByStatus,
            ...Idea::getCountsByStatuses(),
        ];
    }

    public function setStatusFilter(string $statusFilter)
    {
        $this->statusFilter = $statusFilter;

        if ($this->currentRouteName != 'idea.index') {
            return redirect()->route('idea.index', [
                'status' => $statusFilter,
            ]);
        }

        $this->dispatch('update:status-filter', statusFilter: $statusFilter);
    }

    public function render()
    {
        return view('livewire.status-filters');
    }
}
