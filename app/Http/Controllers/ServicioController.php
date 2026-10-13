<?php
namespace App\Http\Controllers;

use App\Models\Servicio;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:150',
            'descripcion' => 'required|string|max:1000',
            'precio_base' => 'required|numeric|min:5',
            'dias_entrega' => 'required|integer|min:1|max:90',
        ]);

        auth()->user()->servicios()->create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'precio_base' => $request->precio_base,
            'dias_entrega' => $request->dias_entrega,
            'activo' => true,
        ]);

        return back()->with('success', 'Servicio publicado con éxito en tu catálogo de artista.');
    }

    public function destroy(Servicio $servicio)
    {
        abort_if(auth()->id() !== $servicio->user_id, 403);
        $servicio->delete();

        return back()->with('success', 'Servicio retirado de tu catálogo.');
    }
}