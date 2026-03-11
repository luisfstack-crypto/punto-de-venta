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

        /* ══════════════════════════════
           HEADER 
        ══════════════════════════════ */
        .header {
            padding: 24px 30px 20px;
            border-bottom: 3px solid #C9A84C;
        }
        .header-table { width: 100%; }
        .header-logo-cell {
            vertical-align: middle;
            width: 55%;
        }
        .header-title-cell {
            vertical-align: middle;
            text-align: right;
            width: 45%;
        }

        /* Bloque logo + datos negocio */
        .brand-block { display: table; }
        .brand-logo-wrap {
            display: table-cell;
            vertical-align: middle;
            padding-right: 14px;
        }
        .brand-logo-wrap img {
            max-height: 70px;
            max-width: 120px;
        }
        .brand-info {
            display: table-cell;
            vertical-align: middle;
        }
        .brand-name {
            font-size: 15px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 3px;
        }
        .brand-detail {
            font-size: 10px;
            color: #6B7280;
            margin-bottom: 2px;
        }

        /* Sin logo — solo texto */
        .brand-name-only {
            font-size: 17px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 3px;
        }

        /* Título cotización */
        .doc-title {
            font-size: 28px;
            font-weight: 700;
            color: #1B2D4F;
            letter-spacing: 0.5px;
        }
        .doc-number {
            font-size: 11px;
            color: #9CA3AF;
            margin-top: 4px;
        }

        /* ══════════════════════════════
           BARRA DE ESTADO
        ══════════════════════════════ */
        .status-bar {
            background: #F7F8FB;
            border-bottom: 1px solid #E4E7EF;
            padding: 7px 30px;
            font-size: 10px;
            color: #6B7280;
        }
        .status-bar-table { width: 100%; }
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

        /* ══════════════════════════════
           CUERPO
        ══════════════════════════════ */
        .body-wrapper { padding: 22px 30px; }

        /* Info grid cliente / detalles */
        .info-grid { width: 100%; margin-bottom: 22px; }
        .info-grid td { vertical-align: top; width: 50%; }
        .info-block { padding-right: 20px; }
        .info-block-right {
            padding-left: 20px;
            border-left: 1px solid #E4E7EF;
        }

        .section-label {
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #9CA3AF;
            margin-bottom: 8px;
            border-bottom: 1px solid #F3F4F6;
            padding-bottom: 5px;
        }
        .cliente-nombre {
            font-size: 14px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 4px;
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
        .detail-row table { width: 100%; }
        .detail-row td:last-child { text-align: right; font-weight: 600; color: #111827; }
        .text-vigente { color: #059669; font-weight: 700; }
        .text-vencido { color: #DC2626; font-weight: 700; }

        /* Empresa del usuario en detalles */
        .atendido-empresa {
            font-size: 10px;
            color: #C9A84C;
            font-weight: 600;
        }

        /* ══════════════════════════════
           TABLA PRODUCTOS
        ══════════════════════════════ */
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
        .table-products thead tr { background: #1B2D4F; }
        .table-products th {
            padding: 9px 10px;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: rgba(255,255,255,0.75);
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
        .prod-desc { font-size: 9px; color: #9CA3AF; margin-top: 2px; }
        .descuento-badge {
            display: inline-block;
            background: #FEE2E2; color: #DC2626;
            border-radius: 3px; padding: 1px 4px;
            font-size: 9px; font-weight: 700;
        }

        /* ══════════════════════════════
           TOTALES
        ══════════════════════════════ */
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
            font-size: 9px; font-weight: 700;
            letter-spacing: 1.5px; text-transform: uppercase; color: #9CA3AF;
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
            background: #1B2D4F;
            padding: 10px 14px;
        }
        .total-final table { width: 100%; }
        .total-final td:first-child { color: rgba(255,255,255,0.65); font-size: 11px; font-weight: 700; }
        .total-final td:last-child { text-align: right; font-size: 16px; font-weight: 700; color: #C9A84C; }
        .descuento-row td { color: #DC2626 !important; }

        /* ══════════════════════════════
           OBSERVACIONES
        ══════════════════════════════ */
        .obs-box {
            margin-top: 20px;
            background: #F7F8FB;
            border-left: 3px solid #C9A84C;
            padding: 10px 14px;
            border-radius: 0 6px 6px 0;
        }
        .obs-label {
            font-size: 9px; font-weight: 700; letter-spacing: 1.5px;
            text-transform: uppercase; color: #9CA3AF; margin-bottom: 5px;
        }
        .obs-box p { font-size: 11px; color: #6B7280; line-height: 1.5; }

        /* ══════════════════════════════
           FOOTER
        ══════════════════════════════ */
        .footer {
            margin-top: 30px;
            padding: 14px 30px;
            border-top: 2px solid #C9A84C;
            text-align: center;
        }
        .footer-name {
            font-size: 11px;
            font-weight: 700;
            color: #1B2D4F;
        }
        .footer-sub {
            font-size: 9px;
            color: #9CA3AF;
            margin-top: 3px;
        }

        .clearfix::after { content: ''; display: table; clear: both; }
    </style>
</head>
<body>

    @php
        $user    = $cotizacion->user;
        $hasLogo = !empty($user->logo);
        $hasEmpresaNombre = !empty($user->empresa_nombre);
        // Fallback: si no tiene empresa_nombre, usar empresa global
        $nombreNegocio = $user->empresa_nombre ?? ($empresa->nombre ?? 'Punto de Venta');
        $telefonoNegocio = $user->empresa_telefono ?? ($empresa->telefono ?? null);
        $vencida = $cotizacion->fecha_validez < now()->format('Y-m-d') && $cotizacion->estado == 1;
    @endphp

    {{-- ═══ HEADER ═══ --}}
    <div class="header">
        <table class="header-table">
            <tr>
                <td class="header-logo-cell">
                    <div class="brand-block">
                        @if($hasLogo)
                            <div class="brand-logo-wrap">
                                <img src="{{ $user->logo }}" alt="{{ $nombreNegocio }}">
                            </div>
                        @endif
                        <div class="brand-info">
                            <div class="{{ $hasLogo ? 'brand-name' : 'brand-name-only' }}">
                                {{ $nombreNegocio }}
                            </div>
                            @if($empresa->direccion ?? false)
                                <div class="brand-detail">{{ $empresa->direccion }}</div>
                            @endif
                            @if($telefonoNegocio)
                                <div class="brand-detail">{{ $telefonoNegocio }}</div>
                            @endif
                            @if($empresa->correo ?? false)
                                <div class="brand-detail">{{ $empresa->correo }}</div>
                            @endif
                        </div>
                    </div>
                </td>
                <td class="header-title-cell">
                    <div class="doc-title">Cotización</div>
                    <div class="doc-number">#CIT-{{ $cotizacion->id }}</div>
                </td>
            </tr>
        </table>
    </div>

    {{-- ═══ BARRA DE ESTADO ═══ --}}
    <div class="status-bar">
        <table class="status-bar-table">
            <tr>
                <td>
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

    {{-- ═══ CUERPO ═══ --}}
    <div class="body-wrapper">

        <table class="info-grid">
            <tr>
                {{-- Cliente --}}
                <td>
                    <div class="info-block">
                        <div class="section-label">Cliente</div>
                        <div class="cliente-nombre">{{ $cotizacion->cliente->persona->razon_social }}</div>
                        @if($cotizacion->cliente->persona->nombre_contacto ?? false)
                            <div class="info-line">Contacto: {{ $cotizacion->cliente->persona->nombre_contacto }}</div>
                        @endif
                        <div class="info-line">Doc: {{ $cotizacion->cliente->persona->numero_documento }}</div>
                        @if($cotizacion->cliente->persona->email ?? false)
                            <div class="info-line">{{ $cotizacion->cliente->persona->email }}</div>
                        @endif
                        @if($cotizacion->cliente->persona->rfc ?? false)
                            <div class="info-line">RFC: {{ $cotizacion->cliente->persona->rfc }}</div>
                        @endif
                    </div>
                </td>
                {{-- Detalles --}}
                <td>
                    <div class="info-block-right">
                        <div class="section-label">Detalles</div>

                        <div class="detail-row">
                            <table><tr>
                                <td>Atendido por</td>
                                <td>
                                    <strong>{{ $user->name }}</strong>
                                    @if($hasEmpresaNombre)
                                        <br><span class="atendido-empresa">{{ $user->empresa_nombre }}</span>
                                    @endif
                                </td>
                            </tr></table>
                        </div>

                        <div class="detail-row">
                            <table><tr>
                                <td>Fecha emisión</td>
                                <td><strong>{{ \Carbon\Carbon::parse($cotizacion->fecha_hora)->format('d-m-Y') }}</strong></td>
                            </tr></table>
                        </div>

                        <div class="detail-row">
                            <table><tr>
                                <td>Válida hasta</td>
                                <td>
                                    <span class="{{ $vencida ? 'text-vencido' : 'text-vigente' }}">
                                        {{ $cotizacion->fecha_validez }}
                                    </span>
                                </td>
                            </tr></table>
                        </div>

                        @if($empresa->ruc ?? false)
                        <div class="detail-row">
                            <table><tr>
                                <td>RFC/RUC</td>
                                <td><strong>{{ $empresa->ruc }}</strong></td>
                            </tr></table>
                        </div>
                        @endif
                    </div>
                </td>
            </tr>
        </table>

        {{-- Productos --}}
        <div class="section-title">Productos / Servicios</div>
        <table class="table-products">
            <thead>
                <tr>
                    <th style="width:40%;">Descripción</th>
                    <th class="text-right" style="width:10%;">Cant.</th>
                    <th class="text-right" style="width:16%;">Precio Unit.</th>
                    <th class="text-right" style="width:12%;">Desc.</th>
                    <th class="text-right" style="width:22%;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cotizacion->productos as $producto)
                @php
                    $desc     = $producto->pivot->descuento ?? 0;
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
            $descGlobal      = $cotizacion->descuento_global ?? 0;
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

        {{-- Observaciones --}}
        @if($cotizacion->observaciones)
        <div class="obs-box" style="margin-top: 60px;">
            <div class="obs-label">Observaciones</div>
            <p>{{ $cotizacion->observaciones }}</p>
        </div>
        @endif

        {{-- Footer --}}
        <div class="footer">
            <div class="footer-name">{{ $nombreNegocio }}</div>
            <div class="footer-sub">Gracias por su preferencia.</div>
        </div>

    </div>
</body>
</html>
