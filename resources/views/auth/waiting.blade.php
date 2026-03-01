<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Esperando Aprobación</title>
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        body { background-color: #0F0F11; color: #E5E5E7; display: flex; text-align: center; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .card { background-color: #1E1E21; border: 1px solid #2C2C30; border-radius: 0.65rem; padding: 2rem; max-width: 500px; box-shadow: 0 20px 50px rgba(0,0,0,0.5); }
        .icon { font-size: 4rem; color: #f5c6cb; margin-bottom: 1rem; }
    </style>
</head>
<body>
    <div class="card">
        <i class="fas fa-clock icon text-warning"></i>
        <h2 class="mb-3">Cuenta en Revisión</h2>
        <p class="text-muted mb-4">
            Hola {{ auth()->user()->name }}, tu solicitud ha sido recibida y se encuentra actualmente en estado <strong>pendiente de aprobación</strong>.
        </p>
        <p class="text-muted mb-4">
            Un administrador revisará tu comprobante en breve. Te notificaremos por correo electrónico una vez que tu cuenta esté activa.
        </p>
        <a href="{{ route('logout') }}" class="btn btn-outline-light">Cerrar sesión</a>
    </div>
</body>
</html>
