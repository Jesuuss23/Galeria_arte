<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contrataciones - Galería Creativa</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        display: ['"Space Grotesk"', 'sans-serif'],
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
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
            --rose: #f43f5e;
        }

        html { scroll-behavior: smooth; }
        .hidden { display: none !important; }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'Inter', sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        /* Textos largos sin espacios se parten en lugar de desbordar */
        .pedido p, .pedido h3, .pedido span, .glass h1 { overflow-wrap: anywhere; word-break: break-word; }
        .pedido, .pedido > div { min-width: 0; }

        /* ---------- Fondo aurora opaco ---------- */
        .aurora { position: fixed; inset: 0; z-index: 0; overflow: hidden; pointer-events: none; }
        .aurora span {
            position: absolute; border-radius: 9999px; filter: blur(110px); opacity: .4;
            animation: drift 22s ease-in-out infinite alternate;
        }
        .aurora span:nth-child(1) { width: 46vw; height: 46vw; background: var(--violet); top: -14vw; left: -10vw; }
        .aurora span:nth-child(2) { width: 38vw; height: 38vw; background: var(--pink);   bottom: -12vw; right: -8vw; animation-delay: -7s; opacity: .3; }
        .aurora span:nth-child(3) { width: 30vw; height: 30vw; background: var(--cyan);   top: 38%; left: 52%; animation-delay: -13s; opacity: .2; }
        @keyframes drift {
            from { transform: translate3d(0, 0, 0) scale(1); }
            to   { transform: translate3d(5vw, 4vw, 0) scale(1.15); }
        }
        .grain {
            position: fixed; inset: 0; z-index: 1; pointer-events: none; opacity: .06; mix-blend-mode: overlay;
            background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='160' height='160'><filter id='n'><feTurbulence type='fractalNoise' baseFrequency='.9' numOctaves='2' stitchTiles='stitch'/></filter><rect width='100%' height='100%' filter='url(%23n)'/></svg>");
        }

        .glass {
            background: var(--glass);
            border: 1px solid var(--line);
            backdrop-filter: blur(22px) saturate(140%);
            -webkit-backdrop-filter: blur(22px) saturate(140%);
        }

        .rise { opacity: 0; transform: translateY(18px); animation: rise .8s cubic-bezier(.2,.8,.2,1) forwards; }
        .d1 { animation-delay: .05s; } .d2 { animation-delay: .18s; } .d3 { animation-delay: .3s; }
        @keyframes rise { to { opacity: 1; transform: none; } }

        /* ---------- Navbar ---------- */
        .nav {
            background: rgba(10, 10, 18, .6);
            border-bottom: 1px solid var(--line);
            backdrop-filter: blur(22px) saturate(160%);
            -webkit-backdrop-filter: blur(22px) saturate(160%);
        }
        .logo {
            font-family: 'Space Grotesk', sans-serif; font-weight: 700; letter-spacing: -.02em;
            background: linear-gradient(100deg, #fff 10%, #c4b5fd 50%, #f9a8d4 90%);
            -webkit-background-clip: text; background-clip: text; color: transparent;
            transition: filter .3s;
        }
        .logo:hover { filter: drop-shadow(0 0 14px rgba(167,139,250,.7)); }

        .btn-ghost {
            display: inline-flex; align-items: center; gap: .5rem;
            padding: .5rem .9rem; border-radius: .8rem; font-size: .85rem; font-weight: 500;
            color: var(--text); background: var(--glass-strong); border: 1px solid var(--line);
            transition: transform .2s, border-color .2s, background .2s;
        }
        .btn-ghost:hover { transform: translateY(-2px); border-color: rgba(167,139,250,.55); background: rgba(139,92,246,.14); }
        .btn-ghost.is-current { border-color: rgba(167,139,250,.6); background: rgba(139,92,246,.18); }

        .btn-primary {
            position: relative; overflow: hidden; display: inline-flex; align-items: center; gap: .4rem;
            padding: .55rem 1.05rem; border-radius: .8rem; font-size: .85rem; font-weight: 600; color: #fff;
            background: linear-gradient(120deg, var(--violet), var(--pink));
            box-shadow: 0 10px 28px -10px rgba(139, 92, 246, .85);
            transition: transform .2s, box-shadow .2s;
        }
        .btn-primary:hover { transform: translateY(-2px) scale(1.03); box-shadow: 0 16px 36px -12px rgba(236, 72, 153, .85); }
        .btn-primary:active { transform: scale(.97); }

        .btn-danger {
            display: inline-flex; align-items: center; gap: .4rem; cursor: pointer;
            padding: .5rem .9rem; border-radius: .8rem; font-size: .85rem; font-weight: 500;
            color: #fda4af; background: rgba(244, 63, 94, .08); border: 1px solid rgba(244, 63, 94, .25);
            transition: transform .2s, background .2s, border-color .2s;
        }
        .btn-danger:hover { transform: translateY(-2px); background: rgba(244, 63, 94, .16); border-color: rgba(244, 63, 94, .5); }

        /* ---------- Textos ---------- */
        .eyebrow { font-size: .68rem; text-transform: uppercase; letter-spacing: .22em; color: var(--muted); font-weight: 600; }
        .title-grad {
            background: linear-gradient(100deg, #fff 10%, #c4b5fd 45%, #f9a8d4 75%, #67e8f9 100%);
            background-size: 200% auto;
            -webkit-background-clip: text; background-clip: text; color: transparent;
            animation: shine 8s linear infinite;
        }
        @keyframes shine { to { background-position: 200% center; } }

        .avatar {
            width: 2.2rem; height: 2.2rem; border-radius: 9999px; display: grid; place-items: center; flex-shrink: 0;
            font-family: 'Space Grotesk', sans-serif; font-weight: 700; font-size: .85rem; color: #fff;
            background: linear-gradient(135deg, var(--violet), var(--cyan));
        }

        /* ---------- Alertas ---------- */
        .alert { display: flex; gap: .6rem; padding: .85rem 1.1rem; border-radius: 1rem; font-size: .88rem; border: 1px solid; }
        .alert-ok   { color: #6ee7b7; background: rgba(52,211,153,.08); border-color: rgba(52,211,153,.3); box-shadow: 0 0 30px -12px rgba(52,211,153,.6); }
        .alert-warn { color: #fcd34d; background: rgba(251,191,36,.08); border-color: rgba(251,191,36,.3); }
        .alert-err  { color: #fda4af; background: rgba(244,63,94,.08);  border-color: rgba(244,63,94,.3); }

        /* ---------- Tarjeta de pedido ---------- */
        .pedido {
            position: relative; border-radius: 1.5rem; padding: 1.4rem;
            background: var(--glass); border: 1px solid var(--line);
            backdrop-filter: blur(22px); -webkit-backdrop-filter: blur(22px);
            transition: border-color .3s, box-shadow .35s, transform .35s cubic-bezier(.2,.8,.2,1);
            opacity: 0; transform: translateY(20px);
            animation: rise .7s cubic-bezier(.2,.8,.2,1) forwards;
        }
        .pedido:hover { border-color: rgba(167,139,250,.4); box-shadow: 0 30px 70px -36px rgba(139,92,246,.7); transform: translateY(-3px); }

        /* Estado */
        .estado {
            --c: var(--cyan);
            display: inline-block; white-space: nowrap;
            font-size: .64rem; text-transform: uppercase; letter-spacing: .12em; font-weight: 700;
            padding: .28rem .7rem; border-radius: 9999px; color: var(--c);
            background: color-mix(in srgb, var(--c) 12%, transparent);
            border: 1px solid color-mix(in srgb, var(--c) 35%, transparent);
        }
        .estado[data-estado="solicitado"]      { --c: var(--cyan); }
        .estado[data-estado="cotizado"]        { --c: var(--amber); }
        .estado[data-estado="pagado_custodia"] { --c: #a78bfa; }
        .estado[data-estado="entregado"]       { --c: #f472b6; }
        .estado[data-estado="completado"]      { --c: var(--emerald); }
        .estado[data-estado="en_disputa"]      { --c: var(--rose); }
        .estado[data-estado="reembolsado"],
        .estado[data-estado="cancelado"]       { --c: #9ca3af; }

        .datos {
            display: grid; grid-template-columns: repeat(auto-fit, minmax(8rem, 1fr)); gap: .75rem;
            margin-top: 1rem; padding: .9rem 1rem; border-radius: 1rem;
            background: rgba(0,0,0,.25); border: 1px solid var(--line);
        }
        .datos .k { font-size: .62rem; text-transform: uppercase; letter-spacing: .14em; color: var(--muted); font-weight: 600; }
        .datos .v { font-family: 'Space Grotesk', sans-serif; font-weight: 600; font-size: 1rem; color: #fff; margin-top: .15rem; }

        .nota {
            margin-top: 1rem; padding: .85rem 1rem; border-radius: 1rem; font-size: .85rem; line-height: 1.55;
            color: #cfcfe3; background: rgba(255,255,255,.04); border: 1px solid var(--line); white-space: pre-line;
        }

        /* ---------- Formularios ---------- */
        .label { display: block; font-size: .66rem; text-transform: uppercase; letter-spacing: .14em; font-weight: 600; color: var(--muted); margin-bottom: .4rem; }
        .field {
            width: 100%; padding: .7rem .9rem; border-radius: .85rem; font-size: .86rem; color: var(--text);
            background: rgba(0, 0, 0, .3); border: 1px solid var(--line);
            transition: border-color .2s, box-shadow .2s, background .2s;
        }
        .field::placeholder { color: #5f5f78; }
        .field:focus { outline: none; border-color: rgba(167,139,250,.7); box-shadow: 0 0 0 4px rgba(139,92,246,.18); background: rgba(0,0,0,.42); }
        .field[type="date"] { color-scheme: dark; }
        .field[type="file"]::file-selector-button {
            margin-right: .8rem; padding: .35rem .8rem; border: 0; border-radius: .6rem; cursor: pointer;
            background: rgba(139,92,246,.25); color: #ddd6fe; font-weight: 600; font-size: .78rem;
        }
        textarea.field { resize: vertical; min-height: 5rem; }

        .btn {
            display: inline-flex; align-items: center; justify-content: center; gap: .4rem; cursor: pointer;
            padding: .6rem 1.1rem; border-radius: .85rem; font-size: .8rem; font-weight: 600; color: #fff;
            border: 1px solid transparent; transition: transform .2s, box-shadow .2s, background .2s, border-color .2s;
        }
        .btn:hover { transform: translateY(-2px); }
        .btn:active { transform: scale(.97); }
        .btn-pay    { background: linear-gradient(120deg, #10b981, #06b6d4); box-shadow: 0 10px 26px -12px rgba(16,185,129,.8); }
        .btn-quote  { background: linear-gradient(120deg, var(--violet), var(--cyan)); box-shadow: 0 10px 26px -12px rgba(34,211,238,.7); }
        .btn-send   { background: linear-gradient(120deg, #f59e0b, #ec4899); box-shadow: 0 10px 26px -12px rgba(245,158,11,.75); }
        .btn-line   { background: rgba(255,255,255,.06); border-color: var(--line); color: #ddd6fe; }
        .btn-line:hover { border-color: rgba(167,139,250,.6); background: rgba(139,92,246,.16); }
        .btn-reject { background: rgba(244,63,94,.1); border-color: rgba(244,63,94,.3); color: #fda4af; }
        .btn-reject:hover { background: rgba(244,63,94,.2); border-color: rgba(244,63,94,.55); }

        .panel-form { margin-top: .9rem; padding: 1rem; border-radius: 1rem; background: rgba(0,0,0,.28); border: 1px solid var(--line); }

        .empty {
            border-radius: 1.5rem; padding: 2.5rem 1.5rem; text-align: center; color: var(--muted); font-size: .9rem;
            background: var(--glass); border: 1px dashed rgba(255,255,255,.18);
        }

        .section-title { font-family: 'Space Grotesk', sans-serif; font-weight: 600; font-size: 1.5rem; color: #fff; }
        .count {
            font-size: .72rem; font-weight: 700; padding: .15rem .6rem; border-radius: 9999px;
            color: #c4b5fd; background: rgba(139,92,246,.15); border: 1px solid rgba(139,92,246,.3);
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation: none !important; transition: none !important; }
            .rise, .pedido { opacity: 1; transform: none; }
        }
    </style>
</head>
<body class="min-h-screen relative">

    <div class="aurora" aria-hidden="true"><span></span><span></span><span></span></div>
    <div class="grain" aria-hidden="true"></div>

    <!-- Navbar -->
    <nav class="nav px-4 sm:px-6 py-3.5 flex justify-between items-center sticky top-0 z-50">
        <a href="{{ route('obras.index') }}" class="logo text-xl">🎨 Galería Creativa</a>
        <div class="flex items-center gap-2 sm:gap-3 flex-wrap justify-end">
            <a href="{{ route('obras.index') }}" class="btn-ghost">Explorar</a>
            <a href="{{ route('obras.perfil') }}" class="btn-ghost">Mi perfil</a>
            <a href="{{ route('pedidos.index') }}" class="btn-ghost is-current">Contrataciones</a>
            <a href="{{ route('obras.create') }}" class="btn-primary">+ Subir mi arte</a>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="btn-danger">Salir</button>
            </form>
        </div>
    </nav>

    <main class="relative z-10 max-w-6xl mx-auto px-4 py-10">

        <header class="mb-8 rise d1">
            <p class="eyebrow mb-2">Escrow</p>
            <h1 class="font-display text-4xl sm:text-5xl font-bold tracking-tight leading-tight title-grad">Panel de Contrataciones</h1>
            <p class="text-sm mt-2" style="color: var(--muted);">El pago queda en custodia hasta que apruebes la entrega.</p>
        </header>

        <!-- Mensajes -->
        <div class="space-y-3 mb-8 rise d2">
            @if(session('success'))
                <div class="alert alert-ok"><span>✅</span><span>{{ session('success') }}</span></div>
            @endif
            @if(session('warning'))
                <div class="alert alert-warn"><span>⚠️</span><span>{{ session('warning') }}</span></div>
            @endif
            @if(session('error'))
                <div class="alert alert-err"><span>⛔</span><span>{{ session('error') }}</span></div>
            @endif
            @if ($errors->any())
                <div class="alert alert-err">
                    <ul class="list-disc pl-5 space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        {{-- SECCIÓN 1: MIS COMPRAS (PEDIDOS COMO CLIENTE) --}}
        <section class="mb-14">
            <div class="flex items-center gap-3 mb-5 rise d3">
                <h2 class="section-title">Mis Solicitudes como Cliente</h2>
                <span class="count">{{ $compras->count() }}</span>
            </div>

            @if($compras->isEmpty())
                <div class="empty">No has realizado ninguna solicitud de contratación aún.</div>
            @else
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
                    @foreach($compras as $p)
                        <article class="pedido" style="animation-delay: {{ min($loop->index, 8) * 80 }}ms">
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex items-center gap-3 min-w-0">
                                    <span class="avatar">{{ mb_strtoupper(mb_substr($p->artista->name, 0, 1)) }}</span>
                                    <div class="min-w-0">
                                        <p class="eyebrow">Artista</p>
                                        <p class="font-semibold text-white">{{ $p->artista->name }}</p>
                                    </div>
                                </div>
                                <span class="estado" data-estado="{{ $p->estado }}">{{ strtoupper(str_replace('_', ' ', $p->estado)) }}</span>
                            </div>

                            <h3 class="font-display font-semibold text-white text-lg mt-4">{{ $p->servicio ? $p->servicio->titulo : 'Pedido Personalizado' }}</h3>
                            <div class="nota">{{ $p->instrucciones }}</div>

                            <div class="datos">
                                <div>
                                    <div class="k">Monto acordado</div>
                                    <div class="v">{{ $p->precio_acordado ? 'S/ ' . number_format($p->precio_acordado, 2) : 'Pendiente' }}</div>
                                </div>
                                <div>
                                    <div class="k">Fecha límite</div>
                                    <div class="v">{{ $p->fecha_limite ? \Carbon\Carbon::parse($p->fecha_limite)->format('d/m/Y') : 'Por definir' }}</div>
                                </div>
                            </div>

                            {{-- Acciones del cliente --}}
                            @if($p->estado === 'cotizado')
                                <div class="mt-4">
                                    <form action="{{ route('pedidos.pagar', $p->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-pay w-full">
                                            🔒 Pagar en Custodia (S/ {{ number_format($p->precio_acordado, 2) }})
                                        </button>
                                    </form>
                                </div>

                            @elseif($p->estado === 'entregado')
                                <div class="mt-4 flex flex-wrap gap-2">
                                    <a href="{{ asset('storage/' . $p->archivo_entrega_final) }}" target="_blank" class="btn btn-line">📎 Ver Entrega</a>

                                    <form action="{{ route('pedidos.aprobar', $p->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-pay" onclick="return confirm('¿Confirmas que recibiste el trabajo conforme? Se liberará el pago al artista.')">✔ Aprobar</button>
                                    </form>

                                    <button class="btn btn-reject" type="button" data-toggle-target="disputa-{{ $p->id }}">✖ Rechazar</button>
                                </div>

                                <div class="panel-form hidden" id="disputa-{{ $p->id }}">
                                    <form action="{{ route('pedidos.disputar', $p->id) }}" method="POST" class="space-y-2">
                                        @csrf
                                        <label class="label">Motivo del rechazo</label>
                                        <textarea name="motivo_rechazo" class="field" placeholder="Explica detalladamente por qué el trabajo no cumple con las indicaciones iniciales..." required></textarea>
                                        <button type="submit" class="btn btn-reject">Enviar a Auditoría</button>
                                    </form>
                                </div>

                            @elseif($p->estado === 'en_disputa')
                                <div class="nota" style="border-color: rgba(244,63,94,.3);">⚖️ En disputa. El soporte revisará las especificaciones.</div>
                            @endif
                        </article>
                    @endforeach
                </div>
            @endif
        </section>

        {{-- SECCIÓN 2: MIS ENCARGOS (TRABAJOS COMO ARTISTA) --}}
        <section>
            <div class="flex items-center gap-3 mb-5">
                <h2 class="section-title">Encargos Recibidos como Artista</h2>
                <span class="count">{{ $encargos->count() }}</span>
            </div>

            @if($encargos->isEmpty())
                <div class="empty">Aún no tienes solicitudes de trabajo de clientes.</div>
            @else
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
                    @foreach($encargos as $p)
                        <article class="pedido" style="animation-delay: {{ min($loop->index, 8) * 80 }}ms">
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex items-center gap-3 min-w-0">
                                    <span class="avatar">{{ mb_strtoupper(mb_substr($p->cliente->name, 0, 1)) }}</span>
                                    <div class="min-w-0">
                                        <p class="eyebrow">Cliente</p>
                                        <p class="font-semibold text-white">{{ $p->cliente->name }}</p>
                                    </div>
                                </div>
                                <span class="estado" data-estado="{{ $p->estado }}">{{ strtoupper(str_replace('_', ' ', $p->estado)) }}</span>
                            </div>

                            <p class="eyebrow mt-4">Indicaciones</p>
                            <div class="nota" style="margin-top:.4rem;">{{ $p->instrucciones }}</div>
                            @if($p->archivo_referencia)
                                <a href="{{ asset('storage/' . $p->archivo_referencia) }}" target="_blank" class="inline-flex mt-3 text-xs font-semibold" style="color:#c4b5fd;">📎 Ver archivo de referencia →</a>
                            @endif

                            <div class="datos">
                                <div>
                                    <div class="k">Monto</div>
                                    <div class="v">{{ $p->precio_acordado ? 'S/ ' . number_format($p->precio_acordado, 2) : 'Sin cotizar' }}</div>
                                </div>
                                @if($p->fecha_limite)
                                    <div>
                                        <div class="k">Fecha límite</div>
                                        <div class="v">{{ \Carbon\Carbon::parse($p->fecha_limite)->format('d/m/Y') }}</div>
                                    </div>
                                @endif
                                @if($p->estado === 'completado')
                                    <div>
                                        <div class="k">Pago liberado</div>
                                        <div class="v" style="color: var(--emerald);">S/ {{ number_format($p->precio_acordado - $p->comision_plataforma, 2) }}</div>
                                    </div>
                                @endif
                            </div>

                            {{-- Acciones del artista --}}
                            @if($p->estado === 'solicitado')
                                <form action="{{ route('pedidos.cotizar', $p->id) }}" method="POST" class="panel-form space-y-3">
                                    @csrf
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                        <div>
                                            <label class="label">Precio (S/)</label>
                                            <input type="number" step="0.5" name="precio_acordado" placeholder="Precio (S/)" class="field" required>
                                        </div>
                                        <div>
                                            <label class="label">Fecha límite</label>
                                            <input type="date" name="fecha_limite" class="field" required>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-quote w-full">Enviar Cotización</button>
                                </form>

                            @elseif($p->estado === 'pagado_custodia')
                                <form action="{{ route('pedidos.entregar', $p->id) }}" method="POST" enctype="multipart/form-data" class="panel-form space-y-3">
                                    @csrf
                                    <div>
                                        <label class="label">Subir obra final</label>
                                        <input type="file" name="archivo_entrega_final" class="field" required>
                                    </div>
                                    <button type="submit" class="btn btn-send w-full">Entregar Trabajo</button>
                                </form>

                            @elseif($p->estado === 'entregado')
                                <div class="nota">⏳ Entrega enviada. Esperando la aprobación del cliente.</div>

                            @elseif($p->estado === 'en_disputa')
                                <div class="nota" style="border-color: rgba(244,63,94,.3);">
                                    ⚖️ El cliente rechazó la entrega:
                                    <br>{{ $p->motivo_rechazo }}
                                </div>
                            @endif
                        </article>
                    @endforeach
                </div>
            @endif
        </section>
    </main>

    <!-- Mostrar / ocultar paneles (reemplaza data-bs-toggle de Bootstrap) -->
    <script>
        document.querySelectorAll('[data-toggle-target]').forEach(btn => {
            btn.addEventListener('click', () => {
                const panel = document.getElementById(btn.dataset.toggleTarget);
                if (panel) panel.classList.toggle('hidden');
            });
        });
    </script>
</body>
</html>