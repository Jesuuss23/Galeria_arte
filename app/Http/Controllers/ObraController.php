<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Obra;
use App\Models\Categoria;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class ObraController extends Controller
{
    // Catálogo con buscador y filtros
    public function index(Request $request)
    {
        $categorias = \App\Models\Categoria::all();

        // Query base con relaciones y conteo de likes
        $query = Obra::with(['categoria', 'usuario'])
            ->withCount('likes');

        // Filtro por buscador (título)
        if ($request->filled('buscar')) {
            $query->where('titulo', 'LIKE', '%' . $request->buscar . '%');
        }

        // Filtro por categoría
        if ($request->filled('categoria_id')) {
            $query->where('categoria_id', $request->categoria_id);
        }

        // Ordenamiento: Populares (más likes) o Recientes (por defecto)
        if ($request->orden === 'populares') {
            $query->orderByDesc('likes_count')->latest('id');
        } else {
            $query->latest('id');
        }

        // Paginación de 12 obras por página manteniendo los parámetros de búsqueda en la URL
        $obras = $query->paginate(12)->withQueryString();

        return view('obras.index', compact('obras', 'categorias'));
    }

    public function show($id)
    {
        $obra = Obra::with(['usuario', 'categoria', 'comentarios.usuario', 'likes'])->findOrFail($id);
        return view('obras.show', compact('obra'));
    }

    public function create()
    {
        $categorias = Categoria::all();
        return view('obras.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|max:150',
            'categoria_id' => 'required|exists:categorias,id',
            'descripcion' => 'nullable',
            'herramientas' => 'nullable|string|max:255',
            'imagen' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $file = $request->file('imagen');

        // --- VALIDACIÓN DE CONTENIDO EXPLÍCITO (+18) ---
        $apiUser = env('SIGHTENGINE_USER', '');
        $apiSecret = env('SIGHTENGINE_SECRET', '');

        if ($apiUser && $apiSecret) {
            try {
                $response = Http::withoutVerifying()->attach(
                    'media', file_get_contents($file->getRealPath()), $file->getClientOriginalName()
                )->post('https://api.sightengine.com/1.0/check.json', [
                    'models' => 'nudity-2.0',
                    'api_user' => $apiUser,
                    'api_secret' => $apiSecret,
                ]);

                if ($response->successful()) {
                    $data = $response->json();

                    // Puntuaciones del modelo nudity-2.0
                    $sexualActivity = $data['nudity']['sexual_activity'] ?? 0;
                    $sexualDisplay  = $data['nudity']['sexual_display'] ?? 0;
                    $erotica        = $data['nudity']['erotica'] ?? 0;

                    // Genitales específicos (masculinos o femeninos expuestos)
                    $genitalesExpuestos = $data['nudity']['genitalia']['exposed'] ?? 0;
                    $genitalesCovered   = $data['nudity']['genitalia']['covered'] ?? 0;

                    // Condición estricta: actividad, exhibición sexual, genitales expuestos o erotismo alto
                    $esInapropiado = ($sexualActivity > 0.4)
                                || ($sexualDisplay > 0.4)
                                || ($genitalesExpuestos > 0.3)
                                || ($erotica > 0.6);

                    if ($esInapropiado) {
                        return back()->withErrors([
                            'imagen' => 'La imagen fue rechazada por nuestro filtro de seguridad por contener contenido explícito (+18).'
                        ])->withInput();
                    }
                }
            } catch (\Exception $e) {
                // Si falla la conexión a internet, continúa sin romper la subida
            }
        }
        // ----------------------------------------------

        // Guardar la imagen localmente en storage/app/public/obras
        $nombreArchivo = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('obras', $nombreArchivo, 'public');

        Obra::create([
            'usuario_id' => Auth::id(),
            'categoria_id' => $request->categoria_id,
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'herramientas' => $request->herramientas,
            'archivo_imagen' => $nombreArchivo,
        ]);

        return redirect()->route('obras.index')->with('success', '¡Obra publicada con éxito!');
    }

    // Ver perfil con mis obras y estadísticas/comentarios
    public function miPerfil()
    {
        $usuario = Auth::user();

        // Traer las obras del usuario autenticado con sus comentarios y likes
        $misObras = Obra::with(['categoria', 'likes', 'comentarios.usuario'])
            ->where('usuario_id', $usuario->id)
            ->latest('id')
            ->get();

        // Contar total de likes acumulados en todas sus obras
        $totalLikes = $misObras->sum(function ($obra) {
            return $obra->likes->count();
        });

        return view('obras.perfil', compact('misObras', 'totalLikes', 'usuario'));
    }

    // Eliminar una obra propia
    public function destroy($id)
    {
        $obra = Obra::where('id', $id)->where('usuario_id', Auth::id())->firstOrFail();

        // Eliminar archivo físico si existe
        if (\Illuminate\Support\Facades\Storage::disk('public')->exists('obras/' . $obra->archivo_imagen)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete('obras/' . $obra->archivo_imagen);
        }

        $obra->delete();

        return back()->with('success', 'Obra eliminada con éxito.');
    }
    public function guardarAjustesPerfil(Request $request)
    {
        $request->validate([
            'bio' => 'nullable|string|max:255',
            'contacto_url' => 'nullable|url|max:255',
        ]);

        $usuario = Auth::user();
        $usuario->es_anonimo = $request->has('es_anonimo') ? 1 : 0;
        $usuario->bio = $request->bio;
        $usuario->contacto_url = $request->contacto_url;
        $usuario->save();

        return back()->with('success', 'Perfil y datos de contacto actualizados correctamente.');
    }
}