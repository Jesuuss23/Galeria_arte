<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de {{ $usuario->nombreVisible() }}</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --bg: #0a0a12;
            --glass: rgba(255, 255, 255, 0.045);
            --glass-strong: rgba(255, 255, 255, 0.075);
            --line: rgba(255, 255, 255, 0.09);
            --text: #e9e9f4;
            --muted: #8d8da6;
            --violet: #8b5cf6;
            --pink: #ec4899;
            --cyan: #22d3ee;
        }
        body { background: var(--bg); color: var(--text); font-family: 'Inter', sans-serif; }
        .glass { background: var(--glass); border: 1px solid var(--line); backdrop-filter: blur(22px); }
        .btn-ghost { padding: .5rem .9rem; border-radius: .8rem; font-size: .85rem; color: var(--text); background: var(--glass-strong); border: 1px solid var(--line); }
        .btn-ghost:hover { border-color: rgba(167,139,250,.55); }
        .field { width: 100%; padding: .75rem 1rem; border-radius: .75rem; background: rgba(0,0,0,.4); border: 1px solid var(--line); color: var(--text); }
        .field:focus { outline: none; border-color: rgba(139,92,246,.7); }
    </style>
</head>
<body class="min-h-screen relative pb-16">

    <!-- Navbar -->
    <nav class="px-6 py-4 border-b border-white/10 sticky top-0 z-50 bg-[#0a0a12]/80 backdrop-blur-md flex justify-between items-center">
        <a href="{{ route('obras.index') }}" class="font-bold text-lg text-white">🎨 Galería Creativa</a>
        <div class="flex items-center gap-3">
            <a href="{{ route('obras.index') }}" class="btn-ghost">Explorar Galería</a>
            @auth
                <a href="{{ route('pedidos.index') }}" class="btn-ghost">Mis Contrataciones</a>
            @endauth
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-4 sm:px-6 py-8">

        <!-- Banner de Perfil -->
        <div class="glass rounded-3xl p-6 sm:p-8 mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div class="flex items-center gap-5">
                <div class="w-20 h-20 rounded-full bg-gradient-to-tr from-violet-600 to-pink-500 flex items-center justify-center text-3xl font-bold font-mono text-white shadow-xl shadow-violet-500/30">
                    {{ mb_strtoupper(mb_substr($usuario->nombreVisible(), 0, 1)) }}
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h1 class="text-2xl sm:text-3xl font-bold text-white">{{ $usuario->nombreVisible() }}</h1>
                        @if($usuario->es_anonimo)
                            <span class="text-[0.65rem] px-2 py-0.5 rounded-full bg-slate-800 text-slate-400 border border-slate-700">Identidad Reservada</span>
                        @endif
                    </div>

                    @if(!$usuario->es_anonimo && $usuario->bio)
                        <p class="text-sm text-slate-300 mt-1 max-w-xl">{{ $usuario->bio }}</p>
                    @endif

                    @if(!$usuario->es_anonimo && $usuario->contacto_url)
                        <a href="{{ $usuario->contacto_url }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs text-cyan-400 hover:text-cyan-300 underline mt-2">
                            🔗 Portafolio / Red Externa
                        </a>
                    @endif
                </div>
            </div>

            <!-- Badge de Disponibilidad Escrow -->
            <div class="flex flex-col items-start md:items-end gap-1">
                @if($usuario->es_publico)
                    <span class="px-3.5 py-1.5 rounded-full text-xs font-semibold bg-emerald-500/15 border border-emerald-500/30 text-emerald-400 flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span> Disponible para Contrataciones
                    </span>
                    <span class="text-[0.7rem] text-slate-400">Acepta pedidos mediante custodia</span>
                @else
                    <span class="px-3.5 py-1.5 rounded-full text-xs font-semibold bg-slate-800 border border-slate-700 text-slate-400">
                        🔒 No recibe nuevos encargos
                    </span>
                    <span class="text-[0.7rem] text-slate-500">Perfil actualmente privado</span>
                @endif
            </div>
        </div>

        <!-- SECCIÓN 1: SERVICIOS OFRECIDOS Y SOLICITUD DE ENCARGO -->
        <div class="glass rounded-3xl p-6 sm:p-8 mb-10 border-violet-500/20">
            <h2 class="text-xl font-bold text-white mb-2">Comisiones y Servicios Disponibles</h2>
            <p class="text-xs text-slate-400 mb-6">Contrata directamente a este creador. El dinero se retiene de forma segura hasta que apruebes la entrega final.</p>

            @if($usuario->es_publico)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                    @forelse($servicios as $s)
                        <div class="p-5 rounded-2xl bg-white/[0.03] border border-white/10 flex flex-col justify-between">
                            <div>
                                <div class="flex justify-between items-start gap-2 mb-2">
                                    <h3 class="font-semibold text-white text-base">{{ $s->titulo }}</h3>
                                    <span class="text-sm font-bold text-violet-300">S/ {{ number_format($s->precio_base, 2) }}</span>
                                </div>
                                <p class="text-xs text-slate-300 mb-4 leading-relaxed">{{ $s->descripcion }}</p>
                            </div>
                            <div class="flex justify-between items-center text-xs text-slate-400 pt-3 border-t border-white/5">
                                <span>⏱️ Entrega estimada: {{ $s->dias_entrega }} días</span>
                                <button type="button" onclick="seleccionarServicio({{ $s->id }}, '{{ addslashes($s->titulo) }}')" class="px-3 py-1.5 rounded-lg bg-violet-600 hover:bg-violet-500 text-white font-medium text-xs">
                                    Contratar este servicio
                                </button>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 italic md:col-span-2">El artista aún no tiene servicios predefinidos, pero puedes enviarle una solicitud personalizada abajo.</p>
                    @endforelse
                </div>

                <!-- Formulario de Encargo / Escrow -->
                @if(auth()->check() && auth()->id() !== $usuario->id)
                    <div class="p-6 rounded-2xl bg-black/40 border border-white/10" id="seccion-solicitud">
                        <h3 class="text-base font-semibold text-white mb-1">Enviar Solicitud de Proyecto al Artista</h3>
                        <p class="text-xs text-slate-400 mb-4">El artista recibirá tu mensaje y te enviará una cotización con monto exacto y fecha de entrega.</p>

                        <form action="{{ route('pedidos.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            <input type="hidden" name="artista_id" value="{{ $usuario->id }}">
                            <input type="hidden" name="servicio_id" id="servicio_id_input" value="">

                            <div id="servicio_seleccionado_alerta" class="hidden text-xs p-3 rounded-xl bg-violet-500/10 border border-violet-500/30 text-violet-300 flex justify-between items-center">
                                <span id="servicio_seleccionado_texto"></span>
                                <button type="button" onclick="limpiarServicio()" class="text-rose-400 hover:underline">Quitar</button>
                            </div>

                            <div>
                                <label class="block text-xs uppercase tracking-wider font-semibold text-slate-400 mb-2">Instrucciones y Requerimientos del Encargo</label>
                                <textarea name="instrucciones" rows="3" class="field text-sm" placeholder="Describe dimensiones, temática, personajes, estilo deseado y detalles clave..." required></textarea>
                            </div>

                            <div>
                                <label class="block text-xs uppercase tracking-wider font-semibold text-slate-400 mb-2">Archivo o Boceto de Referencia (Opcional)</label>
                                <input type="file" name="archivo_referencia" class="field text-xs">
                            </div>

                            <button type="submit" class="w-full sm:w-auto px-6 py-2.5 rounded-xl font-semibold text-sm text-white bg-gradient-to-r from-violet-600 to-pink-600 hover:from-violet-500 hover:to-pink-500 shadow-lg shadow-violet-500/25">
                                📩 Enviar Solicitud de Cotización
                            </button>
                        </form>
                    </div>
                @elseif(!auth()->check())
                    <div class="p-4 rounded-xl bg-white/5 border border-white/10 text-center text-xs text-slate-400">
                        <a href="{{ route('login') }}" class="text-violet-400 underline font-semibold">Inicia sesión</a> para enviar una propuesta de contratación a este artista.
                    </div>
                @endif

            @else
                <div class="p-8 text-center rounded-2xl bg-black/20 border border-dashed border-white/10 text-slate-400 text-sm">
                    🔒 Este artista ha pausado la recepción de nuevas órdenes y encargos por el momento.
                </div>
            @endif
        </div>

        <!-- SECCIÓN 2: OBRAS PUBLICADAS DEL ARTISTA -->
        <div>
            <h2 class="text-xl font-bold text-white mb-6">Galería de Obras ({{ $obras->count() }})</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($obras as $obra)
                    <div class="glass rounded-2xl overflow-hidden flex flex-col justify-between border border-white/10">
                        <div>
                            <img src="{{ route('imagen.mostrar', $obra->archivo_imagen) }}" alt="{{ $obra->titulo }}" class="w-full h-48 object-cover">
                            <div class="p-4">
                                <span class="text-[0.65rem] uppercase tracking-wider px-2 py-0.5 rounded-full bg-violet-500/20 text-violet-300 font-semibold">{{ $obra->categoria->nombre }}</span>
                                <h3 class="font-bold text-white text-base mt-2">{{ $obra->titulo }}</h3>
                            </div>
                        </div>
                        <div class="p-4 pt-0 text-right">
                            <a href="{{ route('obras.show', $obra->id) }}" class="text-xs text-violet-300 hover:text-white font-medium">Ver detalles de la obra →</a>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-slate-500 italic sm:col-span-3">Este autor aún no tiene publicaciones en su galería.</p>
                @endforelse
            </div>
        </div>

    </main>

    <script>
        function seleccionarServicio(id, titulo) {
            document.getElementById('servicio_id_input').value = id;
            document.getElementById('servicio_seleccionado_texto').innerText = 'Contratando servicio: ' + titulo;
            document.getElementById('servicio_seleccionado_alerta').classList.remove('hidden');
            document.getElementById('seccion-solicitud').scrollIntoView({ behavior: 'smooth' });
        }

        function limpiarServicio() {
            document.getElementById('servicio_id_input').value = '';
            document.getElementById('servicio_seleccionado_alerta').classList.add('hidden');
        }
    </script>
</body>
</html>