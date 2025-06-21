<?php

namespace App\Http\Livewire;

use App\Models\Idea;

trait IdeasCountByStatus
{
    public array $ideasCountByStatus = [
        'all' => 0,
        'open' => 0,
        'considering' => 0,
        'in-progress' => 0,
        'implemented' => 0,
        'closed' => 0,
    ];

    public function updateIdeasCounts()
    {
        $this->ideasCountByStatus = [
            ...$this->ideasCountByStatus,
            ...Idea::getCountsByStatuses(),
        ];
    }
}
