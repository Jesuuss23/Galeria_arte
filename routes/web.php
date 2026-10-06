<?php

use App\Http\Controllers\ObraController;
use App\Http\Controllers\InteraccionController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

// Redirigir dashboard al inicio de la galería
Route::get('/dashboard', function () {
    return redirect()->route('obras.index');
})->name('dashboard');

// Catálogo público
Route::get('/', [ObraController::class, 'index'])->name('obras.index');
Route::get('/obra/{id}', [ObraController::class, 'show'])->name('obras.show');

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
});

require __DIR__.'/auth.php';