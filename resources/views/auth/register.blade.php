<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Punto de Venta — Registro</title>
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
            width: 42%;
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
                radial-gradient(ellipse 80% 60% at 30% 40%, rgba(99,102,241,0.18) 0%, transparent 60%),
                radial-gradient(ellipse 50% 70% at 70% 75%, rgba(59,130,246,0.12) 0%, transparent 55%);
        }
        .grid-canvas {
            position: absolute; inset: 0;
            background-image:
                linear-gradient(rgba(99,102,241,0.06) 1px, transparent 1px),
                linear-gradient(90deg, rgba(99,102,241,0.06) 1px, transparent 1px);
            background-size: 48px 48px;
            animation: gridDrift 20s linear infinite;
        }
        @keyframes gridDrift {
            0%   { background-position: 0 0; }
            100% { background-position: 48px 48px; }
        }

        .left-content {
            position: relative; z-index: 2;
            padding: 3rem 2.5rem;
            max-width: 420px;
        }
        .brand-mark {
            display: flex; align-items: center; gap: 14px;
            margin-bottom: 3rem;
        }
        .brand-icon {
            width: 44px; height: 44px;
            background: linear-gradient(135deg, var(--accent2), var(--accent));
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; color: #fff;
            box-shadow: 0 8px 24px rgba(99,102,241,0.4);
        }
        .brand-name {
            font-family: 'Syne', sans-serif;
            font-weight: 700; font-size: 1rem;
            color: var(--text); letter-spacing: 0.04em;
            text-transform: uppercase;
        }
        .left-headline {
            font-family: 'Syne', sans-serif;
            font-size: clamp(1.8rem, 3vw, 2.6rem);
            font-weight: 800; line-height: 1.15;
            color: var(--text); margin-bottom: 1.1rem;
        }
        .left-headline span {
            background: linear-gradient(90deg, var(--accent2), var(--accent));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }
        .left-sub {
            font-size: 0.9rem; color: var(--muted); line-height: 1.65;
        }

        .steps {
            margin-top: 2.5rem;
            display: flex; flex-direction: column; gap: 1.2rem;
        }
        .step {
            display: flex; align-items: flex-start; gap: 14px;
        }
        .step-num {
            width: 26px; height: 26px; border-radius: 50%;
            background: rgba(99,102,241,0.15);
            border: 1px solid rgba(99,102,241,0.3);
            display: flex; align-items: center; justify-content: center;
            font-family: 'Syne', sans-serif;
            font-size: 0.7rem; font-weight: 700;
            color: #818CF8; flex-shrink: 0; margin-top: 1px;
        }
        .step-text { font-size: 0.82rem; color: #6B7280; line-height: 1.5; }
        .step-text strong { color: #9CA3AF; font-weight: 500; }

        /* ── Right panel ── */
        .right-panel {
            width: 58%;
            background: var(--surface);
            border-left: 1px solid var(--border);
            display: flex; align-items: center; justify-content: center;
            padding: 2.5rem;
            overflow-y: auto;
            position: relative;
        }
        .right-panel::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--accent2), var(--accent), transparent);
            opacity: 0.5;
        }

        .form-box {
            width: 100%; max-width: 440px;
            animation: slideUp 0.5s cubic-bezier(0.16,1,0.3,1) both;
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .form-title {
            font-family: 'Syne', sans-serif;
            font-size: 1.5rem; font-weight: 700;
            color: var(--text); margin-bottom: 0.3rem;
        }
        .form-subtitle {
            font-size: 0.83rem; color: var(--muted); margin-bottom: 1.75rem;
        }

        .alert-err {
            background: rgba(239,68,68,0.08);
            border: 1px solid rgba(239,68,68,0.25);
            border-radius: 8px;
            padding: 0.75rem 1rem;
            margin-bottom: 1.25rem;
            font-size: 0.82rem; color: #FCA5A5;
        }
        .alert-err ul { list-style: none; }
        .alert-err li::before { content: '→ '; }

        /* 2-col grid for fields */
        .fields-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0 1rem;
        }
        .field { margin-bottom: 1rem; }
        .field.full { grid-column: 1 / -1; }

        .field label {
            display: block; font-size: 0.75rem; font-weight: 500;
            color: #6B7280; margin-bottom: 0.4rem;
            letter-spacing: 0.04em; text-transform: uppercase;
        }
        .field-wrap { position: relative; }
        .field-wrap .icon {
            position: absolute; left: 13px; top: 50%;
            transform: translateY(-50%);
            color: var(--muted); font-size: 0.75rem; pointer-events: none;
        }
        .field input, .field .file-input {
            width: 100%;
            background: rgba(255,255,255,0.04);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 0.72rem 0.9rem 0.72rem 2.4rem;
            font-size: 0.88rem;
            font-family: 'DM Sans', sans-serif;
            color: var(--text); outline: none;
            transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
        }
        .field input::placeholder { color: #2D3340; }
        .field input:focus {
            border-color: var(--accent2);
            background: rgba(99,102,241,0.05);
            box-shadow: 0 0 0 3px rgba(99,102,241,0.12);
        }
        .eye-btn {
            position: absolute; right: 11px; top: 50%;
            transform: translateY(-50%);
            background: none; border: none;
            color: var(--muted); cursor: pointer;
            font-size: 0.78rem; padding: 4px;
            transition: color 0.2s;
        }
        .eye-btn:hover { color: var(--accent2); }

        /* File upload */
        .file-upload-area {
            position: relative;
            border: 1px dashed rgba(99,102,241,0.3);
            border-radius: 8px;
            padding: 1rem;
            text-align: center;
            cursor: pointer;
            background: rgba(99,102,241,0.03);
            transition: border-color 0.2s, background 0.2s;
        }
        .file-upload-area:hover {
            border-color: rgba(99,102,241,0.6);
            background: rgba(99,102,241,0.06);
        }
        .file-upload-area input[type="file"] {
            position: absolute; inset: 0; opacity: 0; cursor: pointer;
            padding: 0; background: none; border: none;
        }
        .file-upload-area .upload-icon {
            font-size: 1.2rem; color: #6366F1; margin-bottom: 0.4rem;
        }
        .file-upload-area p {
            font-size: 0.78rem; color: var(--muted); line-height: 1.4;
        }
        .file-upload-area span { color: var(--accent2); font-weight: 500; }
        #file-name {
            margin-top: 0.4rem; font-size: 0.75rem; color: #818CF8;
        }

        /* Submit */
        .btn-submit {
            width: 100%; margin-top: 0.25rem;
            padding: 0.85rem;
            background: linear-gradient(135deg, var(--accent2), var(--accent));
            border: none; border-radius: 8px;
            font-family: 'Syne', sans-serif;
            font-size: 0.9rem; font-weight: 600;
            color: #fff; cursor: pointer;
            letter-spacing: 0.03em;
            transition: opacity 0.2s, transform 0.15s, box-shadow 0.2s;
            box-shadow: 0 4px 20px rgba(99,102,241,0.3);
        }
        .btn-submit:hover {
            opacity: 0.92; transform: translateY(-1px);
            box-shadow: 0 8px 28px rgba(99,102,241,0.4);
        }
        .btn-submit:active { transform: translateY(0); }

        .divider {
            display: flex; align-items: center; gap: 12px;
            margin: 1.25rem 0;
        }
        .divider::before, .divider::after {
            content: ''; flex: 1; height: 1px; background: var(--border);
        }
        .divider span { font-size: 0.72rem; color: var(--muted); }

        .form-footer {
            text-align: center; font-size: 0.82rem; color: var(--muted);
        }
        .form-footer a {
            color: var(--accent2); text-decoration: none; font-weight: 500;
            transition: color 0.2s;
        }
        .form-footer a:hover { color: #818CF8; }

        @media (max-width: 900px) {
            body { flex-direction: column; overflow: auto; }
            .left-panel { width: 100%; min-height: 180px; }
            .steps { display: none; }
            .right-panel { width: 100%; border-left: none; border-top: 1px solid var(--border); }
            .fields-grid { grid-template-columns: 1fr; }
            .field.full { grid-column: auto; }
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
            <h1 class="left-headline">Solicita<br>tu <span>acceso</span><br>al sistema.</h1>
            <p class="left-sub">Tu cuenta será revisada y activada por un administrador antes de que puedas ingresar.</p>

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
        </div>
    </div>

    <!-- Right panel -->
    <div class="right-panel">
        <div class="form-box">
            <h2 class="form-title">Crear cuenta</h2>
            <p class="form-subtitle">Completa los campos para enviar tu solicitud</p>

            @if ($errors->any())
            <div class="alert-err">
                <ul>
                    @foreach ($errors->all() as $item)
                    <li>{{ $item }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('register.register') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="fields-grid">
                    <div class="field full">
                        <label>Nombre completo</label>
                        <div class="field-wrap">
                            <span class="icon"><i class="fas fa-user"></i></span>
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="Tu nombre" autofocus autocomplete="off" required />
                        </div>
                    </div>

                    <div class="field full">
                        <label>Correo electrónico</label>
                        <div class="field-wrap">
                            <span class="icon"><i class="fas fa-envelope"></i></span>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="tu@correo.com" autocomplete="off" required />
                        </div>
                    </div>

                    <div class="field">
                        <label>Contraseña</label>
                        <div class="field-wrap">
                            <span class="icon"><i class="fas fa-lock"></i></span>
                            <input type="password" name="password" id="pwd1" placeholder="••••••••" required />
                            <button type="button" class="eye-btn" onclick="togglePwd('pwd1', this)">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="field">
                        <label>Confirmar contraseña</label>
                        <div class="field-wrap">
                            <span class="icon"><i class="fas fa-lock"></i></span>
                            <input type="password" name="password_confirmation" id="pwd2" placeholder="••••••••" required />
                            <button type="button" class="eye-btn" onclick="togglePwd('pwd2', this)">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="field full">
                        <label>Comprobante de pago o identidad</label>
                        <div class="file-upload-area" id="drop-area">
                            <input type="file" name="payment_receipt" id="receipt" accept=".pdf,.jpg,.jpeg,.png"
                                onchange="updateFileName(this)" />
                            <div class="upload-icon"><i class="fas fa-cloud-arrow-up"></i></div>
                            <p><span>Selecciona un archivo</span> o arrastra aquí<br>PDF, JPG, PNG</p>
                            <p id="file-name"></p>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fas fa-paper-plane" style="margin-right:8px;"></i>Enviar solicitud
                </button>
            </form>

            <div class="divider"><span>¿ya tienes cuenta?</span></div>
            <div class="form-footer">
                <a href="{{ route('login.index') }}">&larr; Volver al inicio de sesión</a>
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
        function updateFileName(input) {
            const el = document.getElementById('file-name');
            el.textContent = input.files[0] ? '✓ ' + input.files[0].name : '';
        }
    </script>
</body>
</html>