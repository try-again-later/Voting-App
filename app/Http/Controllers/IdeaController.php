<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIdeaRequest;
use App\Http\Requests\UpdateIdeaRequest;
use App\Models\Idea;
use App\Models\Vote;
use Illuminate\Support\Facades\Auth;

class IdeaController extends Controller
{
    public const PAGINATION_COUNT = 5;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('idea.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreIdeaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreIdeaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Idea  $idea
     * @return \Illuminate\Http\Response
     */
    public function show(Idea $idea)
    {
        $idea->load(['status', 'user', 'category']);

        $backUrl = url()->previous();
        $ideaIndexPath = parse_url(route('idea.index'), PHP_URL_PATH) ?? '/';
        $previousPath = parse_url(url()->previous(), PHP_URL_PATH) ?? '/';

        if ($ideaIndexPath !== $previousPath) {
            $backUrl = route('idea.index');
        }

        return view('idea.show', [
            'idea' => $idea,
            'votesCount' => $idea->votes()->count(),
            'voted' => $idea->votedBy(Auth::user()),
            'backUrl' => $backUrl,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Idea  $idea
     * @return \Illuminate\Http\Response
     */
    public function edit(Idea $idea)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateIdeaRequest  $request
     * @param  \App\Models\Idea  $idea
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateIdeaRequest $request, Idea $idea)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Idea  $idea
     * @return \Illuminate\Http\Response
     */
    public function destroy(Idea $idea)
    {
        //
    }
}
