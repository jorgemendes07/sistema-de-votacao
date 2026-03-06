<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Poll;
use App\Models\PollOption;

class PollOptionController extends Controller
{
    public function index(Poll $poll)
    {
        //
    }

    public function create(Poll $poll)
    {
        //
    }

    public function store(Request $request, Poll $poll)
    {
        //
    }

    public function show(Poll $poll, PollOption $option)
    {
        //
    }

    public function edit(Poll $poll, PollOption $option)
    {
        //
    }

    public function update(Request $request, Poll $poll, PollOption $option)
    {
        //
    }

    public function destroy(Poll $poll, PollOption $option)
    {
        //
    }
}
