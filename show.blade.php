@extends('layouts.app')

@section('title', $evento->titulo . ' — FalaQ')

@section('content')
<div class="row">
    <!-- Formulário de envio de Pergunta -->
    <div class="col-md-5 mb-4">
        <div class="card shadow-sm p-3">
            <h4 class="fw-bold mb-3">💬 Faça sua Pergunta</h4>
            <form action="{{ route('eventos.perguntas.store', $evento->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="texto" class="form-label text-secondary">Texto da Pergunta</label>
                    <textarea name="texto" id="texto" rows="4"
                              class="form-control bg-dark text-white border-secondary @error('texto') is-invalid @enderror"
                              placeholder="Digite sua dúvida ou comentário para o palestrante...">{{ old('texto') }}</textarea>
                    @error('texto')
                        <div class="invalid-feedback fw-bold">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary w-100 fw-bold">Enviar Pergunta</button>
            </form>
        </div>
    </div>

    <!-- Lista de Perguntas ordenada por votos -->
    <div class="col-md-7">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold m-0">📋 Perguntas do Evento</h4>
            <span class="text-secondary small">Total no Banco: {{ $evento->perguntas->count() }}</span>
        </div>

        @if(session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        @forelse($perguntas as $pergunta)
            <div class="card mb-3 shadow-sm border-start border-4 border-primary">
                <div class="card-body">
                    <p class="fs-5 mb-2 text-white">{{ $pergunta->texto }}</p>
                    <div class="d-flex justify-content-between align-items-center text-secondary small">
                        <span>Status: <span class="badge bg-success">{{ $pergunta->status }}</span></span>
                        <span>{{ $pergunta->created_at->format('d/m/Y H:i') }}</span>
                    </div>

                    <div class="d-flex align-items-center justify-content-between mt-3">
                        <span class="fw-bold">👍 {{ $pergunta->votos_count }} votos</span>
                        @auth
                            @php($jaVotou = $pergunta->votos->contains('id', auth()->id()))
                            <form action="{{ route('perguntas.votar', $pergunta) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm {{ $jaVotou ? 'btn-success' : 'btn-outline-primary' }}">
                                    {{ $jaVotou ? '✓ Votado (remover voto)' : '👍 Votar' }}
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login.create') }}" class="btn btn-sm btn-outline-secondary">Entre para votar</a>
                        @endauth
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-dark text-center p-4">
                Nenhuma pergunta pública enviada ainda. Seja o primeiro!
            </div>
        @endforelse
    </div>
</div>
@endsection
