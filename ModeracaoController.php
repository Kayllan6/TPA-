<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreModeracaoRequest;
use App\Models\Evento;
use App\Models\Moderacao;
use App\Models\Pergunta;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class ModeracaoController extends Controller
{
    use AuthorizesRequests;

    public function store(StoreModeracaoRequest $request, Pergunta $pergunta)
    {
        Moderacao::create([
            'pergunta_id' => $pergunta->id,
            'motivo' => $request->validated('motivo'),
            'status' => 'analisando',
        ]);

        return back()->with('status', 'Denúncia enviada para análise.');
    }

    public function index(Evento $evento)
    {
        $this->authorize('moderate', $evento);

        $moderacoes = Moderacao::with('pergunta')
            ->whereHas('pergunta', function ($query) use ($evento) {
                $query->where('evento_id', $evento->id);
            })
            ->latest()
            ->paginate(15);

        return view('moderacoes.index', compact('evento', 'moderacoes'));
    }

    public function updateStatus(Request $request, Moderacao $moderacao)
    {
        $moderacao->load('pergunta.evento');
        $this->authorize('moderate', $moderacao->pergunta->evento);

        $validated = $request->validate([
            'status' => ['required', 'in:aprovada,rejeitada'],
        ]);

        $moderacao->update(['status' => $validated['status']]);

        $moderacao->pergunta->update([
            'status' => $validated['status'],
            'is_public' => $validated['status'] === 'aprovada',
        ]);

        return back()->with('status', 'Decisão de moderação registrada.');
    }
}
