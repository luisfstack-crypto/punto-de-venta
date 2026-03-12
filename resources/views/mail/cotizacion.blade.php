{{-- resources/views/mail/cotizacion.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotización</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f4f6f9; }
        .wrapper { width: 100%; padding: 30px 15px; background-color: #f4f6f9; }
        .container { width: 100%; max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }

        /* Header */
        .header { background: linear-gradient(135deg, #1B2D4F 0%, #2a4070 100%); padding: 28px 30px; }
        .header-inner { display: table; width: 100%; }
        .header-logo { display: table-cell; vertical-align: middle; width: 60%; }
        .header-num  { display: table-cell; vertical-align: middle; text-align: right; width: 40%; }
        .empresa-nombre { font-size: 18px; font-weight: 700; color: #ffffff; letter-spacing: 0.5px; }
        .empresa-sub    { font-size: 11px; color: rgba(255,255,255,0.5); margin-top: 3px; }
        .cit-label { font-size: 10px; color: rgba(255,255,255,0.45); letter-spacing: 2px; text-transform: uppercase; }
        .cit-num   { font-size: 22px; font-weight: 700; color: #C9A84C; margin-top: 2px; }

        /* Gold bar */
        .gold-bar { height: 4px; background: linear-gradient(90deg, #C9A84C, #E8C97A, #C9A84C); }

        /* Content */
        .content { padding: 32px 30px; color: #333333; line-height: 1.65; }

        .greeting { font-size: 17px; font-weight: 700; color: #1B2D4F; margin-bottom: 14px; }

        /* Mensaje personalizado */
        .msg-box {
            background: #f8f9ff;
            border-left: 3px solid #C9A84C;
            border-radius: 0 6px 6px 0;
            padding: 14px 18px;
            margin-bottom: 22px;
            font-size: 14px;
            color: #444;
            white-space: pre-line;
        }

        /* Resumen */
        .summary-box {
            background: #f8fafc;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 16px 18px;
            margin-bottom: 22px;
        }
        .summary-row { display: table; width: 100%; padding: 5px 0; border-bottom: 1px solid #f0f0f0; font-size: 13px; }
        .summary-row:last-child { border-bottom: none; padding-bottom: 0; }
        .summary-label { display: table-cell; color: #6B7280; width: 45%; }
        .summary-value { display: table-cell; text-align: right; font-weight: 600; color: #1B2D4F; }
        .summary-total .summary-label { font-size: 15px; font-weight: 700; color: #1B2D4F; }
        .summary-total .summary-value { font-size: 18px; font-weight: 700; color: #C9A84C; }

        /* Tabla productos */
        .prod-table { width: 100%; border-collapse: collapse; margin-bottom: 22px; font-size: 13px; }
        .prod-table thead tr { background-color: #1B2D4F; }
        .prod-table th { padding: 9px 12px; color: rgba(255,255,255,0.75); font-weight: 600; text-align: left; font-size: 11px; letter-spacing: 1px; text-transform: uppercase; }
        .prod-table th:last-child { text-align: right; }
        .prod-table td { padding: 9px 12px; border-bottom: 1px solid #f0f0f0; color: #374151; }
        .prod-table td:last-child { text-align: right; font-weight: 600; }
        .prod-table tbody tr:nth-child(even) { background: #fafafa; }

        /* CTA */
        .cta-wrap { text-align: center; margin: 24px 0; }
        .cta-btn {
            display: inline-block;
            padding: 13px 32px;
            background: linear-gradient(135deg, #C9A84C, #A0742A);
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 700;
            font-size: 14px;
            letter-spacing: 0.5px;
        }

        /* Firma */
        .firma-box {
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
            font-size: 13px;
            color: #555;
            white-space: pre-line;
        }
        .firma-label {
            font-size: 10px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: #9CA3AF;
            margin-bottom: 8px;
        }

        /* Footer */
        .footer {
            background: #1B2D4F;
            padding: 18px 30px;
            text-align: center;
            font-size: 11px;
            color: rgba(255,255,255,0.45);
            line-height: 1.7;
        }
        .footer span { color: #C9A84C; }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="container">

        {{-- Header --}}
        <div class="header">
            <div class="header-inner">
                <div class="header-logo">
                    <div class="empresa-nombre">{{ $cotizacion->user->empresa_nombre ?? $empresa->nombre ?? config('app.name') }}</div>
                    @if($empresa->direccion ?? false)
                        <div class="empresa-sub">{{ $empresa->direccion }}</div>
                    @endif
                    @if($empresa->telefono ?? false)
                        <div class="empresa-sub">{{ $empresa->telefono }}</div>
                    @endif
                </div>
                <div class="header-num">
                    <div class="cit-label">Cotización</div>
                    <div class="cit-num">#CIT-{{ $cotizacion->id }}</div>
                </div>
            </div>
        </div>
        <div class="gold-bar"></div>

        {{-- Cuerpo --}}
        <div class="content">

            <div class="greeting">Hola, {{ $cotizacion->cliente->persona->razon_social }}</div>

            {{-- Mensaje personalizado --}}
            @if(!empty($mensajePersonalizado))
            <div class="msg-box">{{ $mensajePersonalizado }}</div>
            @else
            <p style="margin-bottom:20px; font-size:14px; color:#555;">
                Adjuntamos la cotización solicitada. A continuación encontrará un resumen detallado.
            </p>
            @endif

            {{-- Resumen --}}
            <div class="summary-box">
                <div class="summary-row">
                    <span class="summary-label">Referencia</span>
                    <span class="summary-value">{{ $cotizacion->observaciones ?? 'Sin observaciones' }}</span>
                </div>
                <div class="summary-row">
                    <span class="summary-label">Válida hasta</span>
                    <span class="summary-value">{{ \Carbon\Carbon::parse($cotizacion->fecha_validez)->format('d/m/Y') }}</span>
                </div>
                <div class="summary-row summary-total">
                    <span class="summary-label">Total</span>
                    <span class="summary-value">${{ number_format($cotizacion->total, 2) }}</span>
                </div>
            </div>

            {{-- Tabla productos --}}
            <table class="prod-table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th style="text-align:center;">Cant.</th>
                        <th style="text-align:right;">Precio Unit.</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cotizacion->productos as $prod)
                    <tr>
                        <td>{{ $prod->nombre }}</td>
                        <td style="text-align:center;">{{ $prod->pivot->cantidad }}</td>
                        <td style="text-align:right;">${{ number_format($prod->pivot->precio, 2) }}</td>
                        <td>${{ number_format($prod->pivot->cantidad * $prod->pivot->precio, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Botón portal --}}
            <div class="cta-wrap">
                <a href="{{ route('cotizaciones.publica', $cotizacion->token_publico) }}" class="cta-btn">
                    Ver cotización completa →
                </a>
            </div>

            {{-- Firma --}}
            @if(!empty($firma))
            <div class="firma-box">
                <div class="firma-label">— Firma</div>
                {{ $firma }}
            </div>
            @else
            <div class="firma-box">
                <div class="firma-label">— Atendido por</div>
                {{ $cotizacion->user->name }}<br>
                {{ $cotizacion->user->empresa_nombre ?? $empresa->nombre ?? '' }}<br>
                @if($empresa->telefono ?? false){{ $empresa->telefono }}<br>@endif
                {{ $cotizacion->user->email }}
            </div>
            @endif

        </div>

        {{-- Footer --}}
        <div class="footer">
            &copy; {{ date('Y') }} <span>{{ $cotizacion->user->empresa_nombre ?? $empresa->nombre ?? config('app.name') }}</span><br>
            Este correo fue generado automáticamente — por favor no responda directamente.
        </div>

    </div>
</div>
</body>
</html>
