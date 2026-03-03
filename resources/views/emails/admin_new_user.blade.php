<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Solicitud de Acceso</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0; padding: 0;
            background-color: #f0f2f5;
            font-family: 'Outfit', 'Segoe UI', sans-serif;
            -webkit-font-smoothing: antialiased;
        }
        .wrapper { width: 100%; background-color: #f0f2f5; padding-bottom: 40px; }
        .main {
            background-color: #ffffff;
            margin: 30px auto 0;
            width: 100%; max-width: 600px;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0,0,0,0.06);
        }
        .header {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            padding: 36px 24px;
            text-align: center;
        }
        .header h1 { color: #fff; font-size: 22px; margin: 0; font-weight: 700; letter-spacing: -0.3px; }
        .header p { color: #94a3b8; font-size: 13px; margin: 6px 0 0; }
        .badge {
            display: inline-block;
            background: rgba(251, 191, 36, 0.15);
            border: 1px solid rgba(251, 191, 36, 0.4);
            color: #fbbf24;
            font-size: 12px;
            font-weight: 600;
            padding: 4px 12px;
            border-radius: 999px;
            margin-top: 12px;
        }
        .content { padding: 36px 32px; }
        .content h2 { color: #0f172a; font-size: 20px; margin: 0 0 8px; font-weight: 700; }
        .content > p { color: #64748b; font-size: 15px; line-height: 1.6; margin-bottom: 24px; }
        .user-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 20px 24px;
            margin-bottom: 28px;
        }
        .user-card-row {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            font-size: 14px;
        }
        .user-card-row:last-child { margin-bottom: 0; }
        .user-card-label { color: #94a3b8; width: 110px; flex-shrink: 0; font-weight: 500; }
        .user-card-value { color: #0f172a; font-weight: 600; }
        .btn {
            display: block;
            width: fit-content;
            margin: 0 auto;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: #fff !important;
            text-decoration: none;
            padding: 14px 32px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 15px;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.35);
        }
        .divider { height: 1px; background: #e2e8f0; margin: 28px 0; }
        .footer { background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 24px; text-align: center; }
        .footer p { color: #94a3b8; font-size: 12px; margin: 0; }
    </style>
</head>
<body>
    <div class="wrapper">
        <table class="main" cellpadding="0" cellspacing="0">
            <tr>
                <td class="header">
                    <h1>{{ config('app.name') }}</h1>
                    <p>Panel de Administración</p>
                    <span class="badge">⚠️ Acción requerida</span>
                </td>
            </tr>
            <tr>
                <td class="content">
                    <h2>Nueva solicitud de acceso</h2>
                    <p>Un nuevo usuario se ha registrado en el sistema y está esperando tu aprobación para poder ingresar.</p>

                    <div class="user-card">
                        <div class="user-card-row">
                            <span class="user-card-label">Nombre:</span>
                            <span class="user-card-value">{{ $newUser->name }}</span>
                        </div>
                        <div class="user-card-row">
                            <span class="user-card-label">Correo:</span>
                            <span class="user-card-value">{{ $newUser->email }}</span>
                        </div>
                        <div class="user-card-row">
                            <span class="user-card-label">Fecha:</span>
                            <span class="user-card-value">{{ $newUser->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="user-card-row">
                            <span class="user-card-label">Estado:</span>
                            <span class="user-card-value" style="color: #f59e0b;">⏳ Pendiente</span>
                        </div>
                    </div>

                    <a href="{{ route('admin.users.pending') }}" class="btn">
                        Ver solicitudes pendientes
                    </a>

                    <div class="divider"></div>
                    <p style="color: #94a3b8; font-size: 13px; text-align: center; margin: 0;">
                        Recibiste este correo porque eres administrador de <strong>{{ config('app.name') }}</strong>.
                    </p>
                </td>
            </tr>
            <tr>
                <td class="footer">
                    <p>&copy; {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.</p>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
