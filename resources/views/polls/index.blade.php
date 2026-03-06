{{-- resources/views/polls/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto flex flex-col gap-4">
    <h1 class="text-2xl font-bold mb-4">Enquetes Disponíveis</h1>

    @foreach($polls as $poll)
        @php
            $status = now()->lt($poll->start_date) ? 'não iniciada' : (now()->gt($poll->end_date) ? 'finalizada' : 'em andamento');
            $statusClasses = match($status) {
                'em andamento' => 'bg-green-600 text-white',
                'não iniciada' => 'bg-yellow-500 text-white',
                'finalizada' => 'bg-gray-400 text-white',
            };
        @endphp

        <div class="bg-white p-4 border border-gray-400 rounded-lg hover:bg-gray-50 transition flex flex-col gap-2 relative">
            <div class="flex justify-between items-start">
                <h2 class="font-semibold text-lg">{{ $poll->title }}</h2>
                <span class="px-2 py-1 rounded-full text-xs {{ $statusClasses }}">{{ ucfirst($status) }}</span>
            </div>

            <p class="text-sm text-gray-500">
                {{ $poll->start_date->format('d/m/Y H:i') }} — {{ $poll->end_date->format('d/m/Y H:i') }}
            </p>

            <div class="flex gap-2 mt-2">
                <a href="{{ route('polls.vote', $poll) }}" 
                   class="px-3 py-1 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 transition text-sm">
                    Ver
                </a>

                <a href="{{ route('polls.edit', $poll) }}" 
                   class="px-3 py-1 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 transition text-sm">
                    Editar
                </a>

                <form action="{{ route('polls.destroy', $poll) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta enquete?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-700 transition text-sm">
                        Excluir
                    </button>
                </form>
            </div>
        </div>
    @endforeach

    @if($polls->isEmpty())
        <p class="text-gray-500">Nenhuma enquete disponível no momento.</p>
    @endif
</div>
@endsection