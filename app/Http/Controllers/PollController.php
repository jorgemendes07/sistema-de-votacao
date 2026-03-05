<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PollController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        dd('index: lista todas as enquetes');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        dd('create: formulário para criar enquete');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd('store: salvar nova enquete', $request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        dd('show: mostrar enquete', $id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        dd('edit: formulário para editar enquete', $id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        dd('update: atualizar enquete', $id, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        dd('destroy: deletar enquete', $id);
    }
}
