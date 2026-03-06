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
            <h1 class="text-xl font-bold">Sistema de Votação</h1>
            <nav class="flex gap-4">
                <a href="{{ route('polls.index') }}" class="text-gray-700 hover:text-gray-900">Enquetes</a>
                <a href="{{ route('polls.create') }}" class="text-gray-700 hover:text-gray-900">Nova Enquete</a>
            </nav>
        </div>
    </header>

    <main class="max-w-6xl mx-auto p-4">
        @yield('content')
    </main>
</body>
</html>