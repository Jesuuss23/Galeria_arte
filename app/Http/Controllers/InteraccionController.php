<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Comentario;
use Illuminate\Support\Facades\Auth;

class InteraccionController extends Controller
{
    public function like($obraId)
    {
        $userId = Auth::id();
        $likeExistente = Like::where('usuario_id', $userId)->where('obra_id', $obraId)->first();

        if ($likeExistente) {
            $likeExistente->delete();
        } else {
            Like::create([
                'usuario_id' => $userId,
                'obra_id' => $obraId
            ]);
        }

        return back();
    }

    public function comentar(Request $request, $obraId)
    {
        $request->validate([
            'comentario' => 'required|min:3',
            'tipo' => 'required|in:critica,pregunta,positiva'
        ]);

        Comentario::create([
            'usuario_id' => Auth::id(),
            'obra_id' => $obraId,
            'comentario' => $request->comentario,
            'tipo' => $request->tipo
        ]);

        return back()->with('success', 'Comentario publicado.');
    }
}