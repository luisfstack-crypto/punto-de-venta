<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Cuenta en Revisión - {{ config('app.name') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Outfit', 'Segoe UI', sans-serif;
            background-color: #0F0F11;
            color: #E5E5E7;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 1.5rem;
        }
        .card {
            background-color: #1E1E21;
            border: 1px solid #2C2C30;
            border-radius: 1rem;
            padding: 2.5rem 2rem;
            max-width: 520px;
            width: 100%;
            box-shadow: 0 20px 50px rgba(0,0,0,0.6);
            text-align: center;
        }
        .icon-wrapper {
            width: 80px; height: 80px;
            border-radius: 50%;
            background: rgba(251, 191, 36, 0.12);
            border: 2px solid rgba(251, 191, 36, 0.3);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2.2rem;
            color: #fbbf24;
        }
        h2 { font-size: 1.5rem; font-weight: 700; margin-bottom: 0.75rem; }
        p { color: #94a3b8; line-height: 1.7; margin-bottom: 1.2rem; font-size: 0.95rem; }
        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.3);
            border-radius: 0.5rem;
            padding: 0.85rem 1rem;
            color: #34d399;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }
        .divider { height: 1px; background: #2C2C30; margin: 1.5rem 0; }
        .btn {
            display: inline-block;
            padding: 0.65rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: all 0.2s;
        }
        .btn-primary {
            background-color: #4A8BDF;
            color: #fff;
        }
        .btn-primary:hover { background-color: #3570BF; }
        .btn-outline {
            background: transparent;
            border: 1px solid #3A3A3F;
            color: #94a3b8;
            margin-left: 0.5rem;
        }
        .btn-outline:hover { border-color: #6b7280; color: #E5E5E7; }
        .app-name { color: #4A8BDF; font-weight: 700; }
    </style>
</head>
<body>
    <div class="card">
        <div class="icon-wrapper">
            <i class="fas fa-clock"></i>
        </div>

        <h2>Cuenta en Revisión</h2>

        @if(session('success'))
            <div class="alert-success">
                <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
            </div>
        @endif

        @if(auth()->check())
            <p>
                Hola <strong>{{ auth()->user()->name }}</strong>, tu solicitud ha sido recibida y se encuentra en estado
                <strong>pendiente de aprobación</strong>.
            </p>
        @else
            <p>
                Tu solicitud de registro ha sido recibida y está en estado <strong>pendiente de aprobación</strong>.
            </p>
        @endif

        <p>
            Un administrador revisará tu información en breve. Recibirás un correo electrónico de <span class="app-name">{{ config('app.name') }}</span>
            en cuanto tu cuenta esté activa, junto con un enlace para ingresar al sistema.
        </p>

        <div class="divider"></div>

        @if(auth()->check())
            <a href="{{ route('logout') }}" class="btn btn-outline">
                <i class="fas fa-sign-out-alt"></i> Cerrar sesión
            </a>
        @else
            <a href="{{ route('login.index') }}" class="btn btn-primary">
                <i class="fas fa-sign-in-alt"></i> Ir al Login
            </a>
        @endif
    </div>
</body>
</html>
