<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BilleteraController extends Controller
{
    public function recargar(Request $request)
    {
        $request->validate([
            'monto' => 'required|numeric|min:5|max:10000',
            'titular' => 'required|string|max:100',
            'numero_tarjeta' => 'required|string|min:16|max:19',
            'expiracion' => 'required|string',
            'cvv' => 'required|string|min:3|max:4',
        ]);

        $user = auth()->user();
        $user->increment('saldo_disponible', $request->monto);

        return back()->with('success', '¡Recarga exitosa! Se han agregado S/ ' . number_format($request->monto, 2) . ' a tu saldo.');
    }
    public function retirar(Request $request)
    {
        $request->validate([
            'monto_retiro' => 'required|numeric|min:100',
            'banco'        => 'required|string|max:50',
            'cci'          => 'required|string|min:20|max:20',
            'titular'      => 'required|string|max:100',
        ], [
            'monto_retiro.min' => 'El monto mínimo para solicitar un retiro es de S/ 100.00.',
            'cci.min'          => 'El código de cuenta interbancario (CCI) debe contener exactamente 20 dígitos.',
            'cci.max'          => 'El código de cuenta interbancario (CCI) debe contener exactamente 20 dígitos.',
        ]);

        $user = auth()->user();

        if ($user->saldo_disponible < $request->monto_retiro) {
            return back()->with('error', 'Saldo disponible insuficiente para procesar el retiro.');
        }

        $user->decrement('saldo_disponible', $request->monto_retiro);

        return back()->with('success', 'Solicitud de retiro de S/ ' . number_format($request->monto_retiro, 2) . ' enviada con éxito a tu cuenta bancaria (' . $request->banco . ').');
    }
}