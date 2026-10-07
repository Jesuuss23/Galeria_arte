<?php

use App\Http\Controllers\ObraController;
use App\Http\Controllers\InteraccionController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\BilleteraController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PerfilController;
// Redirigir dashboard al inicio de la galería
Route::get('/dashboard', function () {
    return redirect()->route('obras.index');
})->name('dashboard');

// Catálogo público
Route::get('/', [ObraController::class, 'index'])->name('obras.index');
Route::get('/obra/{id}', [ObraController::class, 'show'])->name('obras.show');
Route::get('/artista/{usuario}', [PerfilController::class, 'mostrarPublico'])->name('perfil.artista');

// Ruta pública para servir imágenes
Route::get('/imagenes/{archivo}', function ($archivo) {
    // 1. Probar en public/obras
    if (Storage::disk('public')->exists('obras/' . $archivo)) {
        return response()->file(Storage::disk('public')->path('obras/' . $archivo));
    }
    // 2. Probar directo en la raíz pública por si se guardó sin la subcarpeta
    if (Storage::disk('public')->exists($archivo)) {
        return response()->file(Storage::disk('public')->path($archivo));
    }
    // 3. Probar en storage local normal
    if (Storage::exists($archivo)) {
        return response()->file(storage_path('app/' . $archivo));
    }

    abort(404);
})->name('imagen.mostrar');

// Rutas protegidas por login
Route::middleware(['auth'])->group(function () {
    Route::get('/subir-arte', [ObraController::class, 'create'])->name('obras.create');
    Route::post('/subir-arte', [ObraController::class, 'store'])->name('obras.store');
    
    Route::post('/obra/{id}/like', [InteraccionController::class, 'like'])->name('obras.like');
    Route::post('/obra/{id}/comentar', [InteraccionController::class, 'comentar'])->name('obras.comentar');

    Route::get('/mi-perfil', [ObraController::class, 'miPerfil'])->name('obras.perfil');
    Route::delete('/obra/{id}', [ObraController::class, 'destroy'])->name('obras.destroy');

    Route::post('/perfil/ajustes', [ObraController::class, 'guardarAjustesPerfil'])->name('perfil.ajustes');

    Route::get('/pedidos', [PedidoController::class, 'index'])->name('pedidos.index');
    Route::post('/pedidos', [PedidoController::class, 'store'])->name('pedidos.store');
    Route::post('/pedidos/{pedido}/cotizar', [PedidoController::class, 'cotizar'])->name('pedidos.cotizar');
    Route::post('/pedidos/{pedido}/pagar', [PedidoController::class, 'pagarCustodia'])->name('pedidos.pagar');
    Route::post('/pedidos/{pedido}/entregar', [PedidoController::class, 'entregar'])->name('pedidos.entregar');
    Route::post('/pedidos/{pedido}/aprobar', [PedidoController::class, 'aprobarEntrega'])->name('pedidos.aprobar');
    Route::post('/pedidos/{pedido}/disputar', [PedidoController::class, 'abrirDisputa'])->name('pedidos.disputar');

    Route::post('/billetera/recargar', [BilleteraController::class, 'recargar'])->name('billetera.recargar');
    // CRUD de Servicios para Artistas
    Route::post('/servicios', [ServicioController::class, 'store'])->name('servicios.store');
    Route::delete('/servicios/{servicio}', [ServicioController::class, 'destroy'])->name('servicios.destroy');
    Route::post('/billetera/retirar', [BilleteraController::class, 'retirar'])->name('billetera.retirar');

    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/admin/pedidos/{pedido}/favor-artista', [AdminController::class, 'resolverAFavorArtista'])->name('admin.pedidos.favorArtista');
    Route::post('/admin/pedidos/{pedido}/favor-cliente', [AdminController::class, 'resolverAFavorCliente'])->name('admin.pedidos.favorCliente');
});

require __DIR__.'/auth.php';