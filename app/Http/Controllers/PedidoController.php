<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Servicio;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    // Lista los pedidos del usuario (como cliente o como artista)
    public function index()
    {
        $userId = auth()->id();
        $compras = Pedido::with('artista', 'servicio')->where('cliente_id', $userId)->latest()->get();
        $encargos = Pedido::with('cliente', 'servicio')->where('artista_id', $userId)->latest()->get();

        return view('pedidos.index', compact('compras', 'encargos'));
    }

    // 1. El cliente crea la solicitud inicial
    public function store(Request $request)
    {
        $request->validate([
            'artista_id' => 'required|exists:users,id',
            'servicio_id' => 'nullable|exists:servicios,id',
            'instrucciones' => 'required|string',
            'archivo_referencia' => 'nullable|file|mimes:jpg,jpeg,png,pdf,zip|max:10240',
        ]);

        $artista = User::findOrFail($request->artista_id);

        // No se puede contratar a uno mismo
        if ($artista->id === auth()->id()) {
            return back()->with('error', 'No puedes enviarte un encargo a ti mismo.');
        }

        if (!$artista->es_publico) {
            return back()->with('error', 'El artista no está recibiendo nuevos encargos por el momento.');
        }

        // Si se eligió un servicio, debe pertenecer a ese artista
        if ($request->servicio_id) {
            $servicioValido = Servicio::where('id', $request->servicio_id)
                ->where('user_id', $artista->id)
                ->exists();

            if (!$servicioValido) {
                return back()->with('error', 'El servicio seleccionado no pertenece a este artista.');
            }
        }

        $rutaReferencia = null;
        if ($request->hasFile('archivo_referencia')) {
            $rutaReferencia = $request->file('archivo_referencia')->store('referencias', 'public');
        }

        Pedido::create([
            'cliente_id' => auth()->id(),
            'artista_id' => $artista->id,
            'servicio_id' => $request->servicio_id,
            'instrucciones' => $request->instrucciones,
            'archivo_referencia' => $rutaReferencia,
            'estado' => 'solicitado'
        ]);

        return redirect()->route('pedidos.index')->with('success', 'Solicitud enviada con éxito.');
    }

    // 2. El artista envía la cotización formal (precio y fecha límite)
    public function cotizar(Request $request, Pedido $pedido)
    {
        abort_if((int) auth()->id() !== (int) $pedido->artista_id || $pedido->estado !== 'solicitado', 403);

        $request->validate([
            'precio_acordado' => 'required|numeric|min:1',
            'fecha_limite' => 'required|date|after:today',
        ]);

        $pedido->update([
            'precio_acordado' => $request->precio_acordado,
            'fecha_limite' => $request->fecha_limite,
            'estado' => 'cotizado'
        ]);

        return back()->with('success', 'Cotización enviada al cliente.');
    }

    // 3. El cliente acepta y paga en custodia (Escrow)
    public function pagarCustodia(Pedido $pedido)
    {
        $cliente = auth()->user();
        abort_if($cliente->id !== $pedido->cliente_id || $pedido->estado !== 'cotizado', 403);

        // Validar saldo suficiente
        if ($cliente->saldo_disponible < $pedido->precio_acordado) {
            return back()->with('error', 'Saldo insuficiente. Recarga al menos S/ ' . number_format($pedido->precio_acordado - $cliente->saldo_disponible, 2) . ' en tu panel para contratar.');
        }

        DB::transaction(function () use ($pedido, $cliente) {
            $monto = $pedido->precio_acordado;
            $comision = round($monto * 0.10, 2);

            // Descontar saldo disponible del cliente y mover a custodia
            $cliente->decrement('saldo_disponible', $monto);
            $cliente->increment('saldo_retenido', $monto);

            $pedido->update([
                'comision_plataforma' => $comision,
                'estado' => 'pagado_custodia'
            ]);
        });

        return back()->with('success', 'Pago retenido exitosamente en custodia. El artista puede comenzar a trabajar.');
    }

    // 4. El artista entrega el trabajo terminado
    public function entregar(Request $request, Pedido $pedido)
    {
        abort_if((int) auth()->id() !== (int) $pedido->artista_id || $pedido->estado !== 'pagado_custodia', 403);

        $request->validate([
            'archivo_entrega_final' => 'required|file|mimes:jpg,jpeg,png,pdf,zip|max:20480',
        ]);

        $rutaEntrega = $request->file('archivo_entrega_final')->store('entregas', 'public');

        $pedido->update([
            'archivo_entrega_final' => $rutaEntrega,
            'estado' => 'entregado'
        ]);

        return back()->with('success', 'Trabajo entregado. Esperando la aprobación del cliente.');
    }

    // 5. El cliente aprueba la entrega: se liberan los fondos al artista
    public function aprobarEntrega(Pedido $pedido)
    {
        $cliente = auth()->user();
        abort_if($cliente->id !== $pedido->cliente_id || $pedido->estado !== 'entregado', 403);

        DB::transaction(function () use ($pedido, $cliente) {
            $montoTotal = $pedido->precio_acordado;
            $comision = round($montoTotal * 0.10, 2);
            $pagoNetoArtista = $montoTotal - $comision;

            // 1. Liberar la retención del cliente (debe volver a bajar)
            $cliente->decrement('saldo_retenido', $montoTotal);

            // 2. Acreditar las ganancias netas al artista
            $pedido->artista->increment('saldo_disponible', $pagoNetoArtista);

            // 3. Finalizar el pedido
            $pedido->update([
                'comision_plataforma' => $comision,
                'estado' => 'completado'
            ]);
        });

        return back()->with('success', 'Entrega aprobada con éxito. Se liberaron los fondos y la custodia quedó liquidada.');
    }

    // 6. El cliente rechaza la entrega y abre una disputa
    public function abrirDisputa(Request $request, Pedido $pedido)
    {
        abort_if((int) auth()->id() !== (int) $pedido->cliente_id || $pedido->estado !== 'entregado', 403);

        $request->validate([
            'motivo_rechazo' => 'required|string|min:10',
        ]);

        $pedido->update([
            'motivo_rechazo' => $request->motivo_rechazo,
            'estado' => 'en_disputa'
        ]);

        return back()->with('warning', 'Disputa registrada. El soporte evaluará las especificaciones.');
    }
}