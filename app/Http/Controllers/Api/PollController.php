<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePollRequest;
use App\Http\Requests\UpdatePollRequest;
use App\Http\Resources\PollResource;
use App\Models\Poll;
use Illuminate\Http\Request;

class PollController extends Controller
{
    public function index()
    {
        $polls = Poll::with('options')->orderBy('start_date', 'desc')->get();

        return PollResource::collection($polls);
    }

    public function store(StorePollRequest $request)
    {
        $poll = Poll::create([
            'title' => $request->title,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        foreach ($request->options as $optionText) {
            $poll->options()->create([
                'option_text' => $optionText,
                'votes' => 0,
            ]);
        }

        return new PollResource($poll->load('options'));
    }

    public function show(Poll $poll)
    {
        return new PollResource($poll->load('options'));
    }

    public function update(UpdatePollRequest $request, Poll $poll)
    {
        $poll->update([
            'title' => $request->title,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return new PollResource($poll->load('options'));
    }

    public function destroy(Poll $poll)
    {
        $poll->delete();

        return response()->json(null, 204);
    }

    public function vote(Request $request, Poll $poll)
    {
        $request->validate([
            'option_id' => 'required|integer',
        ]);

        $option = $poll->options()->findOrFail($request->option_id);
        $option->increment('votes');

        return new PollResource($poll->load('options'));
    }
}
