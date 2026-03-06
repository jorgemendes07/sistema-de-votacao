{{-- resources/views/polls/vote.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto flex flex-col gap-6">

    <div>
        <h1 class="text-2xl sm:text-3xl font-bold">{{ $poll->title }}</h1>

        <div class="flex flex-wrap items-center gap-3 mt-2">
            @php
                $status = now()->lt($poll->start_date) ? 'not_started' : (now()->gt($poll->end_date) ? 'finished' : 'active');
            @endphp

            @if($status == 'active')
                <span class="bg-green-600 text-white px-2 py-1 rounded-full text-sm">Em andamento</span>
            @elseif($status == 'not_started')
                <span class="bg-yellow-500 text-white px-2 py-1 rounded-full text-sm">Não iniciada</span>
            @else
                <span class="bg-gray-400 text-white px-2 py-1 rounded-full text-sm">Finalizada</span>
            @endif

            <span class="text-sm text-gray-500">
                {{ $poll->start_date->format('d/m/Y H:i') }} — {{ $poll->end_date->format('d/m/Y H:i') }}
            </span>
        </div>
    </div>

    <form action="{{ route('polls.vote', $poll->id) }}" method="POST" class="flex flex-col gap-3">
        @csrf
        @foreach($poll->options as $option)
        @php
            $totalVotes = $poll->options->sum('votes');
            $pct = $totalVotes > 0 ? round($option->votes / $totalVotes * 100) : 0;
        @endphp

        <button 
            type="submit" 
            name="option_id" 
            value="{{ $option->id }}"
            class="relative overflow-hidden cursor-pointer transition-all p-4 rounded-lg border bg-white border-gray-300 shadow-sm hover:ring-2 hover:ring-violet-300
                {{ $status !== 'active' ? 'opacity-70 cursor-not-allowed' : '' }}"
            {{ $status !== 'active' ? 'disabled' : '' }}
        >
            <div class="absolute inset-0 bg-violet-100 transition-all duration-500" style="width: {{ $pct }}%"></div>
            <div class="relative flex items-center justify-between gap-3">
                <span class="font-medium">{{ $option->option_text }}</span>
                <div class="flex items-center gap-2 shrink-0">
                    <span class="text-violet-500 font-semibold">{{ $option->votes }} votos</span>
                    <span class="text-xs text-gray-500">({{ $pct }}%)</span>
                </div>
            </div>
        </button>
        @endforeach
    </form>

    @if($status !== 'active')
        <p class="text-sm text-gray-500 mt-2">
            {{ $status == 'not_started' ? 'A votação ainda não começou.' : 'A votação já foi encerrada.' }}
        </p>
    @endif

    @if(session('success'))
        <div id="toast" 
             class="fixed bottom-6 left-1/2 -translate-x-1/2 bg-gray-200 text-gray-900 px-4 py-2 rounded shadow-lg opacity-0 transition-opacity duration-500">
            {{ session('success') }}
        </div>
    @endif
</div>

@if(session('success'))
<script>
    const toast = document.getElementById('toast');
    toast.classList.add('opacity-100');

    setTimeout(() => {
        toast.classList.remove('opacity-100');
    }, 3000);
</script>
@endif

@endsection