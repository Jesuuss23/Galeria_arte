<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Arte</title>
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

        /* ---------- Textos ---------- */
        .eyebrow { font-size: .68rem; text-transform: uppercase; letter-spacing: .22em; color: var(--muted); font-weight: 600; }
        .title-grad {
            background: linear-gradient(100deg, #fff 10%, #c4b5fd 45%, #f9a8d4 75%, #67e8f9 100%);
            background-size: 200% auto;
            -webkit-background-clip: text; background-clip: text; color: transparent;
            animation: shine 8s linear infinite;
        }
        @keyframes shine { to { background-position: 200% center; } }

        .link-back { color: var(--muted); transition: color .2s, transform .2s; display: inline-flex; align-items: center; gap: .5rem; font-size: .85rem; font-weight: 500; }
        .link-back:hover { color: #fff; transform: translateX(-4px); }

        /* ---------- Formulario ---------- */
        .label { display: block; font-size: .68rem; text-transform: uppercase; letter-spacing: .14em; font-weight: 600; color: var(--muted); margin-bottom: .45rem; }
        .hint { font-size: .72rem; color: #66667f; margin-top: .45rem; }
        .field {
            width: 100%; padding: .85rem 1rem; border-radius: .9rem; font-size: .9rem; color: var(--text);
            background: rgba(0, 0, 0, .3); border: 1px solid var(--line);
            transition: border-color .2s, box-shadow .2s, background .2s;
        }
        .field::placeholder { color: #5f5f78; }
        .field:focus {
            outline: none; border-color: rgba(167, 139, 250, .7);
            box-shadow: 0 0 0 4px rgba(139, 92, 246, .18); background: rgba(0, 0, 0, .42);
        }
        select.field { cursor: pointer; color-scheme: dark; }
        select.field option { background: #12121c; color: #e9e9f4; }
        textarea.field { resize: vertical; min-height: 6rem; }

        /* ---------- Zona de imagen (el input real cubre toda el área) ---------- */
        .dropzone {
            position: relative; display: flex; flex-direction: column; align-items: center; justify-content: center;
            gap: .35rem; padding: 2.2rem 1rem; text-align: center; border-radius: 1.2rem;
            background: rgba(0, 0, 0, .25); border: 1.5px dashed rgba(255, 255, 255, .2);
            transition: border-color .25s, background .25s, box-shadow .25s, transform .25s;
        }
        .dropzone:hover, .dropzone.is-drag {
            border-color: rgba(167, 139, 250, .8); background: rgba(139, 92, 246, .1);
            box-shadow: 0 0 0 4px rgba(139, 92, 246, .12), 0 20px 50px -28px rgba(139, 92, 246, .8);
        }
        .dropzone.is-drag { transform: scale(1.015); }
        .dropzone input[type="file"] { position: absolute; inset: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer; }
        .dz-icon {
            width: 3.2rem; height: 3.2rem; border-radius: 1rem; display: grid; place-items: center; font-size: 1.4rem;
            background: linear-gradient(135deg, rgba(139,92,246,.35), rgba(236,72,153,.3));
            border: 1px solid rgba(167,139,250,.4);
            animation: float 3.5s ease-in-out infinite;
        }
        @keyframes float { 50% { transform: translateY(-5px); } }
        .dz-title { font-weight: 600; font-size: .92rem; color: #fff; }
        .dz-sub { font-size: .76rem; color: var(--muted); }
        .dz-file { font-size: .76rem; color: #a5f3fc; font-weight: 500; word-break: break-all; }

        /* ---------- Vista previa ---------- */
        .preview-frame {
            position: relative; border-radius: 1.2rem; overflow: hidden; max-height: 20rem;
            display: flex; align-items: center; justify-content: center;
            background: rgba(0, 0, 0, .4); border: 1px solid var(--line);
            box-shadow: 0 30px 70px -34px rgba(139, 92, 246, .8);
            animation: rise .6s cubic-bezier(.2,.8,.2,1) both;
        }

        /* ---------- Botón publicar ---------- */
        .btn-publish {
            position: relative; overflow: hidden; width: 100%;
            padding: .95rem 1.2rem; border-radius: 1rem; font-weight: 600; font-size: .95rem; color: #fff;
            background: linear-gradient(120deg, var(--violet), var(--pink));
            box-shadow: 0 14px 36px -12px rgba(236, 72, 153, .75);
            transition: transform .2s, box-shadow .2s;
        }
        .btn-publish::before {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(120deg, transparent 30%, rgba(255,255,255,.35) 50%, transparent 70%);
            transform: translateX(-120%); transition: transform .8s;
        }
        .btn-publish:hover { transform: translateY(-3px); box-shadow: 0 22px 46px -14px rgba(236, 72, 153, .9); }
        .btn-publish:hover::before { transform: translateX(120%); }
        .btn-publish:active { transform: scale(.98); }

        /* ---------- Errores ---------- */
        .alert-err {
            padding: .95rem 1.2rem; border-radius: 1rem; font-size: .86rem; color: #fda4af;
            background: rgba(244, 63, 94, .08); border: 1px solid rgba(244, 63, 94, .3);
            box-shadow: 0 0 30px -12px rgba(244, 63, 94, .6);
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation: none !important; transition: none !important; }
            .rise { opacity: 1; transform: none; }
        }
    </style>
</head>
<body class="min-h-screen py-10 px-4 relative">

    <!-- Fondo -->
    <div class="aurora" aria-hidden="true"><span></span><span></span><span></span></div>
    <div class="grain" aria-hidden="true"></div>

    <div class="relative z-10 max-w-2xl mx-auto">

        <div class="glass rounded-3xl p-6 sm:p-9 rise d1">
            <div class="flex justify-between items-start gap-4 mb-8">
                <div>
                    <p class="eyebrow mb-2">Nueva publicación</p>
                    <h2 class="font-display text-3xl sm:text-4xl font-bold tracking-tight leading-tight title-grad">Publicar nueva obra</h2>
                </div>
                <a href="{{ route('obras.index') }}" class="link-back shrink-0 mt-1">← Volver a la galería</a>
            </div>

            @if ($errors->any())
                <div class="alert-err mb-6">
                    <ul class="list-disc pl-5 space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('obras.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                <div>
                    <label class="label">Título de la obra</label>
                    <input type="text" name="titulo" value="{{ old('titulo') }}" required
                           class="field">
                </div>

                <div>
                    <label class="label">Categoría</label>
                    <select name="categoria_id" required class="field">
                        <option value="">Selecciona una categoría...</option>
                        @foreach ($categorias as $cat)
                            <option value="{{ $cat->id }}" {{ old('categoria_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="label">Descripción</label>
                    <textarea name="descripcion" rows="3" class="field">{{ old('descripcion') }}</textarea>
                </div>
                <div>
                    <label class="label">Software / Herramientas utilizadas (Opcional)</label>
                    <input type="text" name="herramientas" value="{{ old('herramientas') }}"
                        placeholder="Ej: Blender, Photoshop, ZBrush, Aseprite..."
                        class="field">
                    <p class="hint">Separa los programas o técnicas con comas.</p>
                </div>

                <!-- Campo de Imagen con Previsualización -->
                <div>
                    <label class="label">Imagen de la obra</label>

                    <div class="dropzone" id="dropzone">
                        <input type="file" name="imagen" id="imagen-input" accept="image/*" required>
                        <span class="dz-icon">🖼️</span>
                        <span class="dz-title">Arrastra tu imagen aquí o haz clic para elegirla</span>
                        <span class="dz-sub">JPG, PNG, WEBP · Máx. 5MB</span>
                        <span class="dz-file" id="dz-file"></span>
                    </div>
                    <p class="hint">Formatos: JPG, PNG, WEBP (Máx. 5MB). Se escaneará automáticamente contra contenido explícito.</p>

                    <!-- Contenedor de Vista Previa (oculto inicialmente) -->
                    <div id="preview-container" class="mt-5 hidden">
                        <p class="eyebrow mb-2">Vista previa</p>
                        <div class="preview-frame">
                            <img id="image-preview" src="#" alt="Vista previa" class="max-h-80 w-auto object-contain">
                        </div>
                    </div>
                </div>

                <script>
                    const inputImagen = document.getElementById('imagen-input');
                    const previewContainer = document.getElementById('preview-container');
                    const previewImg = document.getElementById('image-preview');

                    inputImagen.addEventListener('change', function () {
                        const file = this.files[0];
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = function (e) {
                                previewImg.src = e.target.result;
                                previewContainer.classList.remove('hidden');
                            };
                            reader.readAsDataURL(file);
                        } else {
                            previewContainer.classList.add('hidden');
                        }
                    });
                </script>

                <button type="submit" class="btn-publish mt-2">
                    ✨ Publicar Arte
                </button>
            </form>
        </div>
    </div>

    <!-- Detalles de la zona de imagen (solo visual) -->
    <script>
        (function () {
            const zone = document.getElementById('dropzone');
            const input = document.getElementById('imagen-input');
            const label = document.getElementById('dz-file');
            if (!zone || !input) return;
            ['dragenter', 'dragover'].forEach(ev => zone.addEventListener(ev, () => zone.classList.add('is-drag')));
            ['dragleave', 'drop'].forEach(ev => zone.addEventListener(ev, () => zone.classList.remove('is-drag')));
            input.addEventListener('change', () => {
                label.textContent = input.files[0] ? '✔ ' + input.files[0].name : '';
            });
        })();
    </script>
</body>
</html>