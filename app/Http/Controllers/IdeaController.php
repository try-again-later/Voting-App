<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class IdeaController extends Controller
{
    public const PAGINATION_COUNT = 5;

    public function show(Idea $idea): View
    {
        $idea->load(['status', 'user', 'category']);

        $backUrl = url()->previous();
        $ideaIndexPath = parse_url(route('idea.index'), PHP_URL_PATH) ?? '/';
        $previousPath = parse_url(url()->previous(), PHP_URL_PATH) ?? '/';

        if ($ideaIndexPath !== $previousPath) {
            $backUrl = route('idea.index');
        }

        return view('idea.show', [
            'idea' => $idea->loadCount('comments'),
            'votesCount' => $idea->votes()->count(),
            'voted' => $idea->votedBy(Auth::user()),
            'backUrl' => $backUrl,
        ]);
    }
}
