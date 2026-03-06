{{-- resources/views/polls/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto flex flex-col gap-4">
    <h1 class="text-2xl font-bold mb-4">Enquetes Disponíveis</h1>

    @foreach($polls as $poll)
        <a href="{{ route('polls.vote', $poll) }}" class="block p-4 border rounded-lg hover:bg-gray-50 transition">
            <h2 class="font-semibold text-lg">{{ $poll->title }}</h2>
            <p class="text-sm text-gray-500">
                {{ $poll->start_date->format('d/m/Y H:i') }} — {{ $poll->end_date->format('d/m/Y H:i') }}
            </p>
        </a>
    @endforeach

    @if($polls->isEmpty())
        <p class="text-gray-500">Nenhuma enquete disponível no momento.</p>
    @endif
</div>
@endsection