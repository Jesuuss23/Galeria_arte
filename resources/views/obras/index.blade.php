<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galería de Arte</title>
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

        .dot-live {
            width: .5rem; height: .5rem; border-radius: 9999px; background: var(--emerald);
            box-shadow: 0 0 0 0 rgba(52, 211, 153, .6); animation: pulse 2s infinite;
        }
        @keyframes pulse {
            70% { box-shadow: 0 0 0 7px rgba(52, 211, 153, 0); }
            100% { box-shadow: 0 0 0 0 rgba(52, 211, 153, 0); }
        }

        /* ---------- Hero ---------- */
        .eyebrow { font-size: .68rem; text-transform: uppercase; letter-spacing: .22em; color: var(--muted); font-weight: 600; }
        .title-grad {
            background: linear-gradient(100deg, #fff 10%, #c4b5fd 45%, #f9a8d4 75%, #67e8f9 100%);
            background-size: 200% auto;
            -webkit-background-clip: text; background-clip: text; color: transparent;
            animation: shine 8s linear infinite;
        }
        @keyframes shine { to { background-position: 200% center; } }

        /* ---------- Formulario de filtros ---------- */
        .field {
            padding: .8rem 1rem; border-radius: .9rem; font-size: .88rem; color: var(--text);
            background: rgba(0, 0, 0, .3); border: 1px solid var(--line);
            transition: border-color .2s, box-shadow .2s, background .2s;
        }
        .field::placeholder { color: var(--muted); }
        .field:focus {
            outline: none; border-color: rgba(167, 139, 250, .7);
            box-shadow: 0 0 0 4px rgba(139, 92, 246, .18); background: rgba(0, 0, 0, .42);
        }
        select.field { cursor: pointer; color-scheme: dark; }
        select.field option { background: #12121c; color: #e9e9f4; }

        .btn-filter {
            padding: .8rem 1.6rem; border-radius: .9rem; font-size: .88rem; font-weight: 600; color: #fff;
            background: linear-gradient(120deg, var(--violet), var(--cyan));
            box-shadow: 0 10px 28px -10px rgba(34, 211, 238, .6);
            transition: transform .2s, box-shadow .2s;
        }
        .btn-filter:hover { transform: translateY(-2px); box-shadow: 0 16px 34px -12px rgba(34, 211, 238, .75); }
        .btn-filter:active { transform: scale(.97); }

        /* ---------- Alerta ---------- */
        .alert-ok {
            display: flex; align-items: center; gap: .6rem;
            padding: .85rem 1.1rem; border-radius: 1rem; font-size: .88rem; color: #6ee7b7;
            background: rgba(52, 211, 153, .08); border: 1px solid rgba(52, 211, 153, .3);
            box-shadow: 0 0 30px -12px rgba(52, 211, 153, .6);
        }

        /* ---------- Tarjetas de obra ---------- */
        .card {
            position: relative; border-radius: 1.4rem; overflow: hidden;
            background: var(--glass); border: 1px solid var(--line);
            transition: transform .35s cubic-bezier(.2,.8,.2,1), border-color .3s, box-shadow .35s;
            opacity: 0; transform: translateY(22px);
            animation: rise .7s cubic-bezier(.2,.8,.2,1) forwards;
        }
        .card:hover {
            transform: translateY(-6px);
            border-color: rgba(167, 139, 250, .5);
            box-shadow: 0 30px 60px -28px rgba(139, 92, 246, .7), 0 0 0 1px rgba(255,255,255,.04) inset;
        }
        .card .art { background: rgba(0, 0, 0, .35); }
        .card .art img { transition: transform .7s cubic-bezier(.2,.8,.2,1), filter .4s; }
        .card:hover .art img { transform: scale(1.06); filter: saturate(1.15); }
        .card .veil {
            background: linear-gradient(to top, rgba(10,10,18,.9), rgba(10,10,18,.15) 55%, transparent);
        }

        .tag {
            font-size: .64rem; text-transform: uppercase; letter-spacing: .12em; font-weight: 600;
            padding: .25rem .6rem; border-radius: .6rem; color: #c4b5fd;
            background: rgba(139, 92, 246, .14); border: 1px solid rgba(139, 92, 246, .3);
        }
        .likes {
            display: inline-flex; align-items: center; gap: .3rem; font-size: .75rem; font-weight: 600;
            padding: .2rem .55rem; border-radius: 9999px; color: #f9a8d4;
            background: rgba(236, 72, 153, .1); border: 1px solid rgba(236, 72, 153, .25);
        }
        .card-title { color: #fff; transition: color .25s; }
        .card:hover .card-title { color: #c4b5fd; }

        /* ---------- Estado vacío ---------- */
        .empty {
            border-radius: 1.6rem; padding: 4rem 1.5rem; text-align: center; color: var(--muted);
            background: var(--glass); border: 1px dashed rgba(255,255,255,.18);
        }

        /* ---------- Paginación (vista por defecto de Laravel) ---------- */
        .pager nav a,
        .pager nav span > span,
        .pager nav span[aria-disabled="true"] > span {
            background: var(--glass-strong) !important; border-color: var(--line) !important; color: var(--text) !important;
            transition: background .2s, border-color .2s, transform .2s;
        }
        .pager nav a:hover { background: rgba(139,92,246,.2) !important; border-color: rgba(167,139,250,.6) !important; transform: translateY(-2px); }
        .pager nav span[aria-current="page"] > span {
            background: linear-gradient(120deg, var(--violet), var(--pink)) !important;
            border-color: transparent !important; color: #fff !important; font-weight: 700;
        }
        .pager nav p, .pager nav div { color: var(--muted) !important; }
        .pager nav .shadow-sm { box-shadow: none !important; }
        .pager nav svg { color: currentColor; }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation: none !important; transition: none !important; }
            .rise, .card { opacity: 1; transform: none; }
        }
    </style>
</head>
<body class="min-h-screen relative">

    <!-- Fondo -->
    <div class="aurora" aria-hidden="true"><span></span><span></span><span></span></div>
    <div class="grain" aria-hidden="true"></div>

    <!-- Navbar -->
    <nav class="nav px-4 sm:px-6 py-3.5 flex justify-between items-center sticky top-0 z-50">
        <a href="{{ route('obras.index') }}" class="logo text-xl">
            🎨 Galería Creativa
        </a>

        <div class="flex items-center gap-2 sm:gap-3">
            @auth
                <!-- Perfil del usuario -->
                <a href="{{ route('obras.perfil') }}" class="btn-ghost">
                    <span class="dot-live"></span>
                    <span>{{ Auth::user()->name }}</span>
                </a>

                <!-- Botón Subir Arte -->
                <a href="{{ route('obras.create') }}" class="btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Subir mi arte</span>
                </a>

                <!-- Botón Salir Estilizado -->
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="btn-danger">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span>Salir</span>
                    </button>
                </form>
            @else
                <!-- Opciones para invitados -->
                <a href="{{ route('login') }}" class="btn-ghost">
                    Iniciar sesión
                </a>
                <a href="{{ route('register') }}" class="btn-primary">
                    Registrarse
                </a>
            @endauth
        </div>
    </nav>

    <!-- Contenido y Filtros -->
    <main class="relative z-10 max-w-7xl mx-auto px-4 py-10">

        <!-- Encabezado -->
        <header class="mb-8 rise d1">
            <p class="eyebrow mb-2">Catálogo</p>
            <h1 class="font-display text-4xl sm:text-6xl font-bold tracking-tight leading-tight title-grad">Descubre arte increíble</h1>
        </header>

        <!-- Buscador, Categorías y Ordenamiento -->
        <form method="GET" action="{{ route('obras.index') }}" class="glass rounded-3xl p-3 mb-8 flex flex-col md:flex-row gap-3 rise d2">
            <!-- Buscador -->
            <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="🔍  Buscar por título..."
                class="field flex-1">

            <!-- Filtro de Categoría -->
            <select name="categoria_id" class="field">
                <option value="">Todas las categorías</option>
                @foreach ($categorias as $cat)
                    <option value="{{ $cat->id }}" {{ request('categoria_id') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->nombre }}
                    </option>
                @endforeach
            </select>

            <!-- Selector de Ordenamiento -->
            <select name="orden" class="field">
                <option value="recientes" {{ request('orden') == 'recientes' ? 'selected' : '' }}>🕒 Más recientes</option>
                <option value="populares" {{ request('orden') == 'populares' ? 'selected' : '' }}>🔥 Más populares (Likes)</option>
            </select>

            <button type="submit" class="btn-filter">
                Filtrar
            </button>
        </form>

        @if(session('success'))
            <div class="alert-ok mb-6 rise">
                <span>✅</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Catálogo de Arte estilo Masonry -->
        <div class="columns-1 sm:columns-2 md:columns-3 lg:columns-4 gap-5 space-y-5">
            @forelse ($obras as $obra)
                <div class="card break-inside-avoid group" style="animation-delay: {{ min($loop->index, 12) * 70 }}ms">

                    <!-- Contenedor de la Imagen con Aspect Ratio Original -->
                    <a href="{{ route('obras.show', $obra->id) }}" class="art block relative overflow-hidden">
                        <img src="{{ route('imagen.mostrar', $obra->archivo_imagen) }}"
                            alt="{{ $obra->titulo }}"
                            loading="lazy"
                            class="w-full h-auto object-cover">

                        <!-- Overlay sutil al pasar el cursor -->
                        <div class="veil absolute inset-0 opacity-0 group-hover:opacity-100 transition duration-300 flex items-end p-4">
                            <span class="text-white text-xs font-semibold tracking-wide">Ver detalles completos →</span>
                        </div>
                    </a>

                    <!-- Metadatos de la Obra -->
                    <div class="p-4">
                        <div class="flex items-center justify-between gap-2 mb-3">
                            <span class="tag">
                                {{ $obra->categoria->nombre }}
                            </span>
                            <span class="likes">
                                ❤️ {{ $obra->likes->count() }}
                            </span>
                        </div>

                        <h3 class="card-title font-display font-semibold text-base leading-snug line-clamp-1">
                            <a href="{{ route('obras.show', $obra->id) }}">{{ $obra->titulo }}</a>
                        </h3>

                        <p class="text-xs mt-1" style="color: var(--muted);">
                            Por <span class="font-medium text-white/80">{{ $obra->usuario ? $obra->usuario->nombreVisible() : 'Artista' }}</span>
                        </p>
                    </div>

                </div>
            @empty
                <div class="empty col-span-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-3" style="color: rgba(167,139,250,.6);" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    No se encontraron obras con los filtros aplicados.
                </div>
            @endforelse
        </div>

        <!-- Paginación -->
        <div class="pager mt-12 flex justify-center">
            {{ $obras->links() }}
        </div>
    </main>

</body>
</html>