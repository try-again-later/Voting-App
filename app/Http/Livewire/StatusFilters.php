<?php

namespace App\Http\Livewire;

use App\Models\Idea;
use Illuminate\Support\Facades\Route;
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

        $this->ideasCountByStatus = [
            ...$this->ideasCountByStatus,
            ...Idea::getCountsByStatuses(),
        ];

        $this->currentRouteName = Route::currentRouteName();

        if ($this->currentRouteName !== 'idea.index') {
            $this->queryString = [];
        }
    }

    public function setStatusFilter(string $statusFilter)
    {
        $this->statusFilter = $statusFilter;

        if ($this->currentRouteName != 'idea.index') {
            return redirect()->route('idea.index', [
                'status' => $statusFilter,
            ]);
        }

        $this->emit('update:status-filter', $statusFilter);
    }

    public function render()
    {
        return view('livewire.status-filters');
    }
}