<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Alfa y Omega — Acceso</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg:       #080A0F;
            --surface:  #0E1117;
            --surface2: #111827;
            --border:   rgba(255,255,255,0.07);
            --navy:     #1B2D4F;
            --navy-mid: #2A4A7F;
            --gold:     #C9A84C;
            --gold-lt:  #E8C97A;
            --gold-dk:  #A0742A;
            --text:     #F0F2F8;
            --muted:    #4B5263;
            --muted2:   #6B7280;
            --error:    #EF4444;
        }

        body {
            background-color: var(--bg);
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            overflow: hidden;
        }

        /* ── Panel izquierdo ── */
        .left-panel {
            width: 55%;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background: linear-gradient(135deg, #080A0F 0%, #0F1A2E 50%, #080A0F 100%);
        }

        /* Fondo radial brand */
        .left-panel::before {
            content: '';
            position: absolute; inset: 0;
            background:
                radial-gradient(ellipse 70% 55% at 25% 45%, rgba(27,45,79,0.55) 0%, transparent 60%),
                radial-gradient(ellipse 50% 70% at 75% 25%, rgba(42,74,127,0.20) 0%, transparent 55%),
                radial-gradient(ellipse 40% 40% at 50% 90%, rgba(201,168,76,0.07) 0%, transparent 50%);
        }

        /* Grid animado dorado */
        .grid-canvas {
            position: absolute; inset: 0;
            background-image:
                linear-gradient(rgba(201,168,76,0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(201,168,76,0.04) 1px, transparent 1px);
            background-size: 48px 48px;
            animation: gridDrift 25s linear infinite;
        }
        @keyframes gridDrift {
            0%   { background-position: 0 0; }
            100% { background-position: 48px 48px; }
        }

        /* Orbe dorado decorativo */
        .left-orb {
            position: absolute;
            width: 320px; height: 320px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(201,168,76,0.12) 0%, transparent 70%);
            top: 50%; left: 40%;
            transform: translate(-50%, -50%);
            pointer-events: none;
        }

        .left-content {
            position: relative; z-index: 2;
            padding: 3rem;
            max-width: 500px;
        }

        /* Logo principal */
        .ao-logo-full {
            display: flex;
            align-items: center;
            gap: 18px;
            margin-bottom: 3.5rem;
        }
        .ao-logo-svg-wrap {
            flex-shrink: 0;
        }
        .ao-logo-text-wrap {
            display: flex;
            flex-direction: column;
        }
        .ao-logo-name {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 1.25rem;
            color: var(--text);
            letter-spacing: 0.06em;
            text-transform: uppercase;
            line-height: 1.1;
        }
        .ao-logo-name span {
            color: var(--gold);
        }
        .ao-logo-pdv {
            font-family: 'DM Sans', sans-serif;
            font-weight: 400;
            font-size: 0.68rem;
            color: var(--gold);
            letter-spacing: 0.18em;
            text-transform: uppercase;
            margin-top: 2px;
        }
        .ao-logo-slogan {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.6rem;
            color: var(--muted2);
            letter-spacing: 0.12em;
            text-transform: uppercase;
            margin-top: 1px;
        }

        /* Titular hero */
        .left-headline {
            font-family: 'Syne', sans-serif;
            font-size: clamp(2rem, 3vw, 3rem);
            font-weight: 800;
            line-height: 1.1;
            color: var(--text);
            margin-bottom: 1.1rem;
        }
        .left-headline .gold-word {
            background: linear-gradient(90deg, var(--gold-lt), var(--gold-dk));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .left-sub {
            font-size: 0.92rem;
            color: var(--muted2);
            line-height: 1.65;
            max-width: 360px;
            margin-bottom: 2.5rem;
        }

        /* Features list */
        .features { display: flex; flex-direction: column; gap: 0.8rem; }
        .feat {
            display: flex; align-items: center; gap: 12px;
            font-size: 0.83rem; color: var(--muted2);
        }
        .feat-dot {
            width: 6px; height: 6px; border-radius: 50%;
            background: var(--gold); flex-shrink: 0;
            box-shadow: 0 0 8px rgba(201,168,76,0.6);
        }

        /* ── Panel derecho (formulario) ── */
        .right-panel {
            width: 45%;
            background: var(--surface);
            border-left: 1px solid rgba(201,168,76,0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem 2.5rem;
            position: relative;
        }

        /* Línea dorada superior decorativa */
        .right-panel::before {
            content: '';
            position: absolute; top: 0; left: 0; right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
            opacity: 0.45;
        }

        .form-box {
            width: 100%; max-width: 380px;
            animation: slideUp 0.55s cubic-bezier(0.16,1,0.3,1) both;
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(28px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Mini logo en el form */
        .form-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 2rem;
        }
        .form-brand-name {
            font-family: 'Syne', sans-serif;
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--muted2);
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .form-title {
            font-family: 'Syne', sans-serif;
            font-size: 1.55rem;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 0.35rem;
        }
        .form-subtitle {
            font-size: 0.83rem;
            color: var(--muted);
            margin-bottom: 2rem;
        }

        /* Alertas */
        .alert-err {
            background: rgba(239,68,68,0.08);
            border: 1px solid rgba(239,68,68,0.25);
            border-radius: 8px;
            padding: 0.75rem 1rem;
            margin-bottom: 1.25rem;
            font-size: 0.82rem;
            color: #FCA5A5;
        }
        .alert-err ul { margin: 0; padding-left: 1.1rem; }

        .alert-ok {
            background: rgba(16,185,129,0.08);
            border: 1px solid rgba(16,185,129,0.2);
            border-radius: 8px;
            padding: 0.75rem 1rem;
            margin-bottom: 1.25rem;
            font-size: 0.82rem;
            color: #6EE7B7;
        }

        /* Campos */
        .field-group { margin-bottom: 1.1rem; }
        .field-label {
            display: block;
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            color: var(--muted2);
            margin-bottom: 0.4rem;
            font-family: 'Syne', sans-serif;
        }
        .field-input-wrap { position: relative; }
        .field-input-wrap i {
            position: absolute;
            left: 14px; top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
            font-size: 0.8rem;
            pointer-events: none;
            transition: color 0.2s;
        }
        .field-input {
            width: 100%;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 10px;
            padding: 0.7rem 0.9rem 0.7rem 2.5rem;
            color: var(--text);
            font-size: 0.875rem;
            font-family: 'DM Sans', sans-serif;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
        }
        .field-input:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(201,168,76,0.12);
            background: rgba(201,168,76,0.04);
        }
        .field-input:focus + i,
        .field-input-wrap:focus-within i { color: var(--gold); }
        .field-input::placeholder { color: var(--muted); }

        /* Enlace forgot */
        .forgot-link {
            display: block;
            text-align: right;
            font-size: 0.76rem;
            color: var(--gold);
            margin-top: -0.6rem;
            margin-bottom: 1.5rem;
            text-decoration: none;
            opacity: 0.75;
            transition: opacity 0.2s;
        }
        .forgot-link:hover { opacity: 1; }

        /* Botón submit */
        .btn-submit {
            width: 100%;
            background: linear-gradient(135deg, var(--gold-lt), var(--gold-dk));
            color: #111;
            border: none;
            border-radius: 10px;
            padding: 0.85rem;
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 0.9rem;
            letter-spacing: 0.04em;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 4px 20px rgba(201,168,76,0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .btn-submit:hover {
            background: linear-gradient(135deg, var(--gold-dk), var(--gold));
            box-shadow: 0 6px 28px rgba(201,168,76,0.38);
            transform: translateY(-1px);
            color: #fff;
        }
        .btn-submit:active { transform: translateY(0); }

        /* Divider + registro */
        .form-divider {
            display: flex; align-items: center; gap: 10px;
            margin: 1.5rem 0 1.25rem;
        }
        .form-divider::before, .form-divider::after {
            content: ''; flex: 1;
            height: 1px; background: rgba(255,255,255,0.07);
        }
        .form-divider span {
            font-size: 0.72rem; color: var(--muted);
            letter-spacing: 0.06em; text-transform: uppercase;
        }

        .register-row {
            text-align: center;
            font-size: 0.82rem;
            color: var(--muted);
        }
        .register-row a {
            color: var(--gold);
            text-decoration: none;
            font-weight: 500;
        }
        .register-row a:hover { text-decoration: underline; }

        /* Footer form */
        .form-footer {
            text-align: center;
            margin-top: 2.5rem;
            font-size: 0.7rem;
            color: var(--muted);
            letter-spacing: 0.05em;
        }
        .form-footer strong { color: var(--gold); opacity: 0.7; }

        /* Responsive */
        @media (max-width: 768px) {
            .left-panel { display: none; }
            .right-panel { width: 100%; }
        }
    </style>
</head>
<body>

    <!-- ═══ PANEL IZQUIERDO — HERO ═══ -->
    <div class="left-panel">
        <div class="grid-canvas"></div>
        <div class="left-orb"></div>

        <div class="left-content">

            <!-- Logo completo -->
            <div class="ao-logo-full">
                <div class="ao-logo-svg-wrap">
                    <!-- Logo Alfa y Omega -->
                    <img src="{{ asset('assets/img/logo.png') }}" 
                         alt="Alfa y Omega" 
                         style="height:90px; width:auto; object-fit:contain;">
                </div>
                <div class="ao-logo-text-wrap">
                    <div class="ao-logo-name">ALFA <span>Y</span> OMEGA</div>
                    <div class="ao-logo-pdv">Punto de Venta</div>
                    <div class="ao-logo-slogan">Control Total, de Principio a Fin.</div>
                </div>
            </div>

            <h1 class="left-headline">
                Control total,<br>
                <span class="gold-word">de principio</span><br>
                a fin.
            </h1>

            <p class="left-sub">
                Gestiona ventas, inventario, compras y caja desde un solo lugar.
                Diseñado para negocios mexicanos con cumplimiento fiscal incluido.
            </p>

            <div class="features">
                <div class="feat"><div class="feat-dot"></div> Ventas y cotizaciones en segundos</div>
                <div class="feat"><div class="feat-dot"></div> Control de inventario con kardex</div>
                <div class="feat"><div class="feat-dot"></div> Pagos con Mercado Pago integrado</div>
                <div class="feat"><div class="feat-dot"></div> Escáner de productos QR/código de barras</div>
                <div class="feat"><div class="feat-dot"></div> Comprobantes fiscales CFDI México</div>
            </div>

        </div>
    </div>

    <!-- ═══ PANEL DERECHO — FORMULARIO ═══ -->
    <div class="right-panel">
        <div class="form-box">

            <!-- Mini logo -->
            <div class="form-brand">
                <img src="{{ asset('assets/img/logo.png') }}" 
                     alt="Alfa y Omega PV" 
                     style="height:24px; width:auto; object-fit:contain;">
                <span class="form-brand-name">Alfa y Omega PV</span>
            </div>

            <h2 class="form-title">Bienvenido</h2>
            <p class="form-subtitle">Ingresa tus credenciales para continuar</p>

            {{-- Errores de validación --}}
            @if ($errors->any())
                <div class="alert-err">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Mensaje de éxito (ej: contraseña restablecida) --}}
            @if (session('status'))
                <div class="alert-ok">{{ session('status') }}</div>
            @endif

            <form action="{{ route('login.login') }}" method="post" autocomplete="off">
                @csrf

                <div class="field-group">
                    <label class="field-label" for="email">Correo electrónico</label>
                    <div class="field-input-wrap">
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="field-input"
                            placeholder="usuario@empresa.com"
                            value="{{ old('email') }}"
                            required
                            autofocus
                        >
                        <i class="fas fa-envelope" style="left:14px; top:50%; position:absolute; transform:translateY(-50%); color:var(--muted); font-size:0.8rem;"></i>
                    </div>
                </div>

                <div class="field-group">
                    <label class="field-label" for="password">Contraseña</label>
                    <div class="field-input-wrap">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="field-input"
                            placeholder="••••••••"
                            required
                        >
                        <i class="fas fa-lock" style="left:14px; top:50%; position:absolute; transform:translateY(-50%); color:var(--muted); font-size:0.8rem;"></i>
                    </div>
                </div>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-link">¿Olvidaste tu contraseña?</a>
                @endif

                <button type="submit" class="btn-submit">
                    <i class="fas fa-right-to-bracket"></i>
                    Iniciar sesión
                </button>

            </form>

            @if (Route::has('register'))
                <div class="form-divider"><span>o</span></div>
                <div class="register-row">
                    ¿Sin cuenta aún?
                    <a href="{{ route('register.index') }}">Solicitar acceso</a>
                </div>
            @endif

            <div class="form-footer">
                <strong>Alfa y Omega Punto de Venta</strong><br>
                Control Total, de Principio a Fin.
            </div>

        </div>
    </div>

</body>
</html>