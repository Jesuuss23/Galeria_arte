<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil Artístico</title>
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
        }

        html { scroll-behavior: smooth; }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'Inter', sans-serif;
            -webkit-font-smoothing: antialiased;
        }

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

        /* ---------- Vidrio ---------- */
        .glass {
            background: var(--glass);
            border: 1px solid var(--line);
            backdrop-filter: blur(22px) saturate(140%);
            -webkit-backdrop-filter: blur(22px) saturate(140%);
        }

        /* ---------- Entrada ---------- */
        .rise { opacity: 0; transform: translateY(18px); animation: rise .8s cubic-bezier(.2,.8,.2,1) forwards; }
        .d1 { animation-delay: .05s; } .d2 { animation-delay: .18s; } .d3 { animation-delay: .3s; } .d4 { animation-delay: .42s; }
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

        .btn-primary {
            position: relative; overflow: hidden; display: inline-flex; align-items: center; gap: .4rem;
            padding: .55rem 1.05rem; border-radius: .8rem; font-size: .85rem; font-weight: 600; color: #fff;
            background: linear-gradient(120deg, var(--violet), var(--pink));
            box-shadow: 0 10px 28px -10px rgba(139, 92, 246, .85);
            transition: transform .2s, box-shadow .2s;
        }
        .btn-primary::before {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(120deg, transparent 30%, rgba(255,255,255,.35) 50%, transparent 70%);
            transform: translateX(-120%); transition: transform .7s;
        }
        .btn-primary:hover { transform: translateY(-2px) scale(1.03); box-shadow: 0 16px 36px -12px rgba(236, 72, 153, .85); }
        .btn-primary:hover::before { transform: translateX(120%); }
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
            width: 2rem; height: 2rem; border-radius: 9999px; display: grid; place-items: center; flex-shrink: 0;
            font-family: 'Space Grotesk', sans-serif; font-weight: 700; font-size: .8rem; color: #fff;
            background: linear-gradient(135deg, var(--violet), var(--cyan));
        }
        .avatar-lg { width: 4.2rem; height: 4.2rem; font-size: 1.6rem; box-shadow: 0 0 40px -6px rgba(139,92,246,.8); }

        /* ---------- Estadísticas ---------- */
        .stat {
            position: relative; text-align: center; padding: .9rem 1.5rem; border-radius: 1.1rem; min-width: 8.5rem;
            background: var(--glass-strong); border: 1px solid var(--line);
            transition: transform .25s, border-color .25s, box-shadow .25s;
        }
        .stat:hover { transform: translateY(-4px); }
        .stat .num { display: block; font-family: 'Space Grotesk', sans-serif; font-size: 2rem; font-weight: 700; line-height: 1.1; }
        .stat .lbl { font-size: .7rem; color: var(--muted); font-weight: 500; letter-spacing: .06em; text-transform: uppercase; }
        .stat-violet:hover { border-color: rgba(167,139,250,.6); box-shadow: 0 18px 40px -20px rgba(139,92,246,.9); }
        .stat-violet .num { color: #c4b5fd; }
        .stat-pink:hover { border-color: rgba(244,114,182,.6); box-shadow: 0 18px 40px -20px rgba(236,72,153,.9); }
        .stat-pink .num { color: #f9a8d4; }

        /* ---------- Formulario ---------- */
        .label { display: block; font-size: .68rem; text-transform: uppercase; letter-spacing: .14em; font-weight: 600; color: var(--muted); margin-bottom: .45rem; }
        .field {
            width: 100%; padding: .8rem 1rem; border-radius: .9rem; font-size: .88rem; color: var(--text);
            background: rgba(0, 0, 0, .3); border: 1px solid var(--line);
            transition: border-color .2s, box-shadow .2s, background .2s;
        }
        .field::placeholder { color: #5f5f78; }
        .field:focus {
            outline: none; border-color: rgba(167, 139, 250, .7);
            box-shadow: 0 0 0 4px rgba(139, 92, 246, .18); background: rgba(0, 0, 0, .42);
        }

        /* Checkbox personalizado (mismo input, mismo id y name) */
        .check {
            appearance: none; -webkit-appearance: none; flex-shrink: 0;
            width: 1.25rem; height: 1.25rem; border-radius: .4rem; cursor: pointer; position: relative;
            background: rgba(0,0,0,.35); border: 1px solid rgba(255,255,255,.22);
            transition: background .2s, border-color .2s, box-shadow .2s;
        }
        .check:hover { border-color: rgba(167,139,250,.7); }
        .check:focus-visible { outline: none; box-shadow: 0 0 0 4px rgba(139,92,246,.25); }
        .check:checked { background: linear-gradient(135deg, var(--violet), var(--pink)); border-color: transparent; }
        .check:checked::after {
            content: ''; position: absolute; left: 6px; top: 2px; width: 5px; height: 10px;
            border: solid #fff; border-width: 0 2px 2px 0; transform: rotate(45deg);
        }

        .btn-save {
            position: relative; overflow: hidden;
            padding: .75rem 1.5rem; border-radius: .9rem; font-size: .82rem; font-weight: 600; color: #fff;
            background: linear-gradient(120deg, var(--violet), var(--cyan));
            box-shadow: 0 10px 28px -10px rgba(34, 211, 238, .6);
            transition: transform .2s, box-shadow .2s;
        }
        .btn-save:hover { transform: translateY(-2px); box-shadow: 0 16px 34px -12px rgba(34, 211, 238, .75); }
        .btn-save:active { transform: scale(.97); }

        /* ---------- Alerta ---------- */
        .alert-ok {
            display: flex; align-items: center; gap: .6rem;
            padding: .85rem 1.1rem; border-radius: 1rem; font-size: .88rem; color: #6ee7b7;
            background: rgba(52, 211, 153, .08); border: 1px solid rgba(52, 211, 153, .3);
            box-shadow: 0 0 30px -12px rgba(52, 211, 153, .6);
        }

        /* ---------- Tarjeta de obra ---------- */
        .obra {
            border-radius: 1.6rem; overflow: hidden; display: flex; flex-direction: column;
            background: var(--glass); border: 1px solid var(--line);
            backdrop-filter: blur(22px); -webkit-backdrop-filter: blur(22px);
            transition: border-color .3s, box-shadow .35s, transform .35s cubic-bezier(.2,.8,.2,1);
            opacity: 0; transform: translateY(22px);
            animation: rise .7s cubic-bezier(.2,.8,.2,1) forwards;
        }
        .obra:hover { border-color: rgba(167,139,250,.4); box-shadow: 0 30px 70px -34px rgba(139,92,246,.7); transform: translateY(-3px); }
        .obra .thumb { overflow: hidden; background: #000; }
        .obra .thumb img { transition: transform .7s cubic-bezier(.2,.8,.2,1); }
        .obra:hover .thumb img { transform: scale(1.06); }

        .tag {
            display: inline-block; font-size: .64rem; text-transform: uppercase; letter-spacing: .12em; font-weight: 600;
            padding: .25rem .6rem; border-radius: .6rem; color: #c4b5fd;
            background: rgba(139, 92, 246, .14); border: 1px solid rgba(139, 92, 246, .3);
        }
        .likes {
            display: inline-flex; align-items: center; gap: .3rem; font-size: .75rem; font-weight: 600;
            padding: .2rem .55rem; border-radius: 9999px; color: #f9a8d4;
            background: rgba(236, 72, 153, .1); border: 1px solid rgba(236, 72, 153, .25);
        }

        .btn-del {
            display: inline-flex; align-items: center; gap: .35rem; cursor: pointer;
            font-size: .75rem; font-weight: 600; color: #fda4af;
            padding: .4rem .8rem; border-radius: .7rem;
            background: rgba(244, 63, 94, .08); border: 1px solid rgba(244, 63, 94, .22);
            transition: background .2s, border-color .2s, transform .2s;
        }
        .btn-del:hover { background: rgba(244, 63, 94, .18); border-color: rgba(244, 63, 94, .5); transform: translateY(-2px); }

        .link-public { color: #c4b5fd; font-size: .78rem; font-weight: 600; display: inline-flex; gap: .4rem; transition: color .2s, transform .2s; }
        .link-public:hover { color: #fff; transform: translateX(4px); }

        /* ---------- Comentarios ---------- */
        .feedback {
            padding-right: .5rem;
            scrollbar-width: thin; scrollbar-color: rgba(139,92,246,.5) transparent;
        }
        .feedback::-webkit-scrollbar { width: 6px; }
        .feedback::-webkit-scrollbar-thumb { background: rgba(139,92,246,.45); border-radius: 9999px; }

        .comentario {
            --accent: var(--emerald);
            position: relative; padding: .9rem 1.1rem .9rem 1.3rem; border-radius: 1rem; overflow: hidden;
            background: rgba(255,255,255,.04); border: 1px solid var(--line);
            transition: transform .25s, background .25s, border-color .25s;
        }
        .comentario::before {
            content: ''; position: absolute; left: 0; top: 14%; bottom: 14%; width: 3px; border-radius: 3px;
            background: var(--accent); box-shadow: 0 0 14px var(--accent);
        }
        .comentario:hover { transform: translateX(4px); background: var(--glass-strong); border-color: rgba(255,255,255,.16); }
        .comentario[data-tipo="critica"]  { --accent: var(--amber); }
        .comentario[data-tipo="pregunta"] { --accent: var(--cyan); }
        .comentario[data-tipo="positiva"] { --accent: var(--emerald); }

        .badge { font-size: .66rem; font-weight: 600; padding: .2rem .6rem; border-radius: 9999px; border: 1px solid; white-space: nowrap; }
        .badge-critica  { color: #fcd34d; background: rgba(251,191,36,.1); border-color: rgba(251,191,36,.3); }
        .badge-pregunta { color: #67e8f9; background: rgba(34,211,238,.1); border-color: rgba(34,211,238,.3); }
        .badge-positiva { color: #6ee7b7; background: rgba(52,211,153,.1); border-color: rgba(52,211,153,.3); }

        /* ---------- Estado vacío ---------- */
        .empty {
            border-radius: 1.6rem; padding: 3.5rem 1.5rem; text-align: center; color: var(--muted);
            background: var(--glass); border: 1px dashed rgba(255,255,255,.18);
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation: none !important; transition: none !important; }
            .rise, .obra { opacity: 1; transform: none; }
        }
    </style>
</head>
<body class="min-h-screen relative">

    <!-- Fondo -->
    <div class="aurora" aria-hidden="true"><span></span><span></span><span></span></div>
    <div class="grain" aria-hidden="true"></div>

    <!-- Navbar -->
    <nav class="nav px-4 sm:px-6 py-3.5 flex justify-between items-center sticky top-0 z-50">
        <a href="{{ route('obras.index') }}" class="logo text-xl">🎨 Galería Creativa</a>
        <div class="flex items-center gap-2 sm:gap-3">
            <a href="{{ route('obras.index') }}" class="btn-ghost">Explorar</a>
            <a href="{{ route('obras.create') }}" class="btn-primary">+ Subir mi arte</a>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="btn-danger">Salir</button>
            </form>
        </div>
    </nav>

    <main class="relative z-10 max-w-6xl mx-auto px-4 py-10">

        <!-- Cabecera de Estadísticas -->
        <div class="glass rounded-3xl p-6 sm:p-8 mb-6 flex flex-col sm:flex-row justify-between items-center gap-6 rise d1">
            <div class="flex items-center gap-5 min-w-0 w-full sm:w-auto">
                <span class="avatar avatar-lg">{{ mb_strtoupper(mb_substr($usuario->name, 0, 1)) }}</span>
                <div class="min-w-0">
                    <p class="eyebrow mb-1">Panel de artista</p>
                    <h1 class="font-display text-2xl sm:text-4xl font-bold tracking-tight leading-tight title-grad">Panel de {{ $usuario->name }}</h1>
                    <p class="text-sm mt-1 truncate" style="color: var(--muted);">{{ $usuario->email }}</p>
                </div>
            </div>
            <div class="flex gap-3 sm:gap-4">
                <div class="stat stat-violet">
                    <span class="num">{{ $misObras->count() }}</span>
                    <span class="lbl">Obras subidas</span>
                </div>
                <div class="stat stat-pink">
                    <span class="num">❤️ {{ $totalLikes }}</span>
                    <span class="lbl">Likes recibidos</span>
                </div>
            </div>
        </div>

        <!-- Configuración de Perfil, Contacto y Privacidad -->
        <div class="glass rounded-3xl p-6 sm:p-8 mb-8 rise d2">
            <h3 class="font-display text-xl font-semibold text-white mb-1">Ajustes de Perfil y Contacto</h3>
            <p class="text-sm mb-6" style="color: var(--muted);">
                Personaliza tu información pública para que otros creadores y reclutadores puedan contactarte.
            </p>

            <form action="{{ route('perfil.ajustes') }}" method="POST" class="space-y-5">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="label">Biografía o Especialidad</label>
                        <input type="text" name="bio" value="{{ old('bio', $usuario->bio) }}"
                            placeholder="Ej: Modelador 3D Hard Surface & Environment Artist"
                            class="field">
                    </div>

                    <div>
                        <label class="label">Enlace de Contacto / Portafolio Externo</label>
                        <input type="url" name="contacto_url" value="{{ old('contacto_url', $usuario->contacto_url) }}"
                            placeholder="https://artstation.com/tu-usuario o LinkedIn"
                            class="field">
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pt-5" style="border-top: 1px solid var(--line);">
                    <div class="flex items-center gap-3">
                        <input type="checkbox" name="es_anonimo" id="es_anonimo" value="1"
                            {{ $usuario->es_anonimo ? 'checked' : '' }}
                            class="check">
                        <label for="es_anonimo" class="text-sm cursor-pointer select-none" style="color: #cfcfe3;">
                            Modo Anónimo (ocultar mi nombre y enlaces en publicaciones públicas)
                        </label>
                    </div>

                    <button type="submit" class="btn-save">
                        Guardar Ajustes
                    </button>
                </div>
            </form>
        </div>

        @if(session('success'))
            <div class="alert-ok mb-6 rise">
                <span>✅</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="flex items-end justify-between mb-6 rise d3">
            <h2 class="font-display text-2xl font-semibold text-white">Mis Publicaciones y Feedback Recibido</h2>
        </div>

        <div class="space-y-6">
            @forelse ($misObras as $obra)
                <div class="obra md:flex-row" style="animation-delay: {{ min($loop->index, 8) * 90 }}ms">

                    <!-- Imagen miniatura y datos de la obra -->
                    <div class="md:w-1/3 flex flex-col justify-between" style="border-right: 1px solid var(--line);">
                        <div class="thumb">
                            <img src="{{ route('imagen.mostrar', $obra->archivo_imagen) }}" alt="{{ $obra->titulo }}" class="w-full h-52 object-cover">
                        </div>
                        <div class="p-5 flex-1" style="border-top: 1px solid var(--line);">
                            <div class="flex items-center justify-between gap-2 mb-2">
                                <span class="tag">{{ $obra->categoria->nombre }}</span>
                                <span class="likes">❤️ {{ $obra->likes->count() }} Likes</span>
                            </div>
                            <h3 class="font-display font-semibold text-white text-lg leading-snug">{{ $obra->titulo }}</h3>

                            <form action="{{ route('obras.destroy', $obra->id) }}" method="POST" class="mt-4" onsubmit="return confirm('¿Seguro que deseas eliminar esta obra?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-del">🗑️ Eliminar publicación</button>
                            </form>
                        </div>
                    </div>

                    <!-- Panel de comentarios/críticas recibidas -->
                    <div class="md:w-2/3 p-6 flex flex-col justify-between" style="background: rgba(0,0,0,.18);">
                        <div>
                            <h4 class="eyebrow mb-4">Feedback recibido en esta obra ({{ $obra->comentarios->count() }})</h4>

                            <div class="feedback space-y-3 max-h-56 overflow-y-auto">
                                @forelse ($obra->comentarios as $c)
                                    <div class="comentario text-sm" data-tipo="{{ $c->tipo }}">
                                        <div class="flex justify-between items-center gap-3 mb-1.5">
                                            <span class="flex items-center gap-2.5 font-semibold text-sm text-white">
                                                <span class="avatar" style="width:1.6rem;height:1.6rem;font-size:.68rem;">{{ mb_strtoupper(mb_substr($c->usuario ? $c->usuario->nombreVisible() : 'Usuario', 0, 1)) }}</span>
                                                {{ $c->usuario ? $c->usuario->nombreVisible() : 'Usuario' }}
                                            </span>
                                            @if($c->tipo === 'critica')
                                                <span class="badge badge-critica">💡 Crítica constructiva</span>
                                            @elseif($c->tipo === 'pregunta')
                                                <span class="badge badge-pregunta">❓ Pregunta</span>
                                            @else
                                                <span class="badge badge-positiva">✨ Reseña positiva</span>
                                            @endif
                                        </div>
                                        <p class="leading-relaxed pl-[2.15rem]" style="color: #cfcfe3;">{{ $c->comentario }}</p>
                                    </div>
                                @empty
                                    <p class="text-xs italic" style="color: var(--muted);">No hay comentarios en esta obra todavía.</p>
                                @endforelse
                            </div>
                        </div>

                        <div class="mt-5 pt-4 text-right" style="border-top: 1px solid var(--line);">
                            <a href="{{ route('obras.show', $obra->id) }}" class="link-public">Ver vista pública <span>→</span></a>
                        </div>
                    </div>

                </div>
            @empty
                <div class="empty">
                    Aún no has subido ninguna obra. ¡Comparte tu primer trabajo con el botón de arriba!
                </div>
            @endforelse
        </div>

    </main>
</body>
</html>