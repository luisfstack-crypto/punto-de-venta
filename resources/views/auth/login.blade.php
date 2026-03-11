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
            --bg:      #080A0F;
            --surface: #0E1117;
            --card:    #111827;
            --border:  rgba(255,255,255,0.07);
            --gold:    #C9A84C;
            --gold-lt: #E8C97A;
            --gold-dk: #A0742A;
            --navy:    #1B2D4F;
            --text:    #F0F2F8;
            --muted:   #4B5263;
            --muted2:  #6B7280;
            --error:   #EF4444;
            --wa:      #25D366;
        }

        body {
            background-color: var(--bg);
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
        }

        /* Fondo con radiales brand */
        body::before {
            content: '';
            position: fixed; inset: 0;
            background:
                radial-gradient(ellipse 60% 50% at 15% 50%, rgba(27,45,79,0.45) 0%, transparent 60%),
                radial-gradient(ellipse 40% 40% at 85% 20%, rgba(42,74,127,0.15) 0%, transparent 55%),
                radial-gradient(ellipse 30% 30% at 50% 95%, rgba(201,168,76,0.06) 0%, transparent 50%);
            pointer-events: none;
        }

        /* Grid animado */
        body::after {
            content: '';
            position: fixed; inset: 0;
            background-image:
                linear-gradient(rgba(201,168,76,0.025) 1px, transparent 1px),
                linear-gradient(90deg, rgba(201,168,76,0.025) 1px, transparent 1px);
            background-size: 52px 52px;
            animation: gridDrift 28s linear infinite;
            pointer-events: none;
        }
        @keyframes gridDrift {
            0%   { background-position: 0 0; }
            100% { background-position: 52px 52px; }
        }

        /* ══════════════════════════════════
           CONTENEDOR PRINCIPAL — dos columnas
           que se convierten en 1 en móvil
        ══════════════════════════════════ */
        .login-wrap {
            position: relative; z-index: 2;
            width: 100%;
            max-width: 920px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 32px 80px rgba(0,0,0,0.6), 0 0 0 1px rgba(201,168,76,0.1);
            animation: fadeUp 0.5s cubic-bezier(0.16,1,0.3,1) both;
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ══════════════════════════════════
           PANEL IZQUIERDO — INFO
        ══════════════════════════════════ */
        .left-panel {
            background: linear-gradient(155deg, #0D1525 0%, #111E35 60%, #0A0F1C 100%);
            padding: 2.2rem 2rem;
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
            border-right: 1px solid rgba(201,168,76,0.08);
        }

        /* Orbe decorativo */
        .left-panel::before {
            content: '';
            position: absolute;
            width: 280px; height: 280px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(201,168,76,0.07) 0%, transparent 70%);
            bottom: -80px; right: -80px;
            pointer-events: none;
        }

        /* 1. Logo */
        .lp-logo {
            margin: -2.2rem -2rem 1.1rem -2rem; /* sale hasta los bordes del padding del panel */
            background-color: #ffffff;
            padding: 1.2rem 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 16px rgba(0,0,0,0.25);
        }
        .lp-logo img {
            height: 130px;
            width: auto;
            object-fit: contain;
            display: block;
        }

        /* 2. Nombre */
        .lp-name {
            margin-bottom: 1.1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(201,168,76,0.1);
        }
        .lp-name-main {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 1.25rem;
            color: var(--text);
            letter-spacing: 0.07em;
            text-transform: uppercase;
            line-height: 1;
        }
        .lp-name-main span { color: var(--gold); }
        .lp-name-sub {
            display: block;
            font-size: 0.6rem;
            color: var(--gold);
            letter-spacing: 0.2em;
            text-transform: uppercase;
            margin-top: 4px;
            opacity: 0.8;
        }

        /* 3. Headline */
        .lp-headline {
            font-family: 'Syne', sans-serif;
            font-size: 1.65rem;
            font-weight: 800;
            line-height: 1.1;
            color: var(--text);
            margin-bottom: 0.65rem;
        }
        .lp-headline .gold-word {
            background: linear-gradient(90deg, var(--gold-lt), var(--gold-dk));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* 4. Descripción */
        .lp-desc {
            font-size: 0.8rem;
            color: var(--muted2);
            line-height: 1.6;
            margin-bottom: 1.1rem;
        }

        /* 5. Features */
        .features {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 0.38rem;
            margin-bottom: 1.1rem;
        }
        .feat {
            display: flex;
            align-items: center;
            gap: 9px;
        }
        .feat-icon {
            width: 22px; height: 22px;
            border-radius: 6px;
            background: rgba(201,168,76,0.07);
            border: 1px solid rgba(201,168,76,0.13);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .feat-icon i { font-size: 0.58rem; color: var(--gold); }
        .feat-text { font-size: 0.78rem; color: rgba(255,255,255,0.55); }
        .feat-text strong { color: rgba(255,255,255,0.85); font-weight: 600; }

        /* 6. WhatsApp */
        .lp-footer {
            padding-top: 0.85rem;
            border-top: 1px solid rgba(255,255,255,0.05);
        }
        .lp-footer-label {
            font-size: 0.58rem;
            color: var(--muted);
            letter-spacing: 0.1em;
            text-transform: uppercase;
            font-family: 'Syne', sans-serif;
            margin-bottom: 0.45rem;
        }
        .wa-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(37,211,102,0.07);
            border: 1px solid rgba(37,211,102,0.16);
            border-radius: 50px;
            padding: 0.4rem 0.85rem 0.4rem 0.4rem;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .wa-btn:hover {
            background: rgba(37,211,102,0.13);
            border-color: rgba(37,211,102,0.32);
            transform: translateY(-1px);
        }
        .wa-icon {
            width: 24px; height: 24px;
            background: var(--wa);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .wa-icon i { font-size: 0.72rem; color: #fff; }
        .wa-texts { display: flex; flex-direction: column; line-height: 1.2; }
        .wa-cta  { font-size: 0.6rem;  color: var(--muted2); }
        .wa-num  { font-size: 0.78rem; color: var(--wa); font-weight: 500; }

        /* ══════════════════════════════════
           PANEL DERECHO — FORMULARIO
        ══════════════════════════════════ */
        .right-panel {
            background: var(--card);
            padding: 2.2rem 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
        }

        /* Línea dorada top */
        .right-panel::before {
            content: '';
            position: absolute; top: 0; left: 0; right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
            opacity: 0.3;
        }

        /* Mini brand */
        .form-brand {
            display: flex; align-items: center; gap: 8px;
            margin-bottom: 1.5rem;
        }
        .form-brand img {
            height: 22px; width: auto;
            object-fit: contain; mix-blend-mode: screen;
        }
        .form-brand-name {
            font-family: 'Syne', sans-serif;
            font-size: 0.68rem; font-weight: 700;
            color: var(--muted2);
            letter-spacing: 0.08em; text-transform: uppercase;
        }

        .form-title {
            font-family: 'Syne', sans-serif;
            font-size: 1.4rem; font-weight: 700;
            color: var(--text); margin-bottom: 0.25rem;
        }
        .form-subtitle {
            font-size: 0.8rem; color: var(--muted);
            margin-bottom: 1.5rem;
        }

        /* Alertas */
        .alert-err {
            background: rgba(239,68,68,0.08);
            border: 1px solid rgba(239,68,68,0.22);
            border-radius: 8px; padding: 0.65rem 0.9rem;
            margin-bottom: 1rem; font-size: 0.78rem; color: #FCA5A5;
        }
        .alert-err ul { margin: 0; padding-left: 1.1rem; }
        .alert-ok {
            background: rgba(16,185,129,0.08);
            border: 1px solid rgba(16,185,129,0.2);
            border-radius: 8px; padding: 0.65rem 0.9rem;
            margin-bottom: 1rem; font-size: 0.78rem; color: #6EE7B7;
        }

        /* Campos */
        .field-group { margin-bottom: 0.9rem; }
        .field-label {
            display: block; font-size: 0.68rem; font-weight: 600;
            letter-spacing: 0.07em; text-transform: uppercase;
            color: var(--muted2); margin-bottom: 0.35rem;
            font-family: 'Syne', sans-serif;
        }
        .field-wrap { position: relative; }
        .fi-icon {
            position: absolute; left: 12px; top: 50%;
            transform: translateY(-50%);
            color: var(--muted); font-size: 0.75rem;
            pointer-events: none; transition: color 0.2s;
        }
        .field-input {
            width: 100%;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 9px;
            padding: 0.62rem 0.85rem 0.62rem 2.2rem;
            color: var(--text); font-size: 0.85rem;
            font-family: 'DM Sans', sans-serif;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
        }
        .field-input:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(201,168,76,0.1);
            background: rgba(201,168,76,0.025);
        }
        .field-wrap:focus-within .fi-icon { color: var(--gold); }
        .field-input::placeholder { color: var(--muted); }

        .forgot-link {
            display: block; text-align: right;
            font-size: 0.72rem; color: var(--gold);
            margin-top: -0.45rem; margin-bottom: 1.2rem;
            text-decoration: none; opacity: 0.7; transition: opacity 0.2s;
        }
        .forgot-link:hover { opacity: 1; }

        .btn-submit {
            width: 100%;
            background: linear-gradient(135deg, var(--gold-lt), var(--gold-dk));
            color: #111; border: none; border-radius: 9px;
            padding: 0.78rem;
            font-family: 'Syne', sans-serif; font-weight: 700;
            font-size: 0.88rem; letter-spacing: 0.04em;
            cursor: pointer; transition: all 0.2s ease;
            box-shadow: 0 4px 18px rgba(201,168,76,0.22);
            display: flex; align-items: center; justify-content: center; gap: 7px;
        }
        .btn-submit:hover {
            background: linear-gradient(135deg, var(--gold-dk), var(--gold));
            box-shadow: 0 6px 24px rgba(201,168,76,0.35);
            transform: translateY(-1px); color: #fff;
        }

        .form-divider {
            display: flex; align-items: center; gap: 8px;
            margin: 1.1rem 0 1rem;
        }
        .form-divider::before, .form-divider::after {
            content: ''; flex: 1; height: 1px;
            background: rgba(255,255,255,0.07);
        }
        .form-divider span { font-size: 0.68rem; color: var(--muted); letter-spacing: 0.05em; text-transform: uppercase; }

        .register-row { text-align: center; font-size: 0.78rem; color: var(--muted); }
        .register-row a { color: var(--gold); text-decoration: none; font-weight: 500; }
        .register-row a:hover { text-decoration: underline; }

        .form-footer {
            text-align: center; margin-top: 1.5rem;
            font-size: 0.64rem; color: var(--muted); letter-spacing: 0.04em;
        }
        .form-footer strong { color: var(--gold); opacity: 0.55; }

        /* ══════════════════════════════════
           RESPONSIVE — MÓVIL
        ══════════════════════════════════ */
        @media (max-width: 680px) {
            body { padding: 0; align-items: stretch; }

            .login-wrap {
                grid-template-columns: 1fr;
                border-radius: 0;
                box-shadow: none;
                min-height: 100vh;
            }

            /* En móvil el panel izquierdo va arriba, compacto */
            .left-panel {
                padding: 1.5rem 1.5rem 1.2rem;
                border-right: none;
                border-bottom: 1px solid rgba(201,168,76,0.1);
            }

            /* Ocultar features en móvil para ahorrar espacio */
            .features { display: none; }
            .lp-footer { display: none; }

            .lp-headline { font-size: 1.3rem; margin-bottom: 0.4rem; }
            .lp-desc { font-size: 0.76rem; margin-bottom: 0; }

            .right-panel { padding: 1.8rem 1.5rem; }
        }

        @media (max-width: 400px) {
            .left-panel { padding: 1.2rem; }
            .right-panel { padding: 1.4rem 1.2rem; }
        }
    </style>
</head>
<body>

    <div class="login-wrap">

        {{-- ═══ PANEL IZQUIERDO ═══ --}}
        <div class="left-panel">

            {{-- 1. Logo --}}
            <div class="lp-logo">
                <img src="{{ asset('assets/img/logo.png') }}" alt="Alfa y Omega Punto de Venta">
            </div>

            {{-- 2. Nombre --}}
            <div class="lp-name">
                <div class="lp-name-main">ALFA <span>Y</span> OMEGA</div>
                <span class="lp-name-sub">Punto de Venta</span>
            </div>

            {{-- 3. Headline --}}
            <h1 class="lp-headline">
                Control total,<br>
                <span class="gold-word">de principio</span><br>
                a fin.
            </h1>

            {{-- 4. Descripción --}}
            <p class="lp-desc">
                Gestiona ventas, inventario, facturación y caja desde una
                plataforma diseñada para negocios exigentes.
            </p>

            {{-- 5. Features --}}
            <div class="features">
                <div class="feat">
                    <div class="feat-icon"><i class="fas fa-cart-shopping"></i></div>
                    <span class="feat-text"><strong>Ventas y cotizaciones</strong> en segundos</span>
                </div>
                <div class="feat">
                    <div class="feat-icon"><i class="fas fa-boxes-stacked"></i></div>
                    <span class="feat-text"><strong>Inventario en tiempo real</strong> con kardex</span>
                </div>
                <div class="feat">
                    <div class="feat-icon"><i class="fas fa-qrcode"></i></div>
                    <span class="feat-text"><strong>Escáner QR</strong> y código de barras</span>
                </div>
                <div class="feat">
                    <div class="feat-icon"><i class="fas fa-credit-card"></i></div>
                    <span class="feat-text"><strong>Pagos con Mercado Pago</strong> — Point, QR y link</span>
                </div>
                <div class="feat">
                    <div class="feat-icon"><i class="fas fa-file-invoice"></i></div>
                    <span class="feat-text"><strong>Comprobantes CFDI</strong> para México</span>
                </div>
            </div>

            {{-- 6. WhatsApp --}}
            <div class="lp-footer">
                <div class="lp-footer-label">¿Dudas? Contáctanos</div>
                {{--
                    Cambia 529991234567 por tu número real (formato: 52 + 10 dígitos, sin espacios)
                --}}
                <a href="https://wa.me/529991234567?text=Hola,%20me%20interesa%20Alfa%20y%20Omega%20Punto%20de%20Venta"
                   target="_blank" rel="noopener noreferrer" class="wa-btn">
                    <div class="wa-icon"><i class="fab fa-whatsapp"></i></div>
                    <div class="wa-texts">
                        <span class="wa-cta">Escríbenos por WhatsApp</span>
                        <span class="wa-num">+52 999 123 4567</span>
                    </div>
                </a>
            </div>

        </div>{{-- /left-panel --}}

        {{-- ═══ PANEL DERECHO ═══ --}}
        <div class="right-panel">

            <div class="form-brand">
                
                <span class="form-brand-name">Alfa y Omega PV</span>
            </div>

            <h2 class="form-title">Bienvenido</h2>
            <p class="form-subtitle">Ingresa tus credenciales para continuar</p>

            @if ($errors->any())
                <div class="alert-err">
                    <ul>@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
            @endif
            @if (session('status'))
                <div class="alert-ok">{{ session('status') }}</div>
            @endif

            <form action="{{ route('login.login') }}" method="post" autocomplete="off">
                @csrf

                <div class="field-group">
                    <label class="field-label" for="email">Correo electrónico</label>
                    <div class="field-wrap">
                        <input type="email" id="email" name="email" class="field-input"
                               placeholder="usuario@empresa.com"
                               value="{{ old('email') }}" required autofocus>
                        <i class="fas fa-envelope fi-icon"></i>
                    </div>
                </div>

                <div class="field-group">
                    <label class="field-label" for="password">Contraseña</label>
                    <div class="field-wrap">
                        <input type="password" id="password" name="password" class="field-input"
                               placeholder="••••••••" required>
                        <i class="fas fa-lock fi-icon"></i>
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

                <div class="form-divider"><span>o</span></div>
                <div class="register-row">
                    ¿Sin cuenta aún? <a href="{{ route('register.index') }}">Solicitar acceso</a>
                </div>

            <div class="form-footer">
                <strong>Alfa y Omega · Punto de Venta</strong><br>
                Control Total, de Principio a Fin.
            </div>

        </div>{{-- /right-panel --}}

    </div>{{-- /login-wrap --}}

</body>
</html>