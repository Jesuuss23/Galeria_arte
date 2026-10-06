<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $obra->titulo }} - Galería</title>
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
        .aurora {
            position: fixed; inset: 0; z-index: 0; overflow: hidden; pointer-events: none;
        }
        .aurora span {
            position: absolute; border-radius: 9999px; filter: blur(110px); opacity: .42;
            animation: drift 22s ease-in-out infinite alternate;
        }
        .aurora span:nth-child(1) { width: 46vw; height: 46vw; background: var(--violet); top: -14vw; left: -10vw; }
        .aurora span:nth-child(2) { width: 38vw; height: 38vw; background: var(--pink);   bottom: -12vw; right: -8vw; animation-delay: -7s; opacity: .32; }
        .aurora span:nth-child(3) { width: 30vw; height: 30vw; background: var(--cyan);   top: 38%; left: 52%; animation-delay: -13s; opacity: .22; }
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

        /* ---------- Imagen principal ---------- */
        .stage { position: relative; perspective: 1400px; }
        .stage-glow {
            position: absolute; inset: 6% 8%; z-index: 0; border-radius: 2rem;
            background-size: cover; background-position: center;
            filter: blur(60px) saturate(1.6); opacity: .55; transform: scale(1.05);
        }
        .frame {
            position: relative; z-index: 1; border-radius: 1.5rem; overflow: hidden;
            border: 1px solid var(--line);
            background: rgba(0, 0, 0, .35);
            box-shadow: 0 40px 90px -30px rgba(0, 0, 0, .8), 0 0 0 1px rgba(255,255,255,.03) inset;
            transition: transform .25s ease-out, box-shadow .3s;
            transform-style: preserve-3d;
            will-change: transform;
        }
        .frame::after { /* brillo que sigue el cursor */
            content: ''; position: absolute; inset: 0; pointer-events: none;
            background: radial-gradient(420px circle at var(--mx, 50%) var(--my, 30%), rgba(255,255,255,.14), transparent 45%);
            opacity: 0; transition: opacity .3s;
        }
        .frame:hover::after { opacity: 1; }

        /* ---------- Título ---------- */
        .title-grad {
            background: linear-gradient(100deg, #fff 10%, #c4b5fd 45%, #f9a8d4 75%, #67e8f9 100%);
            background-size: 200% auto;
            -webkit-background-clip: text; background-clip: text; color: transparent;
            animation: shine 8s linear infinite;
        }
        @keyframes shine { to { background-position: 200% center; } }

        /* ---------- Chips ---------- */
        .chip {
            display: inline-flex; align-items: center; gap: .35rem;
            padding: .28rem .7rem; border-radius: 9999px; font-size: .72rem; font-weight: 500;
            background: var(--glass-strong); border: 1px solid var(--line); color: var(--text);
            transition: transform .2s, border-color .2s, background .2s;
        }
        .chip:hover { transform: translateY(-2px); border-color: rgba(167,139,250,.55); background: rgba(139,92,246,.14); }

        /* ---------- Botón Like ---------- */
        .btn-like {
            position: relative; display: inline-flex; align-items: center; gap: .6rem;
            padding: .7rem 1.3rem; border-radius: 9999px; font-weight: 600; font-size: .9rem; color: #fff;
            background: linear-gradient(120deg, var(--pink), var(--violet));
            box-shadow: 0 10px 30px -10px rgba(236, 72, 153, .75);
            transition: transform .2s, box-shadow .2s;
            overflow: hidden;
        }
        .btn-like::before {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(120deg, transparent 30%, rgba(255,255,255,.35) 50%, transparent 70%);
            transform: translateX(-120%); transition: transform .7s;
        }
        .btn-like:hover { transform: translateY(-3px) scale(1.03); box-shadow: 0 18px 40px -12px rgba(236, 72, 153, .9); }
        .btn-like:hover::before { transform: translateX(120%); }
        .btn-like:active { transform: scale(.96); }
        .btn-like .heart { display: inline-block; animation: beat 1.8s ease-in-out infinite; }
        @keyframes beat { 0%,100% { transform: scale(1); } 12% { transform: scale(1.25); } 24% { transform: scale(1); } 36% { transform: scale(1.15); } }

        .like-static {
            display: inline-flex; align-items: center; gap: .5rem;
            padding: .6rem 1.1rem; border-radius: 9999px; font-size: .85rem; font-weight: 600;
            background: var(--glass-strong); border: 1px solid var(--line); color: var(--text);
        }

        /* ---------- Tabs ---------- */
        .tabs {
            display: inline-flex; gap: .25rem; padding: .3rem; border-radius: 1rem;
            background: rgba(0,0,0,.28); border: 1px solid var(--line);
            max-width: 100%; overflow-x: auto; scrollbar-width: none;
        }
        .tabs::-webkit-scrollbar { display: none; }
        .tab-btn {
            white-space: nowrap; padding: .5rem .95rem; border-radius: .75rem;
            font-size: .82rem; font-weight: 500; color: var(--muted);
            transition: color .2s, background .2s, transform .2s;
        }
        .tab-btn:hover { color: #fff; background: rgba(255,255,255,.06); }
        .tab-btn.is-active {
            color: #fff; font-weight: 600;
            background: linear-gradient(120deg, rgba(139,92,246,.9), rgba(236,72,153,.8));
            box-shadow: 0 8px 22px -8px rgba(139,92,246,.9);
        }

        /* ---------- Comentarios ---------- */
        .comentario-item {
            --accent: var(--emerald);
            position: relative; padding: 1.1rem 1.25rem 1.1rem 1.5rem; border-radius: 1.1rem; overflow: hidden;
            background: var(--glass); border: 1px solid var(--line);
            transition: transform .25s, background .25s, border-color .25s;
            animation: rise .6s cubic-bezier(.2,.8,.2,1) both;
        }
        .comentario-item::before {
            content: ''; position: absolute; left: 0; top: 14%; bottom: 14%; width: 3px; border-radius: 3px;
            background: var(--accent); box-shadow: 0 0 16px var(--accent);
        }
        .comentario-item:hover { transform: translateX(4px); background: var(--glass-strong); border-color: rgba(255,255,255,.16); }
        .comentario-item[data-tipo="critica"]  { --accent: var(--amber); }
        .comentario-item[data-tipo="pregunta"] { --accent: var(--cyan); }
        .comentario-item[data-tipo="positiva"] { --accent: var(--emerald); }

        .avatar {
            width: 2rem; height: 2rem; border-radius: 9999px; display: grid; place-items: center;
            font-family: 'Space Grotesk', sans-serif; font-weight: 700; font-size: .8rem; color: #fff;
            background: linear-gradient(135deg, var(--violet), var(--cyan));
        }

        .badge {
            font-size: .68rem; font-weight: 600; padding: .22rem .65rem; border-radius: 9999px;
            border: 1px solid; white-space: nowrap;
        }
        .badge-critica  { color: #fcd34d; background: rgba(251,191,36,.1);  border-color: rgba(251,191,36,.3); }
        .badge-pregunta { color: #67e8f9; background: rgba(34,211,238,.1);  border-color: rgba(34,211,238,.3); }
        .badge-positiva { color: #6ee7b7; background: rgba(52,211,153,.1);  border-color: rgba(52,211,153,.3); }

        .link-back { color: var(--muted); transition: color .2s, transform .2s; display: inline-flex; align-items: center; gap: .5rem; }
        .link-back:hover { color: #fff; transform: translateX(-4px); }

        .eyebrow { font-size: .68rem; text-transform: uppercase; letter-spacing: .22em; color: var(--muted); font-weight: 600; }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation: none !important; transition: none !important; }
            .rise { opacity: 1; transform: none; }
        }
    </style>
</head>
<body class="min-h-screen py-8 px-4 relative">

    <!-- Fondo -->
    <div class="aurora" aria-hidden="true"><span></span><span></span><span></span></div>
    <div class="grain" aria-hidden="true"></div>

    <div class="relative z-10 max-w-4xl mx-auto">

        <!-- Barra superior -->
        <div class="glass rounded-2xl px-5 py-3.5 flex justify-between items-center rise d1">
            <a href="{{ route('obras.index') }}" class="link-back text-sm font-medium">
                <span>←</span> Volver al catálogo
            </a>
            <span class="chip" style="background: linear-gradient(120deg, rgba(139,92,246,.25), rgba(236,72,153,.2)); border-color: rgba(167,139,250,.4);">
                {{ $obra->categoria->nombre }}
            </span>
        </div>

        <!-- Imagen principal -->
        <div class="stage mt-6 rise d2">
            <div class="stage-glow" style="background-image: url('{{ asset('storage/obras/' . $obra->archivo_imagen) }}');"></div>
            <div class="frame flex justify-center" id="frame">
                <img src="{{ asset('storage/obras/' . $obra->archivo_imagen) }}" alt="{{ $obra->titulo }}" class="max-h-[600px] w-auto object-contain">
            </div>
        </div>

        <!-- Panel de información -->
        <div class="glass rounded-3xl p-6 sm:p-8 mt-6 rise d3">
            <div class="flex flex-col sm:flex-row justify-between sm:items-start gap-5">
                <div class="min-w-0">
                    <p class="eyebrow mb-2">Obra</p>
                    <h1 class="font-display text-3xl sm:text-5xl font-bold tracking-tight leading-tight title-grad">{{ $obra->titulo }}</h1>

                    <div class="flex flex-wrap items-center gap-2 mt-4">
                        <p class="flex items-center gap-2 text-sm" style="color: var(--muted);">
                            <span class="avatar">{{ mb_strtoupper(mb_substr($obra->usuario ? $obra->usuario->nombreVisible() : 'Artista', 0, 1)) }}</span>
                            <span>Publicado por <strong class="text-white font-semibold">{{ $obra->usuario ? $obra->usuario->nombreVisible() : 'Artista' }}</strong></span>
                        </p>

                        @if($obra->usuario && !$obra->usuario->es_anonimo)
                            @if($obra->usuario->bio)
                                <span style="color: var(--line);">•</span>
                                <span class="chip">{{ $obra->usuario->bio }}</span>
                            @endif

                            @if($obra->usuario->contacto_url)
                                <span style="color: var(--line);">•</span>
                                <a href="{{ $obra->usuario->contacto_url }}" target="_blank" rel="noopener noreferrer" class="chip" style="color: #a5f3fc;">
                                    🔗 Contacto / Redes
                                </a>
                            @endif
                        @endif
                    </div>
                </div>

                <!-- Botón de Like -->
                @auth
                    <form action="{{ route('obras.like', $obra->id) }}" method="POST" class="shrink-0">
                        @csrf
                        <button type="submit" class="btn-like">
                            <span class="heart">❤️</span> <span>{{ $obra->likes->count() }} Likes</span>
                        </button>
                    </form>
                @else
                    <span class="like-static shrink-0">
                        ❤️ {{ $obra->likes->count() }} Likes
                    </span>
                @endauth
            </div>

            @if($obra->descripcion)
                <p class="mt-6 leading-relaxed p-5 rounded-2xl text-[.95rem]" style="background: rgba(0,0,0,.25); border: 1px solid var(--line); color: #cfcfe3;">{{ $obra->descripcion }}</p>
            @endif

            @if($obra->herramientas)
                <div class="mt-6 pt-6" style="border-top: 1px solid var(--line);">
                    <h4 class="eyebrow mb-3">Software y herramientas</h4>
                    <div class="flex flex-wrap gap-2">
                        @foreach(explode(',', $obra->herramientas) as $tool)
                            <span class="chip">
                                🛠️ {{ trim($tool) }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Filtros de Comentarios -->
            <div class="mt-8 mb-6 pt-6 flex flex-col sm:flex-row sm:items-center justify-between gap-3" style="border-top: 1px solid var(--line);">
                <h3 class="font-display text-xl font-semibold text-white">Conversación</h3>
                <div class="tabs text-sm">
                    <button onclick="filtrarComentarios('todos', this)" class="tab-btn is-active">
                        Todos ({{ $obra->comentarios->count() }})
                    </button>
                    <button onclick="filtrarComentarios('critica', this)" class="tab-btn">
                        💡 Críticas ({{ $obra->comentarios->where('tipo', 'critica')->count() }})
                    </button>
                    <button onclick="filtrarComentarios('positiva', this)" class="tab-btn">
                        ✨ Reseñas ({{ $obra->comentarios->where('tipo', 'positiva')->count() }})
                    </button>
                    <button onclick="filtrarComentarios('pregunta', this)" class="tab-btn">
                        ❓ Preguntas ({{ $obra->comentarios->where('tipo', 'pregunta')->count() }})
                    </button>
                </div>
            </div>

            <!-- Contenedor de Comentarios -->
            <div class="space-y-3" id="contenedor-comentarios">
                @forelse ($obra->comentarios as $c)
                    <div class="comentario-item" data-tipo="{{ $c->tipo }}">
                        <div class="flex justify-between items-center gap-3 mb-2">
                            <span class="flex items-center gap-2.5 font-semibold text-sm text-white">
                                <span class="avatar">{{ mb_strtoupper(mb_substr($c->usuario ? $c->usuario->nombreVisible() : 'Usuario', 0, 1)) }}</span>
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
                        <p class="text-sm leading-relaxed pl-[2.6rem]" style="color: #cfcfe3;">{{ $c->comentario }}</p>
                    </div>
                @empty
                    <p id="sin-comentarios" class="text-sm py-8 text-center" style="color: var(--muted);">Aún no hay comentarios en esta obra. ¡Sé el primero!</p>
                @endforelse
                <p id="sin-resultados-filtro" class="text-sm py-8 text-center hidden" style="color: var(--muted);">No hay comentarios en esta categoría.</p>
            </div>

            <!-- Script del Filtro en tiempo real -->
            <script>
            function filtrarComentarios(tipo, btn) {
                // Estilos de los botones
                document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('is-active'));
                btn.classList.add('is-active');

                // Filtrar elementos
                const items = document.querySelectorAll('.comentario-item');
                let visibles = 0;

                items.forEach(item => {
                    if (tipo === 'todos' || item.dataset.tipo === tipo) {
                        item.style.display = 'block';
                        item.style.animation = 'none';
                        item.offsetHeight; // reinicia la animación de entrada
                        item.style.animation = '';
                        visibles++;
                    } else {
                        item.style.display = 'none';
                    }
                });

                const msgVacio = document.getElementById('sin-resultados-filtro');
                if (msgVacio) {
                    msgVacio.classList.toggle('hidden', visibles > 0);
                }
            }
            </script>

        </div>
    </div>

    <!-- Efecto 3D / brillo sobre la imagen -->
    <script>
        (function () {
            const frame = document.getElementById('frame');
            if (!frame || window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
            frame.addEventListener('mousemove', e => {
                const r = frame.getBoundingClientRect();
                const x = (e.clientX - r.left) / r.width;
                const y = (e.clientY - r.top) / r.height;
                frame.style.setProperty('--mx', (x * 100) + '%');
                frame.style.setProperty('--my', (y * 100) + '%');
                frame.style.transform = `rotateY(${(x - .5) * 6}deg) rotateX(${(.5 - y) * 6}deg)`;
            });
            frame.addEventListener('mouseleave', () => { frame.style.transform = ''; });
        })();
    </script>
</body>
</html>