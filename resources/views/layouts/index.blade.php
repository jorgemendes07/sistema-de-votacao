@extends('layouts.app')

@section('title', 'Enquetes')

@section('content')
<h2 class="text-2xl font-bold mb-4">Enquetes</h2>

<div class="grid gap-4">
    @forelse($polls as $poll)
        <div class="bg-white p-4 rounded shadow flex justify-between items-center">
            <div>
                <h3 class="font-semibold">{{ $poll->title }}</h3>
                <p class="text-sm text-gray-500">
                    {{ $poll->startDate }} — {{ $poll->endDate }}
                </p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('polls.show', $poll->id) }}" class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">Ver</a>
                <a href="{{ route('polls.edit', $poll->id) }}" class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">Editar</a>
                <form action="{{ route('polls.destroy', $poll->id) }}" method="POST" onsubmit="return confirm('Deseja realmente excluir?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">Excluir</button>
                </form>
            </div>
        </div>
    @empty
        <p>Nenhuma enquete encontrada.</p>
    @endforelse
</div>
@endsection