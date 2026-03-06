<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Poll;

class PollController extends Controller
{
    public function index()
    {
        $polls = Poll::with('options')->orderBy('start_date', 'desc')->get();
        return view('polls.index', compact('polls'));
    }

    public function create()
    {
        return view('polls.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string|max:255',
        ]);

        // Criar a enquete
        $poll = Poll::create([
            'title' => $request->title,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        // Criar as opções
        foreach ($request->options as $optionText) {
            $poll->options()->create([
                'option_text' => $optionText,
                'votes' => 0,
            ]);
        }

        return redirect()->route('polls.vote', $poll->id)
                        ->with('success', 'Enquete criada com sucesso!');
    }

    public function vote(Request $request, Poll $poll)
    {
        $optionId = $request->input('option_id');
        $option = $poll->options()->findOrFail($optionId);

        $option->increment('votes');

        return redirect()->route('polls.vote', $poll->id)->with('success', 'Voto registrado!');
    }

    public function show(Poll $poll)
    {
        return view('polls.vote', compact('poll'));
    }

    public function edit(string $id)
    {
        $poll = Poll::findOrFail($id);
        return view('polls.edit', compact('poll'));
    }

    public function update(Request $request, string $id)
    {
        $poll = Poll::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $poll->update([
            'title' => $request->title,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return redirect()->route('polls.index')->with('success', 'Enquete atualizada!');
    }

    public function destroy(string $id)
    {
        $poll = Poll::findOrFail($id);

        $poll->delete();

        // Redireciona para a lista de enquetes com mensagem
        return redirect()->route('polls.index')->with('success', 'Enquete deletada com sucesso!');
    }
}
