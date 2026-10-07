<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración | Métricas y Escrow</title>
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
            --amber: #fbbf24;
            --emerald: #34d399;
        }
        body { background: var(--bg); color: var(--text); font-family: 'Inter', sans-serif; }
        .glass { background: var(--glass); border: 1px solid var(--line); backdrop-filter: blur(20px); }
        .stat-card { background: var(--glass-strong); border: 1px solid var(--line); border-radius: 1.25rem; padding: 1.2rem; }
        .field { width: 100%; padding: .75rem 1rem; border-radius: .75rem; background: rgba(0,0,0,.4); border: 1px solid var(--line); color: var(--text); }
        .field:focus { outline: none; border-color: rgba(139,92,246,.7); }
    </style>
</head>
<body class="min-h-screen relative pb-16">

    <!-- Navbar -->
    <nav class="px-6 py-4 border-b border-white/10 sticky top-0 z-50 bg-[#0a0a12]/80 backdrop-blur-md flex justify-between items-center">
        <div class="flex items-center gap-3">
            <span class="text-xl font-bold font-mono text-violet-400">⚡ ADMIN CENTER</span>
            <span class="text-xs px-2.5 py-0.5 rounded-full bg-violet-500/20 text-violet-300 border border-violet-500/30">Superadmin</span>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('pedidos.index') }}" class="text-xs px-3 py-1.5 rounded-lg border border-white/10 hover:bg-white/5 text-slate-300">Mis Contrataciones</a>
            <a href="{{ route('obras.index') }}" class="text-xs px-3 py-1.5 rounded-lg border border-white/10 hover:bg-white/5 text-slate-300">Ir a la Galería</a>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 py-8">

        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl border border-emerald-500/30 bg-emerald-500/10 text-emerald-300 text-sm">
                ✅ {{ session('success') }}
            </div>
        @endif
        @if(session('warning'))
            <div class="mb-6 p-4 rounded-xl border border-amber-500/30 bg-amber-500/10 text-amber-300 text-sm">
                ⚖️ {{ session('warning') }}
            </div>
        @endif

        <!-- 1. BLOQUE DE FINANZAS: INGRESOS POR COMISIÓN DE LA PLATAFORMA -->
        <h2 class="text-xs uppercase tracking-widest text-slate-400 font-semibold mb-3">Ingresos de la Plataforma (Comisión 10%)</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="stat-card border-emerald-500/30">
                <p class="text-xs text-slate-400 uppercase font-semibold">Hoy</p>
                <h3 class="text-2xl font-bold text-emerald-400 mt-1">S/ {{ number_format($comisionesHoy, 2) }}</h3>
                <span class="text-[0.7rem] text-slate-500">Recaudación de las últimas 24h</span>
            </div>
            <div class="stat-card border-cyan-500/30">
                <p class="text-xs text-slate-400 uppercase font-semibold">Últimos 7 Días</p>
                <h3 class="text-2xl font-bold text-cyan-400 mt-1">S/ {{ number_format($comisionesSemana, 2) }}</h3>
                <span class="text-[0.7rem] text-slate-500">Rendimiento semanal</span>
            </div>
            <div class="stat-card border-violet-500/30">
                <p class="text-xs text-slate-400 uppercase font-semibold">Este Mes</p>
                <h3 class="text-2xl font-bold text-violet-400 mt-1">S/ {{ number_format($comisionesMes, 2) }}</h3>
                <span class="text-[0.7rem] text-slate-500">{{ Carbon\Carbon::now()->translatedFormat('F Y') }}</span>
            </div>
            <div class="stat-card border-amber-500/30">
                <p class="text-xs text-slate-400 uppercase font-semibold">Acumulado Anual</p>
                <h3 class="text-2xl font-bold text-amber-400 mt-1">S/ {{ number_format($comisionesAno, 2) }}</h3>
                <span class="text-[0.7rem] text-slate-500">Año fiscal {{ date('Y') }}</span>
            </div>
        </div>

        <!-- 2. BLOQUE DE ACTIVIDAD Y CATÁLOGO -->
        <h2 class="text-xs uppercase tracking-widest text-slate-400 font-semibold mb-3">Métricas de Actividad y Catálogo</h2>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-10">
            <div class="stat-card">
                <p class="text-xs text-slate-400">Total Obras</p>
                <h4 class="text-xl font-bold text-white mt-1">{{ $totalObras }}</h4>
            </div>
            <div class="stat-card">
                <p class="text-xs text-slate-400">Obras Nuevas Hoy</p>
                <h4 class="text-xl font-bold text-pink-400 mt-1">+{{ $obrasHoy }}</h4>
            </div>
            <div class="stat-card">
                <p class="text-xs text-slate-400">Usuarios Registrados</p>
                <h4 class="text-xl font-bold text-white mt-1">{{ $totalUsuarios }}</h4>
            </div>
            <div class="stat-card">
                <p class="text-xs text-slate-400">Pedidos Finalizados</p>
                <h4 class="text-xl font-bold text-emerald-400 mt-1">{{ $pedidosCompletados }}</h4>
            </div>
        </div>

        <!-- 3. MESA DE AUDITORÍA: DISPUTAS PENDIENTES -->
        <div class="glass rounded-3xl p-6 sm:p-8 mb-10 border-rose-500/30">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-xl font-bold text-white flex items-center gap-2">
                        ⚖️ Mesa de Auditoría y Disputas de Escrow
                    </h3>
                    <p class="text-xs text-slate-400 mt-1">
                        Encargos donde el cliente rechazó la entrega. Compara el brief original con el archivo entregado y emite tu resolución.
                    </p>
                </div>
                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-rose-500/20 text-rose-300 border border-rose-500/30">
                    {{ $disputasPendientes->count() }} pendientes
                </span>
            </div>

            @if($disputasPendientes->isEmpty())
                <div class="p-8 text-center border border-dashed border-white/10 rounded-2xl text-slate-400 text-sm">
                    No hay solicitudes en conflicto actualmente. Todas las transacciones operan con normalidad.
                </div>
            @else
                <div class="space-y-6">
                    @foreach($disputasPendientes as $p)
                        <div class="p-6 rounded-2xl bg-black/40 border border-white/10 space-y-5">
                            <div class="flex flex-wrap justify-between items-start gap-4 border-b border-white/10 pb-4">
                                <div>
                                    <span class="text-xs text-slate-400">Caso #{{ $p->id }} • {{ $p->servicio ? $p->servicio->titulo : 'Encargo Directo' }}</span>
                                    <h4 class="text-base font-bold text-white">
                                        Cliente: <span class="text-violet-300">{{ $p->cliente->name }}</span> vs Artista: <span class="text-pink-300">{{ $p->artista->name }}</span>
                                    </h4>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm font-bold text-amber-400">Custodia: S/ {{ number_format($p->precio_acordado, 2) }}</div>
                                    <span class="text-[0.65rem] text-slate-500">Comisión estimada: S/ {{ number_format(round($p->precio_acordado * 0.10, 2), 2) }}</span>
                                </div>
                            </div>

                            <!-- Comparativa de Evidencia -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs">
                                <div class="p-4 rounded-xl bg-white/[0.03] border border-white/5">
                                    <p class="font-semibold text-slate-400 mb-1">1. Brief e Indicaciones del Cliente:</p>
                                    <p class="text-slate-200 leading-relaxed">{{ $p->instrucciones }}</p>
                                    @if($p->archivo_referencia)
                                        <div class="mt-3">
                                            <a href="{{ asset('storage/' . $p->archivo_referencia) }}" target="_blank" class="text-cyan-400 underline">📎 Ver Archivo de Referencia</a>
                                        </div>
                                    @endif
                                </div>

                                <div class="p-4 rounded-xl bg-white/[0.03] border border-white/5">
                                    <p class="font-semibold text-slate-400 mb-1">2. Motivo de Rechazo (Cliente):</p>
                                    <p class="text-rose-300 leading-relaxed italic">"{{ $p->motivo_rechazo }}"</p>
                                </div>

                                <div class="p-4 rounded-xl bg-white/[0.03] border border-white/5">
                                    <p class="font-semibold text-slate-400 mb-1">3. Entregable Final del Artista:</p>
                                    @if($p->archivo_entrega_final)
                                        <a href="{{ asset('storage/' . $p->archivo_entrega_final) }}" target="_blank" class="inline-block px-3 py-1.5 rounded-lg bg-violet-600/30 text-violet-300 border border-violet-500/40 font-semibold mb-2">
                                            👁️ Auditar Archivo
                                        </a>
                                    @endif
                                </div>
                            </div>

                            <!-- Veredicto del Administrador -->
                            <div class="pt-2 border-t border-white/5">
                                <p class="text-xs font-semibold text-slate-300 mb-2">Dictamen de Auditoría:</p>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Fallo a favor del Artista -->
                                    <form action="{{ route('admin.pedidos.favorArtista', $p->id) }}" method="POST" class="p-4 rounded-xl bg-emerald-500/5 border border-emerald-500/20 space-y-2">
                                        @csrf
                                        <textarea name="resolucion_admin" rows="2" class="field text-xs" placeholder="Argumento técnico: el artista cumplió con el brief solicitado..." required></textarea>
                                        <button type="submit" class="w-full py-2 rounded-lg bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs" onclick="return confirm('¿Confirmas dictamen a favor del artista? Se le transferirán los fondos netos.')">
                                            ✓ Fallar a Favor del Artista (Liberar S/ {{ number_format($p->precio_acordado * 0.90, 2) }})
                                        </button>
                                    </form>

                                    <!-- Fallo a favor del Cliente -->
                                    <form action="{{ route('admin.pedidos.favorCliente', $p->id) }}" method="POST" class="p-4 rounded-xl bg-rose-500/5 border border-rose-500/20 space-y-2">
                                        @csrf
                                        <textarea name="resolucion_admin" rows="2" class="field text-xs" placeholder="Argumento: la entrega no cumplió los lineamientos básicos estipulados..." required></textarea>
                                        <button type="submit" class="w-full py-2 rounded-lg bg-rose-500 hover:bg-rose-400 text-white font-bold text-xs" onclick="return confirm('¿Confirmas dictamen a favor del cliente? Se le devolverá el 100% retenido.')">
                                            ✗ Fallar a Favor del Cliente (Reembolsar S/ {{ number_format($p->precio_acordado, 2) }})
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- 4. HISTORIAL DE RESOLUCIONES RECIENTES -->
        <div class="glass rounded-3xl p-6 sm:p-8 border-white/10">
            <h3 class="text-base font-bold text-white mb-4">Últimas Auditorías Resueltas</h3>
            <div class="divide-y divide-white/5 text-xs">
                @forelse($disputasResueltas as $d)
                    <div class="py-3 flex flex-col sm:flex-row justify-between sm:items-center gap-2">
                        <div>
                            <span class="font-semibold text-white">Pedido #{{ $d->id }}</span> — {{ $d->cliente->name }} y {{ $d->artista->name }}
                            <p class="text-slate-400 text-[0.7rem]">{{ $d->resolucion_admin }}</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="px-2.5 py-0.5 rounded-full font-medium {{ $d->estado === 'completado' ? 'bg-emerald-500/20 text-emerald-300' : 'bg-rose-500/20 text-rose-300' }}">
                                {{ strtoupper($d->estado) }}
                            </span>
                            <span class="text-slate-500 text-[0.7rem]">{{ $d->updated_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                @empty
                    <p class="text-slate-500 py-2">Sin auditorías concluidas recientemente.</p>
                @endforelse
            </div>
        </div>

    </main>
</body>
</html>