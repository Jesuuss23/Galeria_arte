<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil Artístico y Billetera</title>
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

        .comentario p, .comentario span, .obra h3, .glass h1, .glass p, .tag, .likes {
            overflow-wrap: anywhere; word-break: break-word; min-width: 0; max-width: 100%;
        }
        .comentario { min-width: 0; max-width: 100%; }
        .obra > div { min-width: 0; }
        .obra > div > div { min-width: 0; }
        .feedback { overflow-x: hidden; min-width: 0; }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'Inter', sans-serif;
            -webkit-font-smoothing: antialiased;
        }

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
        }

        .btn-ghost {
            display: inline-flex; align-items: center; gap: .5rem;
            padding: .5rem .9rem; border-radius: .8rem; font-size: .85rem; font-weight: 500;
            color: var(--text); background: var(--glass-strong); border: 1px solid var(--line);
            transition: transform .2s, border-color .2s, background .2s;
        }
        .btn-ghost:hover { transform: translateY(-2px); border-color: rgba(167,139,250,.55); background: rgba(139,92,246,.14); }

        .btn-primary {
            display: inline-flex; align-items: center; gap: .4rem;
            padding: .55rem 1.05rem; border-radius: .8rem; font-size: .85rem; font-weight: 600; color: #fff;
            background: linear-gradient(120deg, var(--violet), var(--pink));
            box-shadow: 0 10px 28px -10px rgba(139, 92, 246, .85);
            transition: transform .2s, box-shadow .2s;
        }
        .btn-primary:hover { transform: translateY(-2px) scale(1.03); }

        .btn-danger {
            display: inline-flex; align-items: center; gap: .4rem; cursor: pointer;
            padding: .5rem .9rem; border-radius: .8rem; font-size: .85rem; font-weight: 500;
            color: #fda4af; background: rgba(244, 63, 94, .08); border: 1px solid rgba(244, 63, 94, .25);
            transition: transform .2s, background .2s;
        }

        .eyebrow { font-size: .68rem; text-transform: uppercase; letter-spacing: .22em; color: var(--muted); font-weight: 600; }
        .title-grad {
            background: linear-gradient(100deg, #fff 10%, #c4b5fd 45%, #f9a8d4 75%, #67e8f9 100%);
            -webkit-background-clip: text; background-clip: text; color: transparent;
        }

        .avatar {
            width: 2rem; height: 2rem; border-radius: 9999px; display: grid; place-items: center; flex-shrink: 0;
            font-family: 'Space Grotesk', sans-serif; font-weight: 700; font-size: .8rem; color: #fff;
            background: linear-gradient(135deg, var(--violet), var(--cyan));
        }
        .avatar-lg { width: 4.2rem; height: 4.2rem; font-size: 1.6rem; box-shadow: 0 0 40px -6px rgba(139,92,246,.8); }

        .stat {
            position: relative; text-align: center; padding: .9rem 1.3rem; border-radius: 1.1rem; min-width: 8rem;
            background: var(--glass-strong); border: 1px solid var(--line);
            transition: transform .25s, border-color .25s;
        }
        .stat:hover { transform: translateY(-3px); }
        .stat .num { display: block; font-family: 'Space Grotesk', sans-serif; font-size: 1.7rem; font-weight: 700; line-height: 1.1; }
        .stat .lbl { font-size: .68rem; color: var(--muted); font-weight: 500; letter-spacing: .06em; text-transform: uppercase; }

        .label { display: block; font-size: .68rem; text-transform: uppercase; letter-spacing: .14em; font-weight: 600; color: var(--muted); margin-bottom: .45rem; }
        .field {
            width: 100%; padding: .75rem .95rem; border-radius: .9rem; font-size: .88rem; color: var(--text);
            background: rgba(0, 0, 0, .35); border: 1px solid var(--line);
            transition: border-color .2s, box-shadow .2s;
        }
        .field:focus { outline: none; border-color: rgba(167, 139, 250, .7); box-shadow: 0 0 0 3px rgba(139, 92, 246, .2); }

        .check {
            appearance: none; -webkit-appearance: none; width: 1.25rem; height: 1.25rem; border-radius: .4rem; cursor: pointer; position: relative;
            background: rgba(0,0,0,.35); border: 1px solid rgba(255,255,255,.22);
        }
        .check:checked { background: linear-gradient(135deg, var(--violet), var(--pink)); border-color: transparent; }
        .check:checked::after {
            content: ''; position: absolute; left: 6px; top: 2px; width: 5px; height: 10px;
            border: solid #fff; border-width: 0 2px 2px 0; transform: rotate(45deg);
        }

        .btn-save {
            padding: .75rem 1.5rem; border-radius: .9rem; font-size: .82rem; font-weight: 600; color: #fff;
            background: linear-gradient(120deg, var(--violet), var(--cyan));
            box-shadow: 0 10px 28px -10px rgba(34, 211, 238, .6);
            transition: transform .2s;
        }
        .btn-save:hover { transform: translateY(-2px); }

        .btn-del {
            display: inline-flex; align-items: center; gap: .35rem; cursor: pointer;
            font-size: .75rem; font-weight: 600; color: #fda4af;
            padding: .4rem .8rem; border-radius: .7rem;
            background: rgba(244, 63, 94, .08); border: 1px solid rgba(244, 63, 94, .22);
            transition: background .2s, transform .2s;
        }
        .btn-del:hover { background: rgba(244, 63, 94, .18); transform: translateY(-2px); }

        .tag {
            font-size: .64rem; text-transform: uppercase; letter-spacing: .12em; font-weight: 600;
            padding: .25rem .6rem; border-radius: .6rem; color: #c4b5fd;
            background: rgba(139, 92, 246, .14); border: 1px solid rgba(139, 92, 246, .3);
        }

        .obra {
            border-radius: 1.6rem; overflow: hidden; display: flex; flex-direction: column;
            background: var(--glass); border: 1px solid var(--line);
        }
        .empty {
            border-radius: 1.6rem; padding: 3rem 1.5rem; text-align: center; color: var(--muted);
            background: var(--glass); border: 1px dashed rgba(255,255,255,.18);
        }
    </style>
</head>
<body class="min-h-screen relative pb-16">

    <div class="aurora" aria-hidden="true"><span></span><span></span><span></span></div>
    <div class="grain" aria-hidden="true"></div>

    <!-- Navbar -->
    <nav class="nav px-4 sm:px-6 py-3.5 flex justify-between items-center sticky top-0 z-50">
        <a href="{{ route('obras.index') }}" class="logo text-xl">🎨 Galería Creativa</a>
        <div class="flex items-center gap-2 sm:gap-3">
            <a href="{{ route('obras.index') }}" class="btn-ghost">Explorar</a>
            <a href="{{ route('pedidos.index') }}" class="btn-ghost">Contrataciones</a>
            <a href="{{ route('obras.create') }}" class="btn-primary">+ Subir mi arte</a>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="btn-danger">Salir</button>
            </form>
        </div>
    </nav>

    <main class="relative z-10 max-w-6xl mx-auto px-4 py-8">

        <!-- Notificaciones -->
        @if(session('success'))
            <div class="mb-6 p-4 rounded-2xl border border-emerald-500/40 bg-emerald-500/10 text-emerald-300 text-sm flex items-center gap-3">
                <span class="text-lg">✅</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 p-4 rounded-2xl border border-rose-500/40 bg-rose-500/10 text-rose-300 text-sm flex items-center gap-3">
                <span class="text-lg">⚠️</span>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Cabecera de Estadísticas y Saldos de Billetera -->
        <div class="glass rounded-3xl p-6 sm:p-8 mb-6 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 rise d1">
            <div class="flex items-center gap-5 min-w-0">
                <span class="avatar avatar-lg">{{ mb_strtoupper(mb_substr($usuario->name, 0, 1)) }}</span>
                <div class="min-w-0">
                    <p class="eyebrow mb-1">Panel de Usuario y Artista</p>
                    <h1 class="font-display text-2xl sm:text-3xl font-bold tracking-tight leading-tight title-grad">{{ $usuario->name }}</h1>
                    <p class="text-sm mt-1 truncate" style="color: var(--muted);">{{ $usuario->email }}</p>
                </div>
            </div>

            <!-- Panel de Balance y Contadores -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 w-full lg:w-auto">
                <div class="stat border-emerald-500/30">
                    <span class="num text-emerald-400">S/ {{ number_format($usuario->saldo_disponible, 2) }}</span>
                    <span class="lbl">Saldo Disponible</span>
                </div>
                <div class="stat border-amber-500/30">
                    <span class="num text-amber-400">S/ {{ number_format($usuario->saldo_retenido, 2) }}</span>
                    <span class="lbl">En Custodia</span>
                </div>
                <div class="stat">
                    <span class="num text-violet-300">{{ $misObras->count() }}</span>
                    <span class="lbl">Obras</span>
                </div>
                <div class="stat">
                    <span class="num text-pink-300">❤️ {{ $totalLikes }}</span>
                    <span class="lbl">Likes</span>
                </div>
            </div>
        </div>

        <!-- Módulo de Recarga de Saldo (Pasarela Simulada) -->
        <div class="glass rounded-3xl p-6 sm:p-8 mb-8 rise d2 border-emerald-500/20">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                <div>
                    <h3 class="font-display text-xl font-semibold text-white flex items-center gap-2">
                        💳 Billetera y Pasarela de Fondos
                    </h3>
                    <p class="text-sm mt-1" style="color: var(--muted);">
                        Recarga saldo ficticio a tu cuenta para contratar artistas mediante el sistema de fideicomiso (Escrow).
                    </p>
                </div>
                <span class="text-xs px-3 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 font-medium">
                    Simulación
                </span>
            </div>

            <form action="{{ route('billetera.recargar') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <label class="label">Monto a Depositar (PEN)</label>
                        <input type="number" step="0.5" min="5" name="monto" placeholder="S/ 100.00" class="field" required>
                    </div>
                    <div>
                        <label class="label">Nombre del Titular</label>
                        <input type="text" name="titular" value="{{ $usuario->name }}" placeholder="Como figura en la tarjeta" class="field" required>
                    </div>
                    <div>
                        <label class="label">Número de Tarjeta</label>
                        <input type="text" name="numero_tarjeta" maxlength="19" placeholder="4000 1234 5678 9010" class="field" required>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="label">Expiración</label>
                            <input type="text" name="expiracion" placeholder="MM/AA" maxlength="5" class="field" required>
                        </div>
                        <div>
                            <label class="label">CVV</label>
                            <input type="password" name="cvv" placeholder="123" maxlength="4" class="field" required>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row justify-between items-center gap-4 pt-3">
                    <label class="flex items-center gap-2.5 text-xs text-slate-400 cursor-pointer">
                        <input type="checkbox" name="guardar_tarjeta" value="1" class="check">
                        <span>Guardar credenciales de pago para futuras contrataciones</span>
                    </label>

                    <button type="submit" class="w-full sm:w-auto px-6 py-2.5 rounded-xl font-semibold text-sm text-slate-950 bg-emerald-400 hover:bg-emerald-300 shadow-lg shadow-emerald-500/20 transition-transform active:scale-95">
                        💳 Procesar Recarga Inmediata
                    </button>
                </div>
            </form>
            <!-- Módulo de Retiro de Fondos -->
            <div class="mt-8 pt-6 border-t border-white/10">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 mb-4">
                    <div>
                        <h4 class="text-base font-semibold text-white flex items-center gap-2">
                            🏦 Retiro a Cuenta Bancaria (CCI)
                        </h4>
                        <p class="text-xs text-slate-400">
                            Transfiere tus ganancias acumuladas directamente a tu banco nacional. Monto mínimo de retiro: <strong class="text-amber-300">S/ 100.00</strong>.
                        </p>
                    </div>
                    <span class="text-xs px-3 py-1 rounded-full bg-violet-500/10 border border-violet-500/30 text-violet-300">
                        Comisión de retiro: S/ 0.00
                    </span>
                </div>

                <form action="{{ route('billetera.retirar') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <label class="label">Monto a Retirar (PEN)</label>
                            <input type="number" step="0.5" min="100" name="monto_retiro" placeholder="Mínimo S/ 100.00" class="field" required>
                        </div>
                        <div>
                            <label class="label">Banco Destino</label>
                            <select name="banco" class="field" required>
                                <option value="BCP">BCP (Banco de Crédito)</option>
                                <option value="Interbank">Interbank</option>
                                <option value="BBVA">BBVA</option>
                                <option value="Scotiabank">Scotiabank</option>
                                <option value="Banco de la Nación">Banco de la Nación</option>
                            </select>
                        </div>
                        <div>
                            <label class="label">Código Interbancario (CCI)</label>
                            <input type="text" name="cci" maxlength="20" placeholder="002-194-000000000000-00" class="field" required>
                        </div>
                        <div>
                            <label class="label">Nombre del Beneficiario</label>
                            <input type="text" name="titular" value="{{ $usuario->name }}" class="field" required>
                        </div>
                    </div>

                    <div class="text-right pt-2">
                        <button type="submit" class="w-full sm:w-auto px-6 py-2.5 rounded-xl font-semibold text-sm text-white bg-gradient-to-r from-violet-600 to-pink-600 hover:from-violet-500 hover:to-pink-500 shadow-lg shadow-violet-500/20 transition-transform active:scale-95">
                            💸 Solicitar Retiro de Fondos
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Módulo: Mis Servicios Ofrecidos como Artista -->
        <div class="glass rounded-3xl p-6 sm:p-8 mb-8 rise d2 border-violet-500/20">
            <h3 class="font-display text-xl font-semibold text-white mb-1">🎨 Mi Catálogo de Servicios para Encargos</h3>
            <p class="text-sm mb-6" style="color: var(--muted);">
                Define las comisiones artísticas que ofreces al público (ej: Retratos digitales, Ilustraciones, Modelado 3D).
            </p>

            <!-- Formulario para crear nuevo servicio -->
            <form action="{{ route('servicios.store') }}" method="POST" class="p-5 rounded-2xl bg-black/30 border border-white/5 mb-6 space-y-4">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="sm:col-span-2">
                        <label class="label">Título del Servicio</label>
                        <input type="text" name="titulo" placeholder="Ej: Ilustración de Personaje / Concept Art" class="field" required>
                    </div>
                    <div>
                        <label class="label">Precio Base (S/)</label>
                        <input type="number" step="0.5" min="5" name="precio_base" placeholder="80.00" class="field" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="sm:col-span-2">
                        <label class="label">Descripción y Entregables</label>
                        <textarea name="descripcion" rows="2" placeholder="Detalla qué incluye el encargo, revisiones, formatos de entrega..." class="field" required></textarea>
                    </div>
                    <div>
                        <label class="label">Días Estimados de Entrega</label>
                        <input type="number" min="1" name="dias_entrega" placeholder="5" class="field" required>
                    </div>
                </div>

                <div class="text-right">
                    <button type="submit" class="btn-primary text-xs">
                        + Añadir Servicio a mi Portafolio
                    </button>
                </div>
            </form>

            <!-- Listado de servicios publicados -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @forelse($usuario->servicios as $servicio)
                    <div class="p-4 rounded-2xl bg-white/[0.03] border border-white/10 flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start gap-2 mb-2">
                                <h4 class="font-semibold text-white text-base">{{ $servicio->titulo }}</h4>
                                <span class="text-sm font-bold text-violet-300">S/ {{ number_format($servicio->precio_base, 2) }}</span>
                            </div>
                            <p class="text-xs text-slate-300 mb-3 leading-relaxed">{{ $servicio->descripcion }}</p>
                        </div>

                        <div class="flex justify-between items-center pt-3 border-t border-white/5 text-xs text-slate-400">
                            <span>⏱️ {{ $servicio->dias_entrega }} días aprox.</span>
                            <form action="{{ route('servicios.destroy', $servicio->id) }}" method="POST" onsubmit="return confirm('¿Retirar este servicio?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-rose-400 hover:text-rose-300 underline font-medium">Eliminar</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 italic md:col-span-2">No has publicado ningún servicio todavía. Agrega uno arriba para que los clientes puedan solicitarte comisiones.</p>
                @endforelse
            </div>
        </div>

        <!-- Ajustes de Perfil, Contacto y Visibilidad Escrow -->
        <div class="glass rounded-3xl p-6 sm:p-8 mb-8 rise d2">
            <h3 class="font-display text-xl font-semibold text-white mb-1">Ajustes de Perfil y Disponibilidad</h3>
            <p class="text-sm mb-6" style="color: var(--muted);">
                Configura tu visibilidad en la plataforma y el estado de recepción de nuevos contratos.
            </p>

            <form action="{{ route('perfil.ajustes') }}" method="POST" class="space-y-5">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="label">Biografía o Especialidad</label>
                        <input type="text" name="bio" value="{{ old('bio', $usuario->bio) }}"
                            placeholder="Ej: Ilustrador freelance y diseñador 3D"
                            class="field">
                    </div>

                    <div>
                        <label class="label">Enlace de Contacto / Portafolio Externo</label>
                        <input type="url" name="contacto_url" value="{{ old('contacto_url', $usuario->contacto_url) }}"
                            placeholder="https://artstation.com/tu-usuario"
                            class="field">
                    </div>
                </div>

                <!-- Switches de Privacidad y Disponibilidad -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-4 border-t border-white/10">
                    <div class="flex items-center gap-3">
                        <input type="checkbox" name="es_publico" id="es_publico" value="1"
                            {{ $usuario->es_publico ? 'checked' : '' }}
                            class="check">
                        <label for="es_publico" class="text-xs cursor-pointer select-none text-slate-300">
                            <strong>Perfil Público para Contrataciones</strong> (Permitir que clientes vean mis servicios y envíen encargos).
                        </label>
                    </div>

                    <div class="flex items-center gap-3">
                        <input type="checkbox" name="es_anonimo" id="es_anonimo" value="1"
                            {{ $usuario->es_anonimo ? 'checked' : '' }}
                            class="check">
                        <label for="es_anonimo" class="text-xs cursor-pointer select-none text-slate-300">
                            <strong>Modo Anónimo</strong> (Ocultar mi nombre real en el catálogo general de obras).
                        </label>
                    </div>
                </div>

                <div class="text-right pt-4">
                    <button type="submit" class="btn-save">
                        Guardar Ajustes de Perfil
                    </button>
                </div>
            </form>
        </div>

        <!-- Mis Publicaciones y Feedback -->
        <div class="flex items-end justify-between mb-6 rise d3">
            <h2 class="font-display text-2xl font-semibold text-white">Mis Obras Publicadas</h2>
        </div>

        <div class="space-y-6">
            @forelse ($misObras as $obra)
                <div class="obra md:flex-row">
                    <div class="md:w-1/3 flex flex-col justify-between" style="border-right: 1px solid var(--line);">
                        <div class="thumb">
                            <img src="{{ route('imagen.mostrar', $obra->archivo_imagen) }}" alt="{{ $obra->titulo }}" class="w-full h-52 object-cover">
                        </div>
                        <div class="p-5 flex-1" style="border-top: 1px solid var(--line);">
                            <div class="flex items-center justify-between gap-2 mb-2">
                                <span class="tag">{{ $obra->categoria->nombre }}</span>
                                <span class="text-xs font-semibold text-pink-300">❤️ {{ $obra->likes->count() }} Likes</span>
                            </div>
                            <h3 class="font-display font-semibold text-white text-lg leading-snug">{{ $obra->titulo }}</h3>

                            <form action="{{ route('obras.destroy', $obra->id) }}" method="POST" class="mt-4" onsubmit="return confirm('¿Seguro que deseas eliminar esta obra?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-del">🗑️ Eliminar publicación</button>
                            </form>
                        </div>
                    </div>

                    <div class="md:w-2/3 p-6 flex flex-col justify-between" style="background: rgba(0,0,0,.18);">
                        <div>
                            <h4 class="eyebrow mb-4">Feedback recibido ({{ $obra->comentarios->count() }})</h4>
                            <div class="feedback space-y-3 max-h-56 overflow-y-auto">
                                @forelse ($obra->comentarios as $c)
                                    <div class="p-3 rounded-xl bg-white/[0.04] border border-white/5 text-xs text-slate-300">
                                        <div class="flex justify-between items-center mb-1 font-semibold text-white">
                                            <span>{{ $c->usuario ? $c->usuario->nombreVisible() : 'Usuario' }}</span>
                                            <span class="text-[0.65rem] text-slate-400">{{ $c->tipo }}</span>
                                        </div>
                                        <p>{{ $c->comentario }}</p>
                                    </div>
                                @empty
                                    <p class="text-xs italic text-slate-500">Sin comentarios aún.</p>
                                @endforelse
                            </div>
                        </div>

                        <div class="mt-5 pt-4 text-right border-t border-white/10">
                            <a href="{{ route('obras.show', $obra->id) }}" class="text-violet-300 text-xs font-semibold hover:text-white transition-colors">Ver vista pública →</a>
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