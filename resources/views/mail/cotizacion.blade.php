<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotización</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .header {
            background-color: #0d6efd;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .content {
            padding: 30px;
            color: #333333;
            line-height: 1.6;
        }
        .greeting {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #2c3e50;
        }
        .message {
            margin-bottom: 25px;
        }
        .details-box {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 25px;
        }
        .details-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .details-row:last-child {
            margin-bottom: 0;
        }
        .details-label {
            font-weight: 600;
            color: #555555;
        }
        .details-value {
            font-weight: bold;
            color: #2c3e50;
        }
        .cta-button {
            display: block;
            width: 200px;
            margin: 0 auto;
            padding: 12px 20px;
            background-color: #0d6efd;
            color: #ffffff;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            font-size: 16px;
        }
        .cta-button:hover {
            background-color: #0b5ed7;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #888888;
            border-top: 1px solid #e9ecef;
        }
        .divider {
            height: 1px;
            background-color: #e9ecef;
            margin: 20px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            text-align: left;
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Cotización #{{ $cotizacion->id }}</h1>
        </div>
        <div class="content">
            <div class="greeting">Hola, {{ $cotizacion->cliente->persona->razon_social }}</div>
            
            <div class="message">
                Adjuntamos la cotización solicitada. A continuación, un resumen de los detalles:
            </div>

            <div class="details-box">
                <div class="details-row">
                    <span class="details-label">Referencia/Observación:</span>
                    <span class="details-value">{{ $cotizacion->observaciones ?? 'Sin observaciones' }}</span>
                </div>
                <div class="details-row">
                    <span class="details-label">Fecha de Validez:</span>
                    <span class="details-value">{{ $cotizacion->fecha_validez }}</span>
                </div>
                <div class="divider"></div>
                <div class="row">
                   <div class="col-8 text-end"><strong>IVA (16%):</strong></div>
                   <div class="col-4 text-end">{{ number_format($cotizacion->impuesto, 2) }}</div>
                </div>
            </div>

            <div class="message">
                <p><strong>Productos:</strong></p>
                <table>
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cant.</th>
                            <th>Precio</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cotizacion->productos as $prod)
                        <tr>
                            <td>{{ $prod->nombre }}</td>
                            <td>{{ $prod->pivot->cantidad }}</td>
                            <td>{{ number_format($prod->pivot->precio, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <br>
            <a href="{{ route('cotizaciones.publica', $cotizacion->token_publico) }}" class="cta-button" style="color: #ffffff;">Ver Cotización Completa</a>
            
            <p style="margin-top: 30px; font-size: 14px; color: #666;">
                Si tienes alguna pregunta, no dudes en contactarnos directamente respondiendo a este correo.
            </p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} {{ $empresa->nombre_empresa ?? config('app.name') }}. Todos los derechos reservados.<br>
            Atendido por: {{ $cotizacion->user->name }} ({{ $cotizacion->user->email }})
        </div>
    </div>
</body>
</html>
