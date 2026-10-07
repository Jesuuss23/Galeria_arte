<?php

namespace App\Http\Controllers;

use App\Models\Obra;
use App\Models\Pedido;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        // Validar que el usuario sea administrador
        abort_unless(auth()->check() && auth()->user()->es_admin, 403, 'Acceso exclusivo para administradores.');

        $hoy = Carbon::today();
        $hace7Dias = Carbon::today()->subDays(7);
        $inicioMes = Carbon::now()->startOfMonth();
        $inicioAno = Carbon::now()->startOfYear();

        // 1. Métricas de contenido y usuarios
        $totalObras = Obra::count();
        $obrasHoy = Obra::whereDate('creado_en', $hoy)->count();
        $totalUsuarios = User::count();
        $pedidosCompletados = Pedido::where('estado', 'completado')->count();

        // 2. Ingresos por comisiones de la plataforma (10% de cada pedido completado)
        $comisionesHoy = Pedido::where('estado', 'completado')
            ->whereDate('updated_at', $hoy)
            ->sum('comision_plataforma');

        $comisionesSemana = Pedido::where('estado', 'completado')
            ->where('updated_at', '>=', $hace7Dias)
            ->sum('comision_plataforma');

        $comisionesMes = Pedido::where('estado', 'completado')
            ->where('updated_at', '>=', $inicioMes)
            ->sum('comision_plataforma');

        $comisionesAno = Pedido::where('estado', 'completado')
            ->where('updated_at', '>=', $inicioAno)
            ->sum('comision_plataforma');

        // 3. Pedidos en disputa que requieren resolución del administrador
        $disputasPendientes = Pedido::with(['cliente', 'artista', 'servicio'])
            ->where('estado', 'en_disputa')
            ->latest('updated_at')
            ->get();

        // 4. Historial reciente de auditorías resueltas
        $disputasResueltas = Pedido::with(['cliente', 'artista'])
            ->whereIn('estado', ['completado', 'reembolsado'])
            ->whereNotNull('resolucion_admin')
            ->latest('updated_at')
            ->take(6)
            ->get();

        return view('admin.dashboard', compact(
            'totalObras',
            'obrasHoy',
            'totalUsuarios',
            'pedidosCompletados',
            'comisionesHoy',
            'comisionesSemana',
            'comisionesMes',
            'comisionesAno',
            'disputasPendientes',
            'disputasResueltas'
        ));
    }

    // Resolución: Liberar fondos al artista (Cumplió los requerimientos)
    public function resolverAFavorArtista(Request $request, Pedido $pedido)
    {
        abort_unless(auth()->user()->es_admin, 403);
        abort_if($pedido->estado !== 'en_disputa', 400);

        $request->validate([
            'resolucion_admin' => 'required|string|min:10',
        ]);

        DB::transaction(function () use ($pedido, $request) {
            $montoTotal = $pedido->precio_acordado;
            $comision = round($montoTotal * 0.10, 2);
            $pagoNeto = $montoTotal - $comision;

            // Retirar de la custodia del cliente
            $pedido->cliente->decrement('saldo_retenido', $montoTotal);

            // Acreditar el saldo al artista
            $pedido->artista->increment('saldo_disponible', $pagoNeto);

            $pedido->update([
                'comision_plataforma' => $comision,
                'resolucion_admin' => 'A favor del artista: ' . $request->resolucion_admin,
                'estado' => 'completado'
            ]);
        });

        return back()->with('success', 'Disputa resuelta a favor del artista. Se transfirió el saldo neto al autor.');
    }

    // Resolución: Reembolsar dinero al cliente (Artista no cumplió el brief)
    public function resolverAFavorCliente(Request $request, Pedido $pedido)
    {
        abort_unless(auth()->user()->es_admin, 403);
        abort_if($pedido->estado !== 'en_disputa', 400);

        $request->validate([
            'resolucion_admin' => 'required|string|min:10',
        ]);

        DB::transaction(function () use ($pedido, $request) {
            $montoTotal = $pedido->precio_acordado;

            // Retirar de custodia y devolver al saldo disponible del cliente
            $pedido->cliente->decrement('saldo_retenido', $montoTotal);
            $pedido->cliente->increment('saldo_disponible', $montoTotal);

            $pedido->update([
                'comision_plataforma' => 0.00,
                'resolucion_admin' => 'Reembolso al cliente: ' . $request->resolucion_admin,
                'estado' => 'reembolsado'
            ]);
        });

        return back()->with('warning', 'Disputa resuelta a favor del cliente. Se ha reembolsado el 100% de los fondos.');
    }
}