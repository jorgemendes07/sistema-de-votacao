<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistema de Votação')</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="bg-gray-100 min-h-screen font-sans">

    <header class="bg-white shadow p-4">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            @if(View::hasSection('showBackButton') && View::getSection('showBackButton'))
                <a href="{{ route('polls.index') }}" class="text-gray-800 border-2 border-gray-500 rounded py-1 px-2 hover:bg-gray-100 hover:shadow-md flex items-center gap-1">
                    <i class="fas fa-arrow-left"></i> Voltar
                </a>
            @else
                <h1 class="text-xl font-bold">Sistema de Votação</h1>
                <nav class="flex gap-4">
                    <a href="{{ route('polls.create') }}" class="bg-violet-500 text-white py-1 px-2 rounded text-white hover:bg-violet-600 hover:shadow-md">
                        <i class="fas fa-plus"></i> Nova Enquete</a>
                </nav>
            @endif
        </div>
    </header>

    <main class="max-w-6xl mx-auto p-4">
        @yield('content')
    </main>

</body>
</html>