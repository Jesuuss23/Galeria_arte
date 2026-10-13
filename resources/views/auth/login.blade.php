<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión - Galería Creativa</title>
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
            backdrop-filter: blur(26px) saturate(140%);
            -webkit-backdrop-filter: blur(26px) saturate(140%);
            box-shadow: 0 40px 90px -40px rgba(139, 92, 246, .55);
        }

        /* ---------- Entrada ---------- */
        .rise { opacity: 0; transform: translateY(18px); animation: rise .8s cubic-bezier(.2,.8,.2,1) forwards; }
        .d1 { animation-delay: .05s; } .d2 { animation-delay: .2s; } .d3 { animation-delay: .35s; }
        @keyframes rise { to { opacity: 1; transform: none; } }

        /* ---------- Marca ---------- */
        .logo {
            font-family: 'Space Grotesk', sans-serif; font-weight: 700; letter-spacing: -.02em;
            background: linear-gradient(100deg, #fff 10%, #c4b5fd 50%, #f9a8d4 90%);
            -webkit-background-clip: text; background-clip: text; color: transparent;
            transition: filter .3s;
        }
        .logo:hover { filter: drop-shadow(0 0 14px rgba(167,139,250,.7)); }
        .logo-orb {
            width: 4rem; height: 4rem; border-radius: 1.2rem; display: grid; place-items: center; font-size: 1.8rem;
            background: linear-gradient(135deg, rgba(139,92,246,.4), rgba(236,72,153,.35));
            border: 1px solid rgba(167,139,250,.45);
            box-shadow: 0 0 50px -8px rgba(139,92,246,.85);
            animation: float 4s ease-in-out infinite;
        }
        @keyframes float { 50% { transform: translateY(-6px); } }

        .eyebrow { font-size: .68rem; text-transform: uppercase; letter-spacing: .22em; color: var(--muted); font-weight: 600; }
        .title-grad {
            background: linear-gradient(100deg, #fff 10%, #c4b5fd 45%, #f9a8d4 75%, #67e8f9 100%);
            background-size: 200% auto;
            -webkit-background-clip: text; background-clip: text; color: transparent;
            animation: shine 8s linear infinite;
        }
        @keyframes shine { to { background-position: 200% center; } }

        /* ---------- Formulario ---------- */
        .label { display: block; font-size: .68rem; text-transform: uppercase; letter-spacing: .14em; font-weight: 600; color: var(--muted); margin-bottom: .45rem; }
        .field {
            width: 100%; padding: .9rem 1rem; border-radius: .9rem; font-size: .92rem; color: var(--text);
            background: rgba(0, 0, 0, .3); border: 1px solid var(--line);
            transition: border-color .2s, box-shadow .2s, background .2s;
        }
        .field::placeholder { color: #5f5f78; }
        .field:focus {
            outline: none; border-color: rgba(167, 139, 250, .7);
            box-shadow: 0 0 0 4px rgba(139, 92, 246, .18); background: rgba(0, 0, 0, .42);
        }
        .field:-webkit-autofill {
            -webkit-text-fill-color: var(--text);
            -webkit-box-shadow: 0 0 0 1000px #14141f inset;
        }
        .has-error { border-color: rgba(244, 63, 94, .55); }
        .err { margin-top: .45rem; font-size: .78rem; color: #fda4af; }

        .eye {
            position: absolute; right: .5rem; top: 50%; transform: translateY(-50%);
            padding: .45rem; border-radius: .6rem; color: var(--muted); cursor: pointer; line-height: 0;
            transition: color .2s, background .2s;
        }
        .eye:hover { color: #fff; background: rgba(255,255,255,.07); }

        .check {
            appearance: none; -webkit-appearance: none; flex-shrink: 0;
            width: 1.2rem; height: 1.2rem; border-radius: .4rem; cursor: pointer; position: relative;
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

        .btn-primary {
            position: relative; overflow: hidden;
            padding: .85rem 1.6rem; border-radius: .95rem; font-weight: 600; font-size: .92rem; color: #fff;
            background: linear-gradient(120deg, var(--violet), var(--pink));
            box-shadow: 0 14px 34px -12px rgba(236, 72, 153, .75);
            transition: transform .2s, box-shadow .2s;
        }
        .btn-primary::before {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(120deg, transparent 30%, rgba(255,255,255,.35) 50%, transparent 70%);
            transform: translateX(-120%); transition: transform .8s;
        }
        .btn-primary:hover { transform: translateY(-3px); box-shadow: 0 22px 44px -14px rgba(236, 72, 153, .9); }
        .btn-primary:hover::before { transform: translateX(120%); }
        .btn-primary:active { transform: scale(.97); }

        .link {
            font-size: .82rem; color: var(--muted); border-radius: .4rem;
            transition: color .2s;
        }
        .link:hover { color: #c4b5fd; }
        .link:focus-visible { outline: none; box-shadow: 0 0 0 3px rgba(139,92,246,.35); }

        .alert-ok {
            display: flex; align-items: center; gap: .6rem;
            padding: .8rem 1rem; border-radius: 1rem; font-size: .86rem; color: #6ee7b7;
            background: rgba(52, 211, 153, .08); border: 1px solid rgba(52, 211, 153, .3);
            box-shadow: 0 0 30px -12px rgba(52, 211, 153, .6);
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation: none !important; transition: none !important; }
            .rise { opacity: 1; transform: none; }
        }
    </style>
</head>
<body class="min-h-screen relative flex items-center justify-center px-4 py-10">

    <!-- Fondo -->
    <div class="aurora" aria-hidden="true"><span></span><span></span><span></span></div>
    <div class="grain" aria-hidden="true"></div>

    <div class="relative z-10 w-full max-w-md">

        <!-- Marca -->
        <div class="flex flex-col items-center text-center mb-7 rise d1">
            <a href="{{ route('obras.index') }}" class="logo-orb mb-4" aria-label="Galería Creativa">🎨</a>
            <p class="eyebrow mb-2">Galería Creativa</p>
            <h1 class="font-display text-4xl font-bold tracking-tight title-grad">Bienvenido de vuelta</h1>
        </div>

        <div class="glass rounded-3xl p-6 sm:p-8 rise d2">

            <!-- Session Status -->
            @if (session('status'))
                <div class="alert-ok mb-5">
                    <span>✅</span>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Email Address -->
                <div>
                    <label for="email" class="label">{{ __('Email') }}</label>
                    <input id="email" class="field {{ $errors->get('email') ? 'has-error' : '' }}" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="tu@correo.com">
                    @foreach ((array) $errors->get('email') as $message)
                        <p class="err">{{ $message }}</p>
                    @endforeach
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="label">{{ __('Password') }}</label>
                    <div class="relative">
                        <input id="password" class="field {{ $errors->get('password') ? 'has-error' : '' }}" style="padding-right: 3rem;"
                                type="password"
                                name="password"
                                required autocomplete="current-password" placeholder="••••••••">
                        <button type="button" class="eye" id="toggle-pass" aria-label="Mostrar u ocultar contraseña">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.5 12S6 5.5 12 5.5 21.5 12 21.5 12 18 18.5 12 18.5 2.5 12 2.5 12z" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                        </button>
                    </div>
                    @foreach ((array) $errors->get('password') as $message)
                        <p class="err">{{ $message }}</p>
                    @endforeach
                </div>

                <!-- Remember Me -->
                <div>
                    <label for="remember_me" class="inline-flex items-center gap-3 cursor-pointer select-none">
                        <input id="remember_me" type="checkbox" class="check" name="remember">
                        <span class="text-sm" style="color: #cfcfe3;">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <div class="flex items-center justify-between gap-3 pt-2">
                    @if (Route::has('password.request'))
                        <a class="link" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @else
                        <span></span>
                    @endif

                    <button type="submit" class="btn-primary">
                        {{ __('Log in') }}
                    </button>
                </div>
            </form>
        </div>

        <!-- Enlaces inferiores -->
        <div class="mt-6 flex items-center justify-center gap-5 text-sm rise d3">
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="link">¿No tienes cuenta? <span class="font-semibold" style="color:#c4b5fd;">Regístrate</span></a>
            @endif
            <a href="{{ route('obras.index') }}" class="link">← Volver a la galería</a>
        </div>
    </div>

    <!-- Mostrar / ocultar contraseña (solo visual) -->
    <script>
        (function () {
            const btn = document.getElementById('toggle-pass');
            const input = document.getElementById('password');
            if (!btn || !input) return;
            btn.addEventListener('click', () => {
                input.type = input.type === 'password' ? 'text' : 'password';
            });
        })();
    </script>
</body>
</html>