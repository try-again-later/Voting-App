<?php

namespace App\Livewire;

use App\Models\Idea;
use Livewire\Attributes\On;
use Livewire\Component;

class CommentsList extends Component
{
    public const CHUNK_SIZE = 3;

    public string $class;
    public Idea $idea;

    public array $loadedCommentsIdsRanges = [];

    public int $lastChunk = -1;
    public bool $loadedNewComments = false;

    #[On('create:comment')]
    public function addNewComment($newComment)
    {
        if (!$this->loadedNewComments) {
            $this->loadedNewComments = true;
            $this->loadedCommentsIdsRanges[$this->lastChunk + 1] = [
                'chunkIndex' => $this->lastChunk + 1,
                'hiddenCount' => 0,
            ];
        }

        $this->dispatch(
            'created:comment',
            comment: $newComment,
            chunkIndex: $this->lastChunk + 1
        );
    }

    public function mount(Idea $idea, string $class = '')
    {
        $this->idea = $idea;
        $this->class = $class;

        $firstSeveralComments = $this->idea->comments()
            ->with('author', 'newIdeaStatus')
            ->orderBy('comments.id', 'asc')
            ->limit(self::CHUNK_SIZE)
            ->get();
        if ($firstSeveralComments->count() > 0) {
            $this->loadedCommentsIdsRanges[0] = [
                'chunkIndex' => 0,
                'firstId' => $firstSeveralComments->first()->id,
                'lastId' => $firstSeveralComments->last()->id,
            ];
        }

        $lastSeveralComments = $this->idea->comments()
            ->with('author', 'newIdeaStatus')
            ->orderByDesc('comments.id')
            ->when(
                $firstSeveralComments->count() > 0,
                function ($query) use ($firstSeveralComments) {
                    $query->where('comments.id', '>', $firstSeveralComments->last()->id);
                },
            )
            ->limit(self::CHUNK_SIZE)
            ->get()
            ->reverse();
        if ($lastSeveralComments->count() > 0) {
            $this->loadedCommentsIdsRanges[2] = [
                'chunkIndex' => 2,
                'firstId' => $lastSeveralComments->first()->id,
                'lastId' => $lastSeveralComments->last()->id,
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
                ->when(
                    $firstSeveralComments->count() > 0,
                    function ($query) use ($firstSeveralComments) {
                        $query->where('comments.id', '>', $firstSeveralComments->last()->id);
                    },
                )
                ->when(
                    $lastSeveralComments->count() > 0,
                    function ($query) use ($lastSeveralComments) {
                        $query->where('comments.id', '<', $lastSeveralComments->first()->id);
                    },
                )
                ->where('comments.id', '>=', $lastStatusChangeComment->id)
                ->limit(self::CHUNK_SIZE)
                ->get();
            if ($severalCommentsAfterTheStatusChange->count() > 0) {
                $this->loadedCommentsIdsRanges[1] = [
                    'chunkIndex' => 1,
                    'firstId' => $severalCommentsAfterTheStatusChange->first()->id,
                    'lastId' => $severalCommentsAfterTheStatusChange->last()->id,
                ];
            }
        }

        ksort($this->loadedCommentsIdsRanges);
        $this->loadedCommentsIdsRanges = array_values($this->loadedCommentsIdsRanges);
        foreach (array_keys($this->loadedCommentsIdsRanges) as $chunkIndex) {
            $this->loadedCommentsIdsRanges[$chunkIndex]['chunkIndex'] = $chunkIndex;
            $this->lastChunk = $chunkIndex;
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
