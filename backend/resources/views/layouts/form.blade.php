@extends('layouts.app')

@section('title', $poll->id ? 'Editar Enquete' : 'Nova Enquete')

@section('content')
<h2 class="text-2xl font-bold mb-4">{{ $poll->id ? 'Editar Enquete' : 'Nova Enquete' }}</h2>

<form action="{{ $poll->id ? route('polls.update', $poll->id) : route('polls.store') }}" method="POST" class="bg-white p-6 rounded shadow flex flex-col gap-4">
    @csrf
    @if($poll->id)
        @method('PUT')
    @endif

    <label class="flex flex-col">
        <span class="font-semibold mb-1">Título</span>
        <input type="text" name="title" value="{{ old('title', $poll->title ?? '') }}" class="border p-2 rounded">
    </label>

    <label class="flex flex-col">
        <span class="font-semibold mb-1">Data de Início</span>
        <input type="datetime-local" name="startDate" value="{{ old('startDate', $poll->startDate ?? '') }}" class="border p-2 rounded">
    </label>

    <label class="flex flex-col">
        <span class="font-semibold mb-1">Data de Término</span>
        <input type="datetime-local" name="endDate" value="{{ old('endDate', $poll->endDate ?? '') }}" class="border p-2 rounded">
    </label>

    <div class="flex flex-col gap-2">
        <span class="font-semibold mb-1">Opções</span>
        @for($i = 0; $i < max(old('options') ? count(old('options')) : ($poll->options->count() ?? 3), 3); $i++)
            <input type="text" name="options[]" value="{{ old('options.'.$i, $poll->options[$i]->option_text ?? '') }}" class="border p-2 rounded">
        @endfor
    </div>

    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 mt-4">
        {{ $poll->id ? 'Salvar Alterações' : 'Criar Enquete' }}
    </button>
</form>
@endsection