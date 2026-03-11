<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Alfa y Omega — Cuenta en Revisión</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg:      #080A0F;
            --card:    #111827;
            --border:  rgba(255,255,255,0.07);
            --gold:    #C9A84C;
            --gold-lt: #E8C97A;
            --gold-dk: #A0742A;
            --text:    #F0F2F8;
            --muted:   #4B5263;
            --muted2:  #6B7280;
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

        body::before {
            content: '';
            position: fixed; inset: 0;
            background:
                radial-gradient(ellipse 60% 50% at 20% 50%, rgba(27,45,79,0.45) 0%, transparent 60%),
                radial-gradient(ellipse 40% 40% at 80% 20%, rgba(42,74,127,0.15) 0%, transparent 55%),
                radial-gradient(ellipse 35% 35% at 50% 90%, rgba(201,168,76,0.07) 0%, transparent 55%);
            pointer-events: none;
        }
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

        /* ══ CARD CENTRADA ══ */
        .waiting-card {
            position: relative; z-index: 2;
            width: 100%; max-width: 480px;
            background: var(--card);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 32px 80px rgba(0,0,0,0.6), 0 0 0 1px rgba(201,168,76,0.1);
            animation: fadeUp 0.5s cubic-bezier(0.16,1,0.3,1) both;
            text-align: center;
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Línea dorada top */
        .waiting-card::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 1px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent); opacity: 0.4;
        }

        /* Logo banner */
        .card-logo {
            background: #ffffff;
            padding: 1.1rem 2rem;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 16px rgba(0,0,0,0.2);
        }
        .card-logo img {
            height: 80px; width: auto; object-fit: contain; display: block;
        }

        .card-body { padding: 2rem 2.2rem 2.2rem; }

        /* Ícono de reloj */
        .icon-ring {
            width: 72px; height: 72px;
            border-radius: 50%;
            background: rgba(201,168,76,0.08);
            border: 2px solid rgba(201,168,76,0.22);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1.4rem;
            font-size: 1.9rem; color: var(--gold);
            animation: pulse 3s ease-in-out infinite;
        }
        @keyframes pulse {
            0%, 100% { box-shadow: 0 0 0 0 rgba(201,168,76,0.15); }
            50%       { box-shadow: 0 0 0 10px rgba(201,168,76,0); }
        }

        .card-title {
            font-family: 'Syne', sans-serif;
            font-size: 1.35rem; font-weight: 700;
            color: var(--text); margin-bottom: 0.25rem;
        }
        .card-brand-line {
            font-family: 'Syne', sans-serif;
            font-size: 0.65rem; font-weight: 600;
            color: var(--gold); letter-spacing: 0.12em;
            text-transform: uppercase; opacity: 0.7;
            margin-bottom: 1.3rem;
        }

        .alert-success {
            background: rgba(16,185,129,0.08);
            border: 1px solid rgba(16,185,129,0.2);
            border-radius: 9px; padding: 0.65rem 0.9rem;
            margin-bottom: 1.2rem; font-size: 0.8rem; color: #6EE7B7;
            text-align: left;
        }

        .card-text {
            font-size: 0.85rem; color: var(--muted2);
            line-height: 1.7; margin-bottom: 0.9rem; text-align: left;
        }
        .card-text strong { color: rgba(255,255,255,0.8); font-weight: 600; }
        .card-text .ao-name { color: var(--gold); font-weight: 600; }

        .card-divider { height: 1px; background: rgba(255,255,255,0.06); margin: 1.4rem 0; }

        /* Botones */
        .btn-gold {
            display: inline-flex; align-items: center; gap: 7px;
            background: linear-gradient(135deg, var(--gold-lt), var(--gold-dk));
            color: #111; border: none; border-radius: 9px;
            padding: 0.65rem 1.5rem;
            font-family: 'Syne', sans-serif; font-weight: 700;
            font-size: 0.85rem; letter-spacing: 0.03em;
            text-decoration: none; cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 4px 14px rgba(201,168,76,0.2);
        }
        .btn-gold:hover {
            background: linear-gradient(135deg, var(--gold-dk), var(--gold));
            box-shadow: 0 6px 20px rgba(201,168,76,0.32);
            transform: translateY(-1px); color: #fff;
        }
        .btn-outline {
            display: inline-flex; align-items: center; gap: 7px;
            background: transparent;
            border: 1px solid rgba(255,255,255,0.1);
            color: var(--muted2); border-radius: 9px;
            padding: 0.65rem 1.5rem;
            font-family: 'Syne', sans-serif; font-weight: 600;
            font-size: 0.85rem; text-decoration: none; cursor: pointer;
            transition: all 0.2s ease;
        }
        .btn-outline:hover { border-color: rgba(201,168,76,0.3); color: var(--gold); }

        .card-footer-text {
            margin-top: 1.4rem; font-size: 0.64rem; color: var(--muted);
            letter-spacing: 0.04em;
        }
        .card-footer-text strong { color: var(--gold); opacity: 0.55; }
    </style>
</head>
<body>

<div class="waiting-card">

    {{-- Logo banner --}}
    <div class="card-logo">
        <img src="{{ asset('assets/img/logo.png') }}" alt="Alfa y Omega Punto de Venta">
    </div>

    <div class="card-body">

        {{-- Ícono --}}
        <div class="icon-ring">
            <i class="fas fa-clock"></i>
        </div>

        <h2 class="card-title">Cuenta en Revisión</h2>
        <div class="card-brand-line">Alfa y Omega · Punto de Venta</div>

        @if(session('success'))
            <div class="alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if(auth()->check())
            <p class="card-text">
                Hola <strong>{{ auth()->user()->name }}</strong>, tu solicitud ha sido recibida
                y se encuentra en estado <strong>pendiente de aprobación</strong>.
            </p>
        @else
            <p class="card-text">
                Tu solicitud de registro ha sido recibida y está en estado <strong>pendiente de aprobación</strong>.
            </p>
        @endif

        <p class="card-text">
            Un administrador revisará tu información en breve. Recibirás un correo de
            <span class="ao-name">Alfa y Omega PV</span> en cuanto tu cuenta esté activa.
        </p>

        <div class="card-divider"></div>

        @if(auth()->check())
            <a href="{{ route('logout') }}" class="btn-outline">
                <i class="fas fa-right-from-bracket"></i> Cerrar sesión
            </a>
        @else
            <a href="{{ route('login.index') }}" class="btn-gold">
                <i class="fas fa-right-to-bracket"></i> Ir al Login
            </a>
        @endif

        <div class="card-footer-text">
            <strong>Alfa y Omega · Punto de Venta</strong><br>
            Control Total, de Principio a Fin.
        </div>

    </div>{{-- /card-body --}}

</div>{{-- /waiting-card --}}

</body>
</html>