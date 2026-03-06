{{-- resources/views/polls/edit.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto flex flex-col gap-6">

    <h1 class="text-2xl font-bold">Editar Enquete</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('polls.update', $poll->id) }}" method="POST" class="flex flex-col gap-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block font-medium mb-1" for="title">Título da Enquete</label>
            <input 
                type="text" 
                name="title" 
                id="title" 
                value="{{ old('title', $poll->title) }}" 
                class="w-full border rounded px-3 py-2"
                required
            >
        </div>

        <div class="flex gap-4">
            <div class="flex-1">
                <label class="block font-medium mb-1" for="start_date">Data de Início</label>
                <input 
                    type="datetime-local" 
                    name="start_date" 
                    id="start_date" 
                    value="{{ old('start_date', $poll->start_date->format('Y-m-d\TH:i')) }}" 
                    class="w-full border rounded px-3 py-2"
                    required
                >
            </div>

            <div class="flex-1">
                <label class="block font-medium mb-1" for="end_date">Data de Término</label>
                <input 
                    type="datetime-local" 
                    name="end_date" 
                    id="end_date" 
                    value="{{ old('end_date', $poll->end_date->format('Y-m-d\TH:i')) }}" 
                    class="w-full border rounded px-3 py-2"
                    required
                >
            </div>
        </div>

        <div id="options-wrapper" class="flex flex-col gap-2">
            <label class="block font-medium mb-1">Opções</label>
            @foreach($poll->options as $index => $option)
                <input 
                    type="text" 
                    name="options[]" 
                    value="{{ old('options.'.$index, $option->option_text) }}" 
                    class="w-full border rounded px-3 py-2" 
                    placeholder="Opção {{ $index + 1 }}"
                    required
                >
            @endforeach
        </div>

        <button type="button" id="add-option" class="self-start text-blue-600 hover:underline">+ Adicionar opção</button>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition cursor-pointer">
            Salvar Enquete
        </button>
    </form>
</div>

<script>
document.getElementById('add-option').addEventListener('click', function() {
    const wrapper = document.getElementById('options-wrapper');
    const inputCount = wrapper.querySelectorAll('input').length;
    const input = document.createElement('input');
    input.type = 'text';
    input.name = 'options[]';
    input.placeholder = `Opção ${inputCount + 1}`;
    input.className = 'w-full border rounded px-3 py-2';
    wrapper.appendChild(input);
});
</script>
@endsection