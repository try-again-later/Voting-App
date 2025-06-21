<?php

namespace App\Livewire;

use App\Filters\Idea\AdditionalFilter;
use App\Filters\Idea\CategoryFilter;
use App\Filters\Idea\SearchFilter;
use App\Filters\Idea\StatusFilter;
use App\Models\Idea;
use Livewire\Attributes\On;
use Livewire\Component;

class IdeaStatusFilters extends Component
{
    public string $statusFilter;
    public bool $redirect;

    public array $ideasCountByStatus = [
        'all' => 0,
        'open' => 0,
        'considering' => 0,
        'in-progress' => 0,
        'implemented' => 0,
        'closed' => 0,
    ];

    #[On('update:status')]
    #[On('destroy:idea')]
    public function updateIdeasCounts()
    {
        $this->ideasCountByStatus = [
            ...$this->ideasCountByStatus,
            ...Idea::getCountsByStatuses(),
        ];
    }

    #[On('update:status-filter')]
    public function updateStatusFilter(string $statusFilter) {
        $this->statusFilter = $statusFilter;
    }

    public function setStatusFilter(string $statusFilter) {
        if ($this->redirect) {
            $this->dispatch('status-filter-redirect', $statusFilter);
        } else {
            $this->dispatch('update:status-filter', $statusFilter);
        }
    }

    public function mount(
        string $statusFilter,
        bool $redirect = false
    ) {
        $this->statusFilter = $statusFilter;
        $this->redirect = $redirect;

        $this->updateIdeasCounts();
    }
}
