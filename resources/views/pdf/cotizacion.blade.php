<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cotización #CIT-{{ $cotizacion->id }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #111827;
            background: #fff;
        }

        /* ── Header ── */
        .header {
            background: #0E1117;
            padding: 24px 30px;
            margin-bottom: 0;
        }
        .header-inner {
            display: table;
            width: 100%;
        }
        .header-left {
            display: table-cell;
            vertical-align: middle;
            width: 60%;
        }
        .header-right {
            display: table-cell;
            vertical-align: middle;
            text-align: right;
            width: 40%;
        }
        .brand-name {
            font-size: 18px;
            font-weight: 700;
            color: #fff;
            letter-spacing: 1px;
        }
        .brand-sub {
            font-size: 10px;
            color: rgba(255,255,255,0.4);
            margin-top: 3px;
        }
        .cit-number {
            font-size: 11px;
            color: rgba(255,255,255,0.4);
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 4px;
        }
        .cit-id {
            font-size: 22px;
            font-weight: 700;
            color: #3B82F6;
        }

        /* ── Status bar ── */
        .status-bar {
            background: #F7F8FB;
            border-bottom: 1px solid #E4E7EF;
            padding: 8px 30px;
            font-size: 10px;
            color: #6B7280;
        }
        .status-bar table { width: 100%; }
        .badge-estado {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 700;
        }
        .badge-pendiente { background: #DBEAFE; color: #1D4ED8; }
        .badge-aprobada  { background: #D1FAE5; color: #065F46; }
        .badge-rechazada { background: #FEE2E2; color: #991B1B; }
        .badge-vencida   { background: #FEF3C7; color: #92400E; }

        /* ── Body ── */
        .body-wrapper { padding: 24px 30px; }

        /* ── Info grid ── */
        .info-grid { width: 100%; margin-bottom: 24px; }
        .info-grid td { vertical-align: top; padding: 0; width: 50%; }
        .info-block { padding-right: 20px; }
        .info-block-right { padding-left: 20px; border-left: 1px solid #E4E7EF; }

        .section-label {
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #9CA3AF;
            margin-bottom: 10px;
            border-bottom: 1px solid #F3F4F6;
            padding-bottom: 5px;
        }

        .cliente-nombre {
            font-size: 14px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 5px;
        }
        .info-line {
            font-size: 11px;
            color: #6B7280;
            margin-bottom: 3px;
        }
        .info-line strong { color: #374151; }

        .detail-row {
            display: block;
            font-size: 11px;
            padding: 4px 0;
            border-bottom: 1px solid #F3F4F6;
            color: #6B7280;
        }
        .detail-row strong { color: #111827; }
        .text-vigente { color: #059669; font-weight: 700; }
        .text-vencido { color: #DC2626; font-weight: 700; }
        .text-blue    { color: #2563EB; font-weight: 700; }

        /* ── Tabla productos ── */
        .section-title {
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #9CA3AF;
            margin-bottom: 8px;
            padding-bottom: 5px;
            border-bottom: 1px solid #F3F4F6;
        }

        .table-products {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table-products thead tr {
            background: #0E1117;
        }
        .table-products th {
            padding: 9px 10px;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: rgba(255,255,255,0.6);
            text-align: left;
        }
        .table-products th.text-right { text-align: right; }
        .table-products tbody tr { border-bottom: 1px solid #F3F4F6; }
        .table-products tbody tr:nth-child(even) { background: #F9FAFB; }
        .table-products td {
            padding: 9px 10px;
            font-size: 11px;
            color: #374151;
            vertical-align: top;
        }
        .table-products td.text-right { text-align: right; }
        .table-products td.text-center { text-align: center; }

        .prod-nombre { font-weight: 600; color: #111827; }
        .prod-desc   { font-size: 9px; color: #9CA3AF; margin-top: 2px; }
        .descuento-badge {
            display: inline-block;
            background: #FEE2E2;
            color: #DC2626;
            border-radius: 3px;
            padding: 1px 4px;
            font-size: 9px;
            font-weight: 700;
        }

        /* ── Totales ── */
        .totales-wrapper { width: 100%; }
        .totales-inner {
            float: right;
            width: 240px;
            border: 1px solid #E4E7EF;
            border-radius: 6px;
            overflow: hidden;
        }
        .totales-header {
            background: #F7F8FB;
            padding: 8px 14px;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: #9CA3AF;
        }
        .total-row {
            padding: 6px 14px;
            font-size: 11px;
            border-bottom: 1px solid #F3F4F6;
            display: block;
        }
        .total-row table { width: 100%; }
        .total-row td:last-child { text-align: right; font-weight: 600; color: #111827; }
        .total-row td:first-child { color: #6B7280; }
        .total-final {
            background: #0E1117;
            padding: 10px 14px;
        }
        .total-final table { width: 100%; }
        .total-final td:first-child { color: rgba(255,255,255,0.6); font-size: 11px; font-weight: 700; }
        .total-final td:last-child { text-align: right; font-size: 16px; font-weight: 700; color: #3B82F6; }

        .descuento-row td { color: #DC2626 !important; }

        /* ── Fiscal ── */
        .fiscal-box {
            margin-top: 20px;
            border: 1px dashed #E4E7EF;
            border-radius: 6px;
            padding: 12px 16px;
        }

        /* ── Observaciones ── */
        .obs-box {
            margin-top: 20px;
            background: #F7F8FB;
            border-left: 3px solid #3B82F6;
            padding: 10px 14px;
            border-radius: 0 6px 6px 0;
        }
        .obs-box .obs-label {
            font-size: 9px; font-weight: 700; letter-spacing: 1.5px;
            text-transform: uppercase; color: #9CA3AF; margin-bottom: 5px;
        }
        .obs-box p { font-size: 11px; color: #6B7280; line-height: 1.5; }

        /* ── Footer ── */
        .footer {
            margin-top: 30px;
            padding-top: 16px;
            border-top: 1px solid #E4E7EF;
            text-align: center;
            font-size: 10px;
            color: #9CA3AF;
        }

        .clearfix::after { content: ''; display: table; clear: both; }
    </style>
</head>
<body>

    {{-- Header --}}
    <div class="header">
        <div class="header-inner">
            <div class="header-left">
                <div class="brand-name">{{ $empresa->nombre ?? 'Punto de Venta' }}</div>
                @if($empresa->direccion ?? false)
                    <div class="brand-sub">{{ $empresa->direccion }}</div>
                @endif
            </div>
            <div class="header-right">
                <div class="cit-number">Cotización</div>
                <div class="cit-id">#CIT-{{ $cotizacion->id }}</div>
            </div>
        </div>
    </div>

    {{-- Status bar --}}
    <div class="status-bar">
        <table>
            <tr>
                <td>
                    @php $vencida = $cotizacion->fecha_validez < now()->format('Y-m-d') && $cotizacion->estado == 1; @endphp
                    @if($vencida)
                        <span class="badge-estado badge-vencida">Vencida</span>
                    @elseif($cotizacion->estado == 1)
                        <span class="badge-estado badge-pendiente">Pendiente</span>
                    @elseif($cotizacion->estado == 2)
                        <span class="badge-estado badge-aprobada">Aprobada</span>
                    @else
                        <span class="badge-estado badge-rechazada">Rechazada</span>
                    @endif
                </td>
                <td style="text-align:right;">
                    Emitida el {{ \Carbon\Carbon::parse($cotizacion->fecha_hora)->format('d/m/Y H:i') }}
                </td>
            </tr>
        </table>
    </div>

    <div class="body-wrapper">

        {{-- Info grid: Cliente + Detalles --}}
        <table class="info-grid">
            <tr>
                <td>
                    <div class="info-block">
                        <div class="section-label">Cliente</div>
                        <div class="cliente-nombre">{{ $cotizacion->cliente->persona->razon_social }}</div>
                        @if($cotizacion->cliente->persona->nombre_contacto ?? false)
                            <div class="info-line">Contacto: {{ $cotizacion->cliente->persona->nombre_contacto }}</div>
                        @endif
                        <div class="info-line">
                            Doc: {{ $cotizacion->cliente->persona->numero_documento }}
                        </div>
                        @if($cotizacion->cliente->persona->email ?? false)
                            <div class="info-line">{{ $cotizacion->cliente->persona->email }}</div>
                        @endif
                        @if($cotizacion->cliente->persona->rfc ?? false)
                            <div class="info-line">RFC: {{ $cotizacion->cliente->persona->rfc }}</div>
                        @endif
                        @if($cotizacion->cliente->persona->regimen_fiscal ?? false)
                            <div class="info-line">{{ $cotizacion->cliente->persona->regimen_fiscal }}</div>
                        @endif
                    </div>
                </td>
                <td>
                    <div class="info-block-right">
                        <div class="section-label">Detalles</div>
                        <div class="detail-row">
                            <table style="width:100%;"><tr>
                                <td>Atendido por</td>
                                <td style="text-align:right;"><strong>{{ $cotizacion->user->name }}</strong></td>
                            </tr></table>
                        </div>
                        <div class="detail-row">
                            <table style="width:100%;"><tr>
                                <td>Fecha emisión</td>
                                <td style="text-align:right;"><strong>{{ \Carbon\Carbon::parse($cotizacion->fecha_hora)->format('d-m-Y') }}</strong></td>
                            </tr></table>
                        </div>
                        <div class="detail-row">
                            <table style="width:100%;"><tr>
                                <td>Válida hasta</td>
                                <td style="text-align:right;">
                                    <span class="{{ $vencida ? 'text-vencido' : 'text-vigente' }}">
                                        {{ $cotizacion->fecha_validez }}
                                    </span>
                                </td>
                            </tr></table>
                        </div>
                        <div class="detail-row">
                            <table style="width:100%;"><tr>
                                <td>IVA</td>
                                <td style="text-align:right;">
                                    @if($cotizacion->aplicar_iva ?? true)
                                        <span class="text-blue">{{ $empresa->porcentaje_impuesto ?? 16 }}%</span>
                                    @else
                                        <span style="color:#9CA3AF;">No aplica</span>
                                    @endif
                                </td>
                            </tr></table>
                        </div>
                    </div>
                </td>
            </tr>
        </table>

        {{-- Productos --}}
        <div class="section-title">Productos / Servicios</div>
        <table class="table-products">
            <thead>
                <tr>
                    <th style="width:40%;">Producto</th>
                    <th class="text-right" style="width:12%;">Cant.</th>
                    <th class="text-right" style="width:16%;">Precio Unit.</th>
                    <th class="text-right" style="width:12%;">Desc.</th>
                    <th class="text-right" style="width:20%;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cotizacion->productos as $producto)
                @php
                    $desc = $producto->pivot->descuento ?? 0;
                    $subtotal = $producto->pivot->cantidad * $producto->pivot->precio * (1 - $desc / 100);
                @endphp
                <tr>
                    <td>
                        <div class="prod-nombre">{{ $producto->nombre }}</div>
                        @if($producto->pivot->descripcion ?? false)
                            <div class="prod-desc">{{ $producto->pivot->descripcion }}</div>
                        @endif
                    </td>
                    <td class="text-right">{{ $producto->pivot->cantidad }}</td>
                    <td class="text-right">${{ number_format($producto->pivot->precio, 2) }}</td>
                    <td class="text-right">
                        @if($desc > 0)
                            <span class="descuento-badge">-{{ $desc }}%</span>
                        @else
                            <span style="color:#D1D5DB;">—</span>
                        @endif
                    </td>
                    <td class="text-right">${{ number_format($subtotal, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Totales --}}
        @php
            $subtotalProductos = $cotizacion->productos->sum(fn($p) =>
                $p->pivot->cantidad * $p->pivot->precio * (1 - ($p->pivot->descuento ?? 0) / 100)
            );
            $descGlobal = $cotizacion->descuento_global ?? 0;
            $ahorroDescuento = $subtotalProductos * $descGlobal / 100;
        @endphp

        <div class="totales-wrapper clearfix">
            <div class="totales-inner">
                <div class="totales-header">Resumen</div>

                <div class="total-row">
                    <table><tr>
                        <td>Subtotal</td>
                        <td>${{ number_format($subtotalProductos, 2) }}</td>
                    </tr></table>
                </div>

                @if($descGlobal > 0)
                <div class="total-row descuento-row">
                    <table><tr>
                        <td>Descuento global ({{ $descGlobal }}%)</td>
                        <td>-${{ number_format($ahorroDescuento, 2) }}</td>
                    </tr></table>
                </div>
                @endif

                @if($cotizacion->aplicar_iva ?? true)
                <div class="total-row">
                    <table><tr>
                        <td>{{ $empresa->abreviatura_impuesto ?? 'IVA' }} ({{ $empresa->porcentaje_impuesto ?? 16 }}%)</td>
                        <td>${{ number_format($cotizacion->impuesto, 2) }}</td>
                    </tr></table>
                </div>
                @endif

                <div class="total-final">
                    <table><tr>
                        <td>Total</td>
                        <td>${{ number_format($cotizacion->total, 2) }}</td>
                    </tr></table>
                </div>
            </div>
        </div>

        {{-- Datos fiscales si aplica --}}
        @if(($cotizacion->cliente->persona->rfc ?? false) || ($cotizacion->cliente->persona->uso_cfdi ?? false))
        <div class="fiscal-box" style="margin-top:60px;">
            <div class="section-label">Datos Fiscales</div>
            <table style="width:100%;">
                <tr>
                    @if($cotizacion->cliente->persona->rfc ?? false)
                    <td class="info-line"><strong>RFC:</strong> {{ $cotizacion->cliente->persona->rfc }}</td>
                    @endif
                    @if($cotizacion->cliente->persona->regimen_fiscal ?? false)
                    <td class="info-line"><strong>Régimen:</strong> {{ $cotizacion->cliente->persona->regimen_fiscal }}</td>
                    @endif
                    @if($cotizacion->cliente->persona->uso_cfdi ?? false)
                    <td class="info-line"><strong>Uso CFDI:</strong> {{ $cotizacion->cliente->persona->uso_cfdi }}</td>
                    @endif
                </tr>
            </table>
        </div>
        @endif

        {{-- Observaciones --}}
        @if($cotizacion->observaciones)
        <div class="obs-box" style="margin-top: {{ ($cotizacion->cliente->persona->rfc ?? false) ? '12px' : '60px' }}">
            <div class="obs-label">Observaciones</div>
            <p>{{ $cotizacion->observaciones }}</p>
        </div>
        @endif

        {{-- Footer --}}
        <div class="footer">
            <p>{{ $empresa->nombre ?? 'Punto de Venta' }} &mdash; Gracias por su preferencia.</p>
            @if($empresa->email ?? false)
                <p>{{ $empresa->email }}</p>
            @endif
        </div>

    </div>
</body>
</html>
