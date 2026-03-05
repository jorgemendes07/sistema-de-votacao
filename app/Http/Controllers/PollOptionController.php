<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Poll;
use App\Models\PollOption;

class PollOptionController extends Controller
{
    public function index(Poll $poll)
    {
        dd('index: todas as opções da enquete', $poll->id);
    }

    public function create(Poll $poll)
    {
        dd('create: formulário de nova opção para a enquete', $poll->id);
    }

    public function store(Request $request, Poll $poll)
    {
        dd('store: salvar nova opção para enquete', $poll->id, $request->all());
    }

    public function show(Poll $poll, PollOption $option)
    {
        dd('show: mostrar opção da enquete', $poll->id, $option->id);
    }

    public function edit(Poll $poll, PollOption $option)
    {
        dd('edit: editar opção da enquete', $poll->id, $option->id);
    }

    public function update(Request $request, Poll $poll, PollOption $option)
    {
        dd('update: atualizar opção da enquete', $poll->id, $option->id, $request->all());
    }

    public function destroy(Poll $poll, PollOption $option)
    {
        dd('destroy: deletar opção da enquete', $poll->id, $option->id);
    }
}
