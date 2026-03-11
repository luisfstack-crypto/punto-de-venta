<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Alfa y Omega — Solicitar Acceso</title>
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
                radial-gradient(ellipse 60% 50% at 15% 50%, rgba(27,45,79,0.45) 0%, transparent 60%),
                radial-gradient(ellipse 40% 40% at 85% 20%, rgba(42,74,127,0.15) 0%, transparent 55%),
                radial-gradient(ellipse 30% 30% at 50% 95%, rgba(201,168,76,0.06) 0%, transparent 50%);
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

        /* ══ CONTENEDOR ══ */
        .reg-wrap {
            position: relative; z-index: 2;
            width: 100%;
            max-width: 980px;
            display: grid;
            grid-template-columns: 1fr 1.3fr;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 32px 80px rgba(0,0,0,0.6), 0 0 0 1px rgba(201,168,76,0.1);
            animation: fadeUp 0.5s cubic-bezier(0.16,1,0.3,1) both;
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ══ PANEL IZQUIERDO ══ */
        .left-panel {
            background: linear-gradient(155deg, #080C14 0%, #0D1828 60%, #060810 100%);
            padding: 2.2rem 2rem;
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
            border-right: 1px solid rgba(201,168,76,0.08);
        }
        .left-panel::before {
            content: '';
            position: absolute;
            width: 280px; height: 280px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(201,168,76,0.07) 0%, transparent 70%);
            bottom: -80px; right: -80px;
            pointer-events: none;
        }

        /* Logo banner */
        .lp-logo {
            margin: -2.2rem -2rem 1.4rem -2rem;
            background-color: #ffffff;
            padding: 1.2rem 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 16px rgba(0,0,0,0.25);
        }
        .lp-logo img {
            height: 100px;
            width: auto;
            object-fit: contain;
            display: block;
        }

        .lp-name { margin-bottom: 1.1rem; padding-bottom: 1rem; border-bottom: 1px solid rgba(201,168,76,0.1); }
        .lp-name-main {
            font-family: 'Syne', sans-serif; font-weight: 800; font-size: 1.25rem;
            color: var(--text); letter-spacing: 0.07em; text-transform: uppercase; line-height: 1;
        }
        .lp-name-main span { color: var(--gold); }
        .lp-name-sub {
            display: block; font-size: 0.6rem; color: var(--gold);
            letter-spacing: 0.2em; text-transform: uppercase; margin-top: 4px; opacity: 0.8;
        }

        .lp-headline {
            font-family: 'Syne', sans-serif; font-size: 1.5rem; font-weight: 800;
            line-height: 1.15; color: var(--text); margin-bottom: 0.6rem;
        }
        .lp-headline .gold-word {
            background: linear-gradient(90deg, var(--gold-lt), var(--gold-dk));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
        }

        .lp-desc { font-size: 0.8rem; color: var(--muted2); line-height: 1.6; margin-bottom: 1.3rem; }

        /* Steps */
        .steps { flex: 1; display: flex; flex-direction: column; gap: 0.85rem; margin-bottom: 1.1rem; }
        .step { display: flex; align-items: flex-start; gap: 12px; }
        .step-num {
            width: 24px; height: 24px; border-radius: 50%; flex-shrink: 0; margin-top: 1px;
            background: rgba(201,168,76,0.1); border: 1px solid rgba(201,168,76,0.25);
            display: flex; align-items: center; justify-content: center;
            font-family: 'Syne', sans-serif; font-size: 0.65rem; font-weight: 700; color: var(--gold);
        }
        .step-text { font-size: 0.78rem; color: rgba(255,255,255,0.45); line-height: 1.5; }
        .step-text strong { color: rgba(255,255,255,0.75); font-weight: 600; }

        /* Footer */
        .lp-footer { padding-top: 0.85rem; border-top: 1px solid rgba(255,255,255,0.05); }
        .lp-footer-label {
            font-size: 0.58rem; color: var(--muted); letter-spacing: 0.1em;
            text-transform: uppercase; font-family: 'Syne', sans-serif; margin-bottom: 0.45rem;
        }
        .wa-btn {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(37,211,102,0.07); border: 1px solid rgba(37,211,102,0.16);
            border-radius: 50px; padding: 0.4rem 0.85rem 0.4rem 0.4rem;
            text-decoration: none; transition: all 0.2s ease;
        }
        .wa-btn:hover { background: rgba(37,211,102,0.13); border-color: rgba(37,211,102,0.32); transform: translateY(-1px); }
        .wa-icon { width: 24px; height: 24px; background: #25D366; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .wa-icon i { font-size: 0.72rem; color: #fff; }
        .wa-texts { display: flex; flex-direction: column; line-height: 1.2; }
        .wa-cta { font-size: 0.6rem; color: var(--muted2); }
        .wa-num { font-size: 0.78rem; color: #25D366; font-weight: 500; }

        /* ══ PANEL DERECHO — FORMULARIO ══ */
        .right-panel {
            background: var(--card);
            padding: 2rem 2.2rem;
            display: flex; flex-direction: column; justify-content: center;
            position: relative; overflow-y: auto;
        }
        .right-panel::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 1px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent); opacity: 0.3;
        }

        .form-brand { display: flex; align-items: center; gap: 8px; margin-bottom: 1.2rem; }
        .form-brand-name {
            font-family: 'Syne', sans-serif; font-size: 0.68rem; font-weight: 700;
            color: var(--muted2); letter-spacing: 0.08em; text-transform: uppercase;
        }

        .form-title { font-family: 'Syne', sans-serif; font-size: 1.35rem; font-weight: 700; color: var(--text); margin-bottom: 0.2rem; }
        .form-subtitle { font-size: 0.8rem; color: var(--muted); margin-bottom: 1.3rem; }

        .alert-err {
            background: rgba(239,68,68,0.08); border: 1px solid rgba(239,68,68,0.22);
            border-radius: 8px; padding: 0.65rem 0.9rem;
            margin-bottom: 1rem; font-size: 0.78rem; color: #FCA5A5;
        }
        .alert-err ul { margin: 0; padding-left: 1.1rem; }

        /* Grid 2 col */
        .fields-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0 1rem; }
        .field { margin-bottom: 0.85rem; }
        .field.full { grid-column: 1 / -1; }

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

        /* Eye toggle */
        .eye-btn {
            position: absolute; right: 11px; top: 50%; transform: translateY(-50%);
            background: none; border: none; color: var(--muted);
            cursor: pointer; font-size: 0.78rem; padding: 4px; transition: color 0.2s;
        }
        .eye-btn:hover { color: var(--gold); }

        /* File upload */
        .file-upload-area {
            position: relative; border: 1px dashed rgba(201,168,76,0.25);
            border-radius: 9px; padding: 1rem; text-align: center;
            cursor: pointer; background: rgba(201,168,76,0.03);
            transition: border-color 0.2s, background 0.2s;
        }
        .file-upload-area:hover { border-color: rgba(201,168,76,0.5); background: rgba(201,168,76,0.06); }
        .file-upload-area input[type="file"] { position: absolute; inset: 0; opacity: 0; cursor: pointer; }
        .upload-icon { font-size: 1.3rem; color: var(--gold); margin-bottom: 0.35rem; opacity: 0.7; }
        .file-upload-area p { font-size: 0.76rem; color: var(--muted2); line-height: 1.4; }
        .file-upload-area span { color: var(--gold); font-weight: 500; }
        #file-name { margin-top: 0.35rem; font-size: 0.72rem; color: var(--gold-lt); }

        /* Submit */
        .btn-submit {
            width: 100%; margin-top: 0.2rem;
            background: linear-gradient(135deg, var(--gold-lt), var(--gold-dk));
            color: #111; border: none; border-radius: 9px; padding: 0.78rem;
            font-family: 'Syne', sans-serif; font-weight: 700; font-size: 0.88rem;
            letter-spacing: 0.04em; cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 4px 18px rgba(201,168,76,0.22);
            display: flex; align-items: center; justify-content: center; gap: 7px;
        }
        .btn-submit:hover {
            background: linear-gradient(135deg, var(--gold-dk), var(--gold));
            box-shadow: 0 6px 24px rgba(201,168,76,0.35);
            transform: translateY(-1px); color: #fff;
        }

        .form-divider {
            display: flex; align-items: center; gap: 8px; margin: 1rem 0 0.9rem;
        }
        .form-divider::before, .form-divider::after { content: ''; flex: 1; height: 1px; background: rgba(255,255,255,0.07); }
        .form-divider span { font-size: 0.68rem; color: var(--muted); letter-spacing: 0.05em; text-transform: uppercase; }

        .back-row { text-align: center; font-size: 0.78rem; color: var(--muted); }
        .back-row a { color: var(--gold); text-decoration: none; font-weight: 500; }
        .back-row a:hover { text-decoration: underline; }

        .form-footer { text-align: center; margin-top: 1.2rem; font-size: 0.64rem; color: var(--muted); letter-spacing: 0.04em; }
        .form-footer strong { color: var(--gold); opacity: 0.55; }

        /* ══ RESPONSIVE ══ */
        @media (max-width: 750px) {
            body { padding: 0; align-items: stretch; }
            .reg-wrap { grid-template-columns: 1fr; border-radius: 0; box-shadow: none; min-height: 100vh; }
            .left-panel { padding: 1.5rem 1.5rem 1.2rem; border-right: none; border-bottom: 1px solid rgba(201,168,76,0.1); }
            .steps, .lp-footer { display: none; }
            .lp-headline { font-size: 1.2rem; margin-bottom: 0.3rem; }
            .lp-desc { margin-bottom: 0; font-size: 0.76rem; }
            .right-panel { padding: 1.8rem 1.5rem; }
            .fields-grid { grid-template-columns: 1fr; }
            .field.full { grid-column: auto; }
        }
        @media (max-width: 400px) {
            .left-panel { padding: 1.2rem; }
            .right-panel { padding: 1.4rem 1.2rem; }
        }
    </style>
</head>
<body>

<div class="reg-wrap">

    {{-- ═══ PANEL IZQUIERDO ═══ --}}
    <div class="left-panel">

        <div class="lp-logo">
            <img src="{{ asset('assets/img/logo.png') }}" alt="Alfa y Omega Punto de Venta">
        </div>

        <div class="lp-name">
            <div class="lp-name-main">ALFA <span>Y</span> OMEGA</div>
            <span class="lp-name-sub">Punto de Venta</span>
        </div>

        <h2 class="lp-headline">
            Solicita tu<br>
            <span class="gold-word">acceso</span><br>
            al sistema.
        </h2>

        <p class="lp-desc">
            Tu cuenta será revisada y activada por un administrador antes de que puedas ingresar.
        </p>

        <div class="steps">
            <div class="step">
                <div class="step-num">1</div>
                <div class="step-text"><strong>Completa el formulario</strong> con tus datos y adjunta tu comprobante.</div>
            </div>
            <div class="step">
                <div class="step-num">2</div>
                <div class="step-text"><strong>El administrador revisa</strong> tu solicitud y te asigna un rol.</div>
            </div>
            <div class="step">
                <div class="step-num">3</div>
                <div class="step-text"><strong>Recibes un correo</strong> confirmando que tu cuenta está activa.</div>
            </div>
        </div>

        <div class="lp-footer">
            <div class="lp-footer-label">¿Dudas? Contáctanos</div>
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
            <span class="form-brand-name">Alfa y Omega PV — Registro</span>
        </div>

        <h2 class="form-title">Crear cuenta</h2>
        <p class="form-subtitle">Completa los campos para enviar tu solicitud</p>

        @if ($errors->any())
            <div class="alert-err">
                <ul>@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif

        <form action="{{ route('register.register') }}" method="post" enctype="multipart/form-data" autocomplete="off">
            @csrf
            <div class="fields-grid">

                <div class="field full">
                    <label class="field-label">Nombre completo</label>
                    <div class="field-wrap">
                        <i class="fas fa-user fi-icon"></i>
                        <input type="text" name="name" class="field-input"
                               value="{{ old('name') }}" placeholder="Tu nombre completo" autofocus required>
                    </div>
                </div>

                <div class="field full">
                    <label class="field-label">Correo electrónico</label>
                    <div class="field-wrap">
                        <i class="fas fa-envelope fi-icon"></i>
                        <input type="email" name="email" class="field-input"
                               value="{{ old('email') }}" placeholder="tu@correo.com" required>
                    </div>
                </div>

                <div class="field">
                    <label class="field-label">Contraseña</label>
                    <div class="field-wrap">
                        <i class="fas fa-lock fi-icon"></i>
                        <input type="password" name="password" id="pwd1" class="field-input"
                               placeholder="••••••••" required>
                        <button type="button" class="eye-btn" onclick="togglePwd('pwd1',this)">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="field">
                    <label class="field-label">Confirmar contraseña</label>
                    <div class="field-wrap">
                        <i class="fas fa-lock fi-icon"></i>
                        <input type="password" name="password_confirmation" id="pwd2" class="field-input"
                               placeholder="••••••••" required>
                        <button type="button" class="eye-btn" onclick="togglePwd('pwd2',this)">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="field full">
                    <label class="field-label">Comprobante de pago o identidad</label>
                    <div class="file-upload-area">
                        <input type="file" name="payment_receipt" id="receipt"
                               accept=".pdf,.jpg,.jpeg,.png" onchange="updateFileName(this)">
                        <div class="upload-icon"><i class="fas fa-cloud-arrow-up"></i></div>
                        <p><span>Selecciona un archivo</span> o arrastra aquí<br>PDF, JPG, PNG</p>
                        <p id="file-name"></p>
                    </div>
                </div>

            </div>

            <button type="submit" class="btn-submit">
                <i class="fas fa-paper-plane"></i>
                Enviar solicitud
            </button>
        </form>

        <div class="form-divider"><span>¿ya tienes cuenta?</span></div>
        <div class="back-row">
            <a href="{{ route('login.index') }}">← Volver al inicio de sesión</a>
        </div>

        <div class="form-footer">
            <strong>Alfa y Omega · Punto de Venta</strong><br>
            Control Total, de Principio a Fin.
        </div>

    </div>{{-- /right-panel --}}

</div>{{-- /reg-wrap --}}

<script>
    function togglePwd(id, btn) {
        const input = document.getElementById(id);
        const icon = btn.querySelector('i');
        input.type = input.type === 'password' ? 'text' : 'password';
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
    }
    function updateFileName(input) {
        const el = document.getElementById('file-name');
        el.textContent = input.files[0] ? '✓ ' + input.files[0].name : '';
    }
</script>
</body>
</html>