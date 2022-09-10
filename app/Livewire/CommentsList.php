<?php

namespace App\Livewire;

use App\Models\Idea;
use App\Models\User;
use Barryvdh\Debugbar\Facades\Debugbar;
use Livewire\Component;

class CommentsList extends Component
{
    public string $class;
    public Idea $idea;

    public array $loadedCommentsIdsRanges = [];

    public function mount(Idea $idea, string $class = '')
    {
        $this->idea = $idea;
        $this->class = $class;

        $firstSeveralComments = $this->idea->comments()
            ->with('author', 'newIdeaStatus')
            ->orderBy('comments.id', 'asc')
            ->limit(5)
            ->get();
        if ($firstSeveralComments->count() > 0) {
            $this->loadedCommentsIdsRanges[] = [
                'chunkIndex' => 0,
                'firstId' => $firstSeveralComments->first()->id,
                'lastId' => $firstSeveralComments->last()->id,
            ];
        }

        $lastStatusChangeComment = $this->idea->comments()
            ->whereNotNull('new_idea_status_id')
            ->orderByDesc('comments.id')
            ->first();
        if (!is_null($lastStatusChangeComment)) {
            $severalCommentsAfterTheStatusChange = $this->idea->comments()
                ->with('author', 'newIdeaStatus')
                ->orderBy('comments.id', 'asc')
                ->where('comments.id', '>=', $lastStatusChangeComment->id)
                ->limit(5)
                ->get();
            if ($severalCommentsAfterTheStatusChange->count() > 0) {
                $this->loadedCommentsIdsRanges[] = [
                    'chunkIndex' => 1,
                    'firstId' => $severalCommentsAfterTheStatusChange->first()->id,
                    'lastId' => $severalCommentsAfterTheStatusChange->last()->id,
                ];
            }
        }

        for ($i = 0; $i < count($this->loadedCommentsIdsRanges); ++$i) {
            $currentRange = $this->loadedCommentsIdsRanges[$i];
            $nextRange = $this->loadedCommentsIdsRanges[$i + 1] ?? null;

            if (!is_null($nextRange)) {
                $this->loadedCommentsIdsRanges[$i]['hiddenCount'] = $this->idea->comments()
                    ->where('comments.id', '>=', $currentRange['firstId'])
                    ->where('comments.id', '<', $nextRange['firstId'])
                    ->count();
            } else {
                $this->loadedCommentsIdsRanges[$i]['hiddenCount'] = $this->idea->comments()
                    ->where('comments.id', '>=', $currentRange['firstId'])
                    ->count();
            }
        }
    }

    public function loadMoreComments(array $chunks)
    {

        $result = [];
        foreach ($chunks as $chunk) {
            $chunkIndex = $chunk['chunkIndex'];
            $loadedChunk = &$this->loadedCommentsIdsRanges[$chunkIndex];

            $lastId = $chunk['lastId'];
            if (isset($this->loadedCommentsIdsRanges[$chunkIndex + 1])) {
                $lastId = min(
                    $lastId,
                    $this->loadedCommentsIdsRanges[$chunkIndex + 1]['firstId'] - 1,
                );
            }

            $comments = $this->idea->comments()
                ->with('author', 'newIdeaStatus')
                ->where('comments.id', '>=', $chunk['firstId'])
                ->where('comments.id', '<=', $lastId)
                ->orderBy('comments.id', 'asc')
                ->get();

            foreach ($comments as $comment) {
                $comment['author']['avatar'] = $comment->author->avatar();
                $comment['author']['is_admin'] = $comment->author->isAdmin();
                $comment['created_at_for_humans'] = $comment->created_at->diffForHumans();
            }

            $result[] = [
                'chunkIndex' => $chunkIndex,
                'comments' => $comments,
            ];

            if ($comments->count() > 0) {
                $loadedChunk['lastId'] = $comments->last()->id;
            }
            $loadedChunk['hiddenCount'] =
                max($loadedChunk['hiddenCount'] - $comments->count(), 0);
        }

        return $result;
    }

    public function render()
    {
        return view('livewire.comments-list');
    }
}
