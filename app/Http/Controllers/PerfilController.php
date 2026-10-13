<?php
namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;

class PerfilController extends Controller
{
public function mostrarPublico(User $usuario)
{
    // Indicar explícitamente 'creado_en' a latest() o usar orderByDesc
    $obras = $usuario->obras()->latest('creado_en')->get();
    $servicios = $usuario->servicios()->where('activo', true)->get();

    return view('perfil.publico', compact('usuario', 'obras', 'servicios'));
}
}