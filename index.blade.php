<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fila de Moderação - {{ $evento->titulo }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-900">
    <main class="max-w-4xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-2">Fila de moderação</h1>
        <p class="text-gray-600 mb-6">Evento: {{ $evento->titulo }}</p>

        @if (session('status'))
            <div class="mb-4 rounded bg-green-100 p-3 text-green-800">{{ session('status') }}</div>
        @endif

        @forelse ($moderacoes as $moderacao)
            <article class="mb-4 rounded-lg bg-white p-5 shadow">
                <p class="mb-2"><strong>Pergunta:</strong> {{ $moderacao->pergunta->texto }}</p>
                <p class="mb-2"><strong>Motivo:</strong> {{ $moderacao->motivo }}</p>
                <p class="mb-4"><strong>Status:</strong> {{ $moderacao->status }}</p>

                @if ($moderacao->status === 'analisando')
                    <div class="flex gap-3">
                        <form method="POST" action="{{ route('moderacoes.status', $moderacao) }}">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="aprovada">
                            <button class="rounded bg-green-600 px-4 py-2 text-white hover:bg-green-700" type="submit">Aprovar pergunta</button>
                        </form>
                        <form method="POST" action="{{ route('moderacoes.status', $moderacao) }}">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="rejeitada">
                            <button class="rounded bg-red-600 px-4 py-2 text-white hover:bg-red-700" type="submit">Rejeitar pergunta</button>
                        </form>
                    </div>
                @endif
            </article>
        @empty
            <p class="rounded bg-white p-5 shadow">Não há denúncias para este evento.</p>
        @endforelse

        {{ $moderacoes->links() }}
    </main>
</body>
</html>
