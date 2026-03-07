<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Punto de Venta — Acceso</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg:        #080A0F;
            --surface:   #0E1117;
            --border:    rgba(255,255,255,0.07);
            --accent:    #3B82F6;
            --accent2:   #6366F1;
            --text:      #F0F2F8;
            --muted:     #4B5263;
            --error:     #EF4444;
        }

        body {
            background-color: var(--bg);
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            overflow: hidden;
        }

        /* ── Left panel ── */
        .left-panel {
            width: 55%;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .left-panel::before {
            content: '';
            position: absolute; inset: 0;
            background:
                radial-gradient(ellipse 80% 60% at 20% 50%, rgba(59,130,246,0.18) 0%, transparent 60%),
                radial-gradient(ellipse 60% 80% at 80% 20%, rgba(99,102,241,0.12) 0%, transparent 55%),
                radial-gradient(ellipse 40% 40% at 50% 85%, rgba(59,130,246,0.08) 0%, transparent 50%);
        }

        /* Animated grid */
        .grid-canvas {
            position: absolute; inset: 0;
            background-image:
                linear-gradient(rgba(59,130,246,0.06) 1px, transparent 1px),
                linear-gradient(90deg, rgba(59,130,246,0.06) 1px, transparent 1px);
            background-size: 48px 48px;
            animation: gridDrift 20s linear infinite;
        }
        @keyframes gridDrift {
            0%   { background-position: 0 0; }
            100% { background-position: 48px 48px; }
        }

        .left-content {
            position: relative; z-index: 2;
            padding: 3rem;
            max-width: 480px;
        }

        .brand-mark {
            display: flex; align-items: center; gap: 14px;
            margin-bottom: 3.5rem;
        }
        .brand-icon {
            width: 44px; height: 44px;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; color: #fff;
            box-shadow: 0 8px 24px rgba(59,130,246,0.4);
        }
        .brand-name {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 1rem;
            color: var(--text);
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .left-headline {
            font-family: 'Syne', sans-serif;
            font-size: clamp(2.2rem, 3.5vw, 3.2rem);
            font-weight: 800;
            line-height: 1.1;
            color: var(--text);
            margin-bottom: 1.25rem;
        }
        .left-headline span {
            background: linear-gradient(90deg, var(--accent), var(--accent2));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .left-sub {
            font-size: 0.95rem;
            color: var(--muted);
            line-height: 1.65;
            max-width: 360px;
        }

        .features {
            margin-top: 2.5rem;
            display: flex; flex-direction: column; gap: 0.9rem;
        }
        .feat {
            display: flex; align-items: center; gap: 12px;
            font-size: 0.85rem; color: #6B7280;
        }
        .feat-dot {
            width: 6px; height: 6px; border-radius: 50%;
            background: var(--accent); flex-shrink: 0;
            box-shadow: 0 0 8px var(--accent);
        }

        /* ── Right panel (form) ── */
        .right-panel {
            width: 45%;
            background: var(--surface);
            border-left: 1px solid var(--border);
            display: flex; align-items: center; justify-content: center;
            padding: 3rem 2.5rem;
            position: relative;
        }

        .right-panel::before {
            content: '';
            position: absolute; top: 0; left: 0; right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--accent), transparent);
            opacity: 0.5;
        }

        .form-box {
            width: 100%; max-width: 380px;
            animation: slideUp 0.5s cubic-bezier(0.16,1,0.3,1) both;
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .form-title {
            font-family: 'Syne', sans-serif;
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 0.4rem;
        }
        .form-subtitle {
            font-size: 0.85rem;
            color: var(--muted);
            margin-bottom: 2rem;
        }

        /* Alerts */
        .alert-err {
            background: rgba(239,68,68,0.08);
            border: 1px solid rgba(239,68,68,0.25);
            border-radius: 8px;
            padding: 0.75rem 1rem;
            margin-bottom: 1.25rem;
            font-size: 0.82rem;
            color: #FCA5A5;
        }
        .alert-err ul { list-style: none; }
        .alert-err li::before { content: '→ '; }

        /* Field */
        .field { margin-bottom: 1.1rem; }
        .field label {
            display: block;
            font-size: 0.78rem;
            font-weight: 500;
            color: #6B7280;
            margin-bottom: 0.45rem;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }
        .field-wrap { position: relative; }
        .field-wrap .icon {
            position: absolute; left: 14px; top: 50%;
            transform: translateY(-50%);
            color: var(--muted); font-size: 0.8rem;
            pointer-events: none;
        }
        .field input {
            width: 100%;
            background: rgba(255,255,255,0.04);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 0.75rem 0.9rem 0.75rem 2.5rem;
            font-size: 0.9rem;
            font-family: 'DM Sans', sans-serif;
            color: var(--text);
            outline: none;
            transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
        }
        .field input::placeholder { color: #2D3340; }
        .field input:focus {
            border-color: var(--accent);
            background: rgba(59,130,246,0.05);
            box-shadow: 0 0 0 3px rgba(59,130,246,0.12);
        }
        .eye-btn {
            position: absolute; right: 12px; top: 50%;
            transform: translateY(-50%);
            background: none; border: none;
            color: var(--muted); cursor: pointer;
            font-size: 0.8rem; padding: 4px;
            transition: color 0.2s;
        }
        .eye-btn:hover { color: var(--accent); }

        /* Submit */
        .btn-submit {
            width: 100%; margin-top: 0.5rem;
            padding: 0.85rem;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            border: none; border-radius: 8px;
            font-family: 'Syne', sans-serif;
            font-size: 0.9rem; font-weight: 600;
            color: #fff; cursor: pointer;
            letter-spacing: 0.03em;
            position: relative; overflow: hidden;
            transition: opacity 0.2s, transform 0.15s, box-shadow 0.2s;
            box-shadow: 0 4px 20px rgba(59,130,246,0.3);
        }
        .btn-submit:hover {
            opacity: 0.92; transform: translateY(-1px);
            box-shadow: 0 8px 28px rgba(59,130,246,0.4);
        }
        .btn-submit:active { transform: translateY(0); }

        .form-footer {
            text-align: center;
            margin-top: 1.25rem;
            font-size: 0.82rem;
            color: var(--muted);
        }
        .form-footer a {
            color: var(--accent);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }
        .form-footer a:hover { color: #60A5FA; }

        .divider {
            display: flex; align-items: center; gap: 12px;
            margin: 1.5rem 0;
        }
        .divider::before, .divider::after {
            content: ''; flex: 1;
            height: 1px; background: var(--border);
        }
        .divider span { font-size: 0.75rem; color: var(--muted); }

        /* Responsive */
        @media (max-width: 768px) {
            body { flex-direction: column; overflow: auto; }
            .left-panel { width: 100%; min-height: 200px; padding: 2rem; }
            .left-headline { font-size: 1.8rem; }
            .features { display: none; }
            .right-panel { width: 100%; border-left: none; border-top: 1px solid var(--border); }
        }
    </style>
</head>
<body>

    <!-- Left panel -->
    <div class="left-panel">
        <div class="grid-canvas"></div>
        <div class="left-content">
            <div class="brand-mark">
                <div class="brand-icon"><i class="fas fa-cash-register"></i></div>
                <span class="brand-name">Punto de Venta</span>
            </div>
            <h1 class="left-headline">Gestión<br>de ventas<br><span>sin fricciones.</span></h1>
            <p class="left-sub">Control total de tu negocio — inventario, ventas, compras y reportes desde un solo lugar.</p>
            <div class="features">
                <div class="feat"><div class="feat-dot"></div>Ventas y cotizaciones en tiempo real</div>
                <div class="feat"><div class="feat-dot"></div>Control de inventario y kardex</div>
                <div class="feat"><div class="feat-dot"></div>Gestión de empleados y roles</div>
                <div class="feat"><div class="feat-dot"></div>Reportes y actividad del sistema</div>
            </div>
        </div>
    </div>

    <!-- Right panel -->
    <div class="right-panel">
        <div class="form-box">
            <h2 class="form-title">Bienvenido</h2>
            <p class="form-subtitle">Ingresa tus credenciales para continuar</p>

            @if ($errors->any())
            <div class="alert-err">
                <ul>
                    @foreach ($errors->all() as $item)
                    <li>{{ $item }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('login.login') }}" method="post">
                @csrf
                <div class="field">
                    <label>Correo electrónico</label>
                    <div class="field-wrap">
                        <span class="icon"><i class="fas fa-envelope"></i></span>
                        <input type="email" name="email" placeholder="tu@correo.com" autofocus autocomplete="off" required />
                    </div>
                </div>
                <div class="field">
                    <label>Contraseña</label>
                    <div class="field-wrap">
                        <span class="icon"><i class="fas fa-lock"></i></span>
                        <input type="password" name="password" id="pwd" placeholder="••••••••" required />
                        <button type="button" class="eye-btn" onclick="togglePwd('pwd', this)">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fas fa-arrow-right-to-bracket" style="margin-right:8px;"></i>Iniciar sesión
                </button>
            </form>

            <div class="divider"><span>¿nuevo aquí?</span></div>

            <div class="form-footer">
                <a href="{{ route('register.index') }}">Crear cuenta &rarr;</a>
            </div>
        </div>
    </div>

    <script>
        function togglePwd(id, btn) {
            const input = document.getElementById(id);
            const icon = btn.querySelector('i');
            input.type = input.type === 'password' ? 'text' : 'password';
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        }
    </script>
</body>
</html>