<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¡Tu cuenta ha sido activada!</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f0f2f5;
            font-family: 'Outfit', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            -webkit-font-smoothing: antialiased;
        }
        .wrapper {
            width: 100%;
            table-layout: fixed;
            background-color: #f0f2f5;
            padding-bottom: 40px;
        }
        .main {
            background-color: #ffffff;
            margin: 0 auto;
            width: 100%;
            max-width: 600px;
            border-spacing: 0;
            color: #1a1a1a;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            margin-top: 30px;
        }
        .header {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            padding: 40px 20px;
            text-align: center;
        }
        .header h1 {
            color: #ffffff;
            font-size: 28px;
            margin: 0;
            font-weight: 700;
            letter-spacing: -0.5px;
        }
        .content {
            padding: 40px 30px;
            text-align: center;
        }
        .content h2 {
            color: #0f172a;
            font-size: 24px;
            margin-bottom: 20px;
            font-weight: 600;
        }
        .content p {
            color: #64748b;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 30px;
        }
        .button-container {
            margin: 35px 0;
        }
        .btn {
            background-color: #3b82f6;
            color: #ffffff !important;
            padding: 16px 32px;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 16px;
            display: inline-block;
            box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.3), 0 2px 4px -1px rgba(59, 130, 246, 0.06);
            transition: all 0.2s ease;
        }
        .btn:hover {
            background-color: #2563eb;
            transform: translateY(-2px);
        }
        .footer {
            padding: 30px;
            text-align: center;
            background-color: #f8fafc;
            border-top: 1px solid #e2e8f0;
        }
        .footer p {
            color: #94a3b8;
            font-size: 13px;
            margin: 0;
        }
        .divider {
            height: 1px;
            background-color: #e2e8f0;
            margin: 30px 0;
        }
        .credential-box {
            background-color: #f1f5f9;
            border-radius: 12px;
            padding: 20px;
            margin: 20px 0;
            text-align: left;
        }
        .credential-item {
            display: block;
            margin-bottom: 5px;
            font-size: 14px;
            color: #475569;
        }
        .credential-value {
            font-weight: 600;
            color: #0f172a;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <table class="main">
            <tr>
                <td class="header">
                    <h1>{{ config('app.name') }}</h1>
                </td>
            </tr>
            <tr>
                <td class="content">
                    <h2>¡Bienvenido a bordo!</h2>
                    <p>Hola <strong>{{ $user->name }}</strong>, tenemos excelentes noticias para ti. Tu cuenta ha sido verificada y activada exitosamente por nuestro equipo administrativo.</p>
                    
                    <div class="credential-box">
                        <span class="credential-item">Correo electrónico: <span class="credential-value">{{ $user->email }}</span></span>
                        <span class="credential-item">Estado: <span class="credential-value" style="color: #10b981;">Activo</span></span>
                    </div>

                    <p>Ya puedes acceder al sistema con tus credenciales y comenzar a gestionar tu negocio.</p>
                    
                    <div class="button-container">
                        <a href="{{ config('app.url') }}/login" class="btn">Entrar al Sistema</a>
                    </div>

                    <div class="divider"></div>
                    
                    <p style="font-size: 14px;">Si tienes alguna pregunta o necesitas ayuda, no dudes en contactar a nuestro equipo de soporte.</p>
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
