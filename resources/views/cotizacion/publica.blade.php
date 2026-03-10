<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotización #CIT-{{ $cotizacion->id }} — {{ $empresa->nombre ?? 'Punto de Venta' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'DM Sans', sans-serif; background: #F0F2F7; min-height: 100vh; padding: 2rem 1rem; color: #111827; }
        .page { max-width: 760px; margin: 0 auto; }

        .doc-header { background: #0E1117; border-radius: 12px 12px 0 0; padding: 1.75rem 2rem; display: flex; align-items: center; justify-content: space-between; }
        .brand { display: flex; align-items: center; gap: 12px; }
        .brand-icon { width: 40px; height: 40px; background: linear-gradient(135deg, #3B82F6, #6366F1); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 16px; }
        .brand-name { font-family: 'Syne', sans-serif; font-weight: 700; font-size: 1rem; color: #fff; letter-spacing: 0.03em; }
        .cit-num { font-family: 'Syne', sans-serif; font-size: 0.85rem; color: rgba(255,255,255,0.4); letter-spacing: 0.06em; }

        .doc-body { background: #fff; border: 1px solid #E4E7EF; border-top: none; border-radius: 0 0 12px 12px; overflow: hidden; }

        .status-bar { padding: 0.75rem 2rem; display: flex; align-items: center; gap: 10px; border-bottom: 1px solid #E4E7EF; background: #F7F8FB; }
        .badge-estado { display: inline-flex; align-items: center; gap: 6px; padding: 0.3em 0.8em; border-radius: 20px; font-size: 0.78rem; font-weight: 600; }
        .badge-pendiente { background: rgba(59,130,246,0.1); color: #2563EB; border: 1px solid rgba(59,130,246,0.2); }
        .badge-aprobada  { background: rgba(16,185,129,0.1); color: #059669; border: 1px solid rgba(16,185,129,0.2); }
        .badge-rechazada { background: rgba(239,68,68,0.1);  color: #DC2626; border: 1px solid rgba(239,68,68,0.2); }
        .badge-vencida   { background: rgba(245,158,11,0.1); color: #D97706; border: 1px solid rgba(245,158,11,0.2); }

        .alert { margin: 1rem 2rem; padding: 0.75rem 1rem; border-radius: 8px; font-size: 0.85rem; }
        .alert-success { background: rgba(16,185,129,0.08); border: 1px solid rgba(16,185,129,0.2); color: #059669; }
        .alert-info    { background: rgba(59,130,246,0.08);  border: 1px solid rgba(59,130,246,0.2);  color: #2563EB; }
        .alert-warning { background: rgba(245,158,11,0.08);  border: 1px solid rgba(245,158,11,0.2);  color: #D97706; }

        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; padding: 1.75rem 2rem; border-bottom: 1px solid #E4E7EF; }
        .info-block h6 { font-family: 'Syne', sans-serif; font-size: 0.68rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: #9CA3AF; margin-bottom: 0.75rem; }
        .info-block .cliente-nombre { font-family: 'Syne', sans-serif; font-size: 1rem; font-weight: 700; color: #111827; margin-bottom: 0.3rem; }
        .info-block p { font-size: 0.84rem; color: #6B7280; margin-bottom: 0.2rem; }
        .info-block .detail-row { display: flex; justify-content: space-between; font-size: 0.84rem; padding: 0.3rem 0; border-bottom: 1px solid #F3F4F6; }
        .info-block .detail-row span:first-child { color: #9CA3AF; }
        .info-block .detail-row span:last-child   { font-weight: 500; color: #111827; }
        .text-vencido { color: #DC2626 !important; }
        .text-vigente { color: #059669 !important; }

        .productos-section { padding: 1.75rem 2rem; border-bottom: 1px solid #E4E7EF; }
        .productos-section h6 { font-family: 'Syne', sans-serif; font-size: 0.68rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: #9CA3AF; margin-bottom: 1rem; }
        table { width: 100%; border-collapse: collapse; }
        thead th { background: #0E1117; color: rgba(255,255,255,0.7); font-family: 'Syne', sans-serif; font-size: 0.7rem; font-weight: 600; letter-spacing: 0.08em; text-transform: uppercase; padding: 0.7rem 1rem; text-align: left; }
        thead th:last-child { text-align: right; }
        tbody tr { border-bottom: 1px solid #F3F4F6; }
        tbody tr:last-child { border-bottom: none; }
        tbody td { padding: 0.85rem 1rem; font-size: 0.875rem; vertical-align: top; }
        tbody td:last-child { text-align: right; }
        .prod-nombre { font-weight: 500; color: #111827; }
        .prod-desc   { font-size: 0.78rem; color: #9CA3AF; margin-top: 3px; }
        .descuento-badge { display: inline-block; background: rgba(239,68,68,0.08); color: #DC2626; border-radius: 4px; padding: 1px 5px; font-size: 0.7rem; font-weight: 600; }

        .totales-section { padding: 1.25rem 2rem; background: #F7F8FB; }
        .totales-grid { max-width: 280px; margin-left: auto; }
        .total-row { display: flex; justify-content: space-between; font-size: 0.875rem; padding: 0.35rem 0; color: #6B7280; }
        .total-row span:last-child { font-weight: 500; color: #111827; }
        .total-row.final { border-top: 2px solid #E4E7EF; margin-top: 0.5rem; padding-top: 0.75rem; }
        .total-row.final span:first-child { font-family: 'Syne', sans-serif; font-size: 1rem; font-weight: 700; color: #111827; }
        .total-row.final span:last-child  { font-family: 'Syne', sans-serif; font-size: 1.15rem; font-weight: 800; color: #3B82F6; }

        .obs-section { padding: 1.25rem 2rem; border-top: 1px solid #E4E7EF; }
        .obs-section h6 { font-family: 'Syne', sans-serif; font-size: 0.68rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: #9CA3AF; margin-bottom: 0.5rem; }
        .obs-section p { font-size: 0.875rem; color: #6B7280; line-height: 1.6; }

        /* Login prompt */
        .login-prompt { padding: 1.75rem 2rem; border-top: 1px solid #E4E7EF; text-align: center; background: #F7F8FB; }
        .login-prompt p { font-size: 0.875rem; color: #6B7280; margin-bottom: 1rem; }
        .btn-login {
            display: inline-flex; align-items: center; gap: 8px;
            background: linear-gradient(135deg, #3B82F6, #6366F1);
            color: #fff; border: none; padding: 0.8rem 2rem; border-radius: 8px;
            font-family: 'Syne', sans-serif; font-weight: 600; font-size: 0.9rem;
            text-decoration: none; box-shadow: 0 4px 14px rgba(99,102,241,0.3); transition: all 0.2s;
        }
        .btn-login:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(99,102,241,0.4); color: #fff; }

        /* Decisión */
        .decision-section { padding: 1.75rem 2rem; border-top: 1px solid #E4E7EF; text-align: center; }
        .decision-section .welcome { font-size: 0.875rem; color: #6B7280; margin-bottom: 0.4rem; }
        .decision-section .welcome strong { color: #111827; }
        .decision-section p { font-size: 0.82rem; color: #9CA3AF; margin-bottom: 1.25rem; }
        .decision-btns { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; }
        .btn-aceptar { background: linear-gradient(135deg, #10B981, #059669); color: #fff; border: none; padding: 0.8rem 2rem; border-radius: 8px; font-family: 'Syne', sans-serif; font-weight: 600; font-size: 0.9rem; cursor: pointer; display: flex; align-items: center; gap: 8px; transition: all 0.2s; box-shadow: 0 4px 14px rgba(16,185,129,0.3); }
        .btn-aceptar:hover { transform: translateY(-1px); }
        .btn-rechazar { background: #fff; color: #DC2626; border: 1px solid rgba(239,68,68,0.3); padding: 0.8rem 2rem; border-radius: 8px; font-family: 'Syne', sans-serif; font-weight: 600; font-size: 0.9rem; cursor: pointer; display: flex; align-items: center; gap: 8px; transition: all 0.2s; }
        .btn-rechazar:hover { background: rgba(239,68,68,0.05); }

        /* Estado final */
        .estado-final { padding: 1.5rem 2rem; border-top: 1px solid #E4E7EF; text-align: center; }
        .estado-final .icon { font-size: 2.5rem; margin-bottom: 0.75rem; }
        .estado-final h4 { font-family: 'Syne', sans-serif; font-weight: 700; font-size: 1.1rem; margin-bottom: 0.3rem; }
        .estado-final p { font-size: 0.85rem; color: #9CA3AF; }

        .doc-footer { text-align: center; padding: 1.25rem; font-size: 0.75rem; color: #9CA3AF; }

        @media (max-width: 600px) {
            .info-grid { grid-template-columns: 1fr; }
            .doc-header { flex-direction: column; gap: 8px; text-align: center; }
            .decision-btns { flex-direction: column; }
            .btn-aceptar, .btn-rechazar { justify-content: center; }
        }
    </style>
</head>
<body>
<div class="page">

    <div class="doc-header">
        <div class="brand">
            <div class="brand-icon"><i class="fas fa-cash-register"></i></div>
            <span class="brand-name">{{ $empresa->nombre ?? 'Punto de Venta' }}</span>
        </div>
        <span class="cit-num">COTIZACIÓN #CIT-{{ $cotizacion->id }}</span>
    </div>

    <div class="doc-body">

        <div class="status-bar">
            @php $vencida = $cotizacion->fecha_validez < now()->format('Y-m-d') && $cotizacion->estado == 1; @endphp
            @if($vencida)
                <span class="badge-estado badge-vencida"><i class="fas fa-clock"></i> Vencida</span>
            @elseif($cotizacion->estado == 1)
                <span class="badge-estado badge-pendiente"><i class="fas fa-hourglass-half"></i> Pendiente de respuesta</span>
            @elseif($cotizacion->estado == 2)
                <span class="badge-estado badge-aprobada"><i class="fas fa-check-circle"></i> Aprobada</span>
            @else
                <span class="badge-estado badge-rechazada"><i class="fas fa-times-circle"></i> Rechazada</span>
            @endif
            <span style="font-size:0.78rem; color:#9CA3AF; margin-left:auto;">
                Emitida el {{ \Carbon\Carbon::parse($cotizacion->fecha_hora)->format('d/m/Y') }}
            </span>
        </div>

        @if(session('success'))
            <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif
        @if(session('info'))
            <div class="alert alert-info"><i class="fas fa-info-circle"></i> {{ session('info') }}</div>
        @endif

        <div class="info-grid">
            <div class="info-block">
                <h6>Cliente</h6>
                <p class="cliente-nombre">{{ $cotizacion->cliente->persona->razon_social }}</p>
                @if($cotizacion->cliente->persona->nombre_contacto ?? false)
                    <p><i class="fas fa-user" style="width:14px;"></i> {{ $cotizacion->cliente->persona->nombre_contacto }}</p>
                @endif
                <p><i class="fas fa-id-card" style="width:14px;"></i> {{ $cotizacion->cliente->persona->numero_documento }}</p>
                @if($cotizacion->cliente->persona->email ?? false)
                    <p><i class="fas fa-envelope" style="width:14px;"></i> {{ $cotizacion->cliente->persona->email }}</p>
                @endif
                @if($cotizacion->cliente->persona->rfc ?? false)
                    <p><i class="fas fa-receipt" style="width:14px;"></i> RFC: {{ $cotizacion->cliente->persona->rfc }}</p>
                @endif
            </div>
            <div class="info-block">
                <h6>Detalles</h6>
                <div class="detail-row"><span>Atendido por</span><span>{{ $cotizacion->user->name }}</span></div>
                <div class="detail-row"><span>Fecha emisión</span><span>{{ \Carbon\Carbon::parse($cotizacion->fecha_hora)->format('d-m-Y') }}</span></div>
                <div class="detail-row">
                    <span>Válida hasta</span>
                    <span class="{{ $vencida ? 'text-vencido' : 'text-vigente' }}">{{ $cotizacion->fecha_validez }}</span>
                </div>
                <div class="detail-row">
                    <span>IVA</span>
                    <span>{{ ($cotizacion->aplicar_iva ?? true) ? ($empresa->porcentaje_impuesto ?? 16).'%' : 'No aplica' }}</span>
                </div>
            </div>
        </div>

        <div class="productos-section">
            <h6>Productos / Servicios</h6>
            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th style="text-align:center;">Cant.</th>
                        <th style="text-align:right;">Precio Unit.</th>
                        <th style="text-align:right;">Desc.</th>
                        <th style="text-align:right;">Total</th>
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
                        <td style="text-align:center;">{{ $producto->pivot->cantidad }}</td>
                        <td style="text-align:right;">${{ number_format($producto->pivot->precio, 2) }}</td>
                        <td style="text-align:right;">
                            @if($desc > 0) <span class="descuento-badge">-{{ $desc }}%</span>
                            @else <span style="color:#D1D5DB;">—</span> @endif
                        </td>
                        <td style="text-align:right; font-weight:500;">${{ number_format($subtotal, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="totales-section">
            <div class="totales-grid">
                @php
                    $subtotalProductos = $cotizacion->productos->sum(fn($p) =>
                        $p->pivot->cantidad * $p->pivot->precio * (1 - ($p->pivot->descuento ?? 0) / 100)
                    );
                    $descGlobal = $cotizacion->descuento_global ?? 0;
                    $ahorroDescuento = $subtotalProductos * $descGlobal / 100;
                @endphp
                <div class="total-row"><span>Subtotal</span><span>${{ number_format($subtotalProductos, 2) }}</span></div>
                @if($descGlobal > 0)
                    <div class="total-row"><span>Descuento global ({{ $descGlobal }}%)</span><span style="color:#DC2626;">-${{ number_format($ahorroDescuento, 2) }}</span></div>
                @endif
                @if($cotizacion->aplicar_iva ?? true)
                    <div class="total-row"><span>IVA ({{ $empresa->porcentaje_impuesto ?? 16 }}%)</span><span>${{ number_format($cotizacion->impuesto, 2) }}</span></div>
                @else
                    <div class="total-row"><span>IVA</span><span style="color:#9CA3AF;">No aplica</span></div>
                @endif
                <div class="total-row final"><span>Total</span><span>${{ number_format($cotizacion->total, 2) }}</span></div>
            </div>
        </div>

        @if($cotizacion->observaciones)
        <div class="obs-section">
            <h6>Observaciones</h6>
            <p>{{ $cotizacion->observaciones }}</p>
        </div>
        @endif

        {{-- ════ LÓGICA DE ACCIÓN ════ --}}
        @php
            $esElCliente = auth()->check()
                && auth()->user()->email === ($cotizacion->cliente->persona->email ?? null);
        @endphp

        @if($cotizacion->estado == 2)
            <div class="estado-final">
                <div class="icon">✅</div>
                <h4 style="color:#059669;">Cotización Aceptada</h4>
                <p>Nos pondremos en contacto contigo pronto.</p>
            </div>

        @elseif($cotizacion->estado == 3)
            <div class="estado-final">
                <div class="icon">❌</div>
                <h4 style="color:#DC2626;">Cotización Rechazada</h4>
                <p>Lamentamos tu decisión. Si tienes dudas, contáctanos.</p>
            </div>

        @elseif($vencida)
            <div class="estado-final">
                <div class="icon">⏰</div>
                <h4 style="color:#D97706;">Cotización Vencida</h4>
                <p>Esta cotización ya no está vigente. Solicita al agente que renueve la fecha de validez.</p>
            </div>

        @elseif($esElCliente)
            {{-- Usuario autenticado y es el cliente correcto --}}
            <div class="decision-section">
                <p class="welcome">Hola, <strong>{{ auth()->user()->name }}</strong> — por favor confirma tu respuesta.</p>
                <p>Una vez respondida no podrás cambiarla desde aquí.</p>
                <div class="decision-btns">
                    <form action="{{ route('cotizaciones.responder', $cotizacion->token_publico) }}" method="POST" style="display:contents;">
                        @csrf
                        <input type="hidden" name="decision" value="aceptar">
                        <button type="submit" class="btn-aceptar">
                            <i class="fas fa-check-circle"></i> Aceptar cotización
                        </button>
                    </form>
                    <form action="{{ route('cotizaciones.responder', $cotizacion->token_publico) }}" method="POST" style="display:contents;">
                        @csrf
                        <input type="hidden" name="decision" value="rechazar">
                        <button type="submit" class="btn-rechazar"
                            onclick="return confirm('¿Seguro que deseas rechazar esta cotización?')">
                            <i class="fas fa-times-circle"></i> Rechazar
                        </button>
                    </form>
                </div>
            </div>

        @elseif(auth()->check())
            {{-- Autenticado pero no es el cliente de esta cotización --}}
            <div class="login-prompt">
                <div class="alert alert-warning" style="margin: 0 0 1rem 0; display:inline-block; text-align:left;">
                    <i class="fas fa-triangle-exclamation"></i>
                    La sesión activa no corresponde al destinatario de esta cotización.
                </div>
                <p>Si eres el destinatario, inicia sesión con <strong>{{ $cotizacion->cliente->persona->email }}</strong>.</p>
            </div>

        @else
            {{-- No autenticado --}}
            <div class="login-prompt">
                <p>
                    <i class="fas fa-lock" style="color:#6366F1; margin-right:6px;"></i>
                    Para aceptar o rechazar esta cotización debes iniciar sesión con tu cuenta.
                </p>
                <a href="{{ route('login') }}?redirect={{ urlencode(request()->fullUrl()) }}" class="btn-login">
                    <i class="fas fa-right-to-bracket"></i> Iniciar sesión
                </a>
            </div>
        @endif

    </div>

    <div class="doc-footer">
        {{ $empresa->nombre ?? 'Punto de Venta' }} &mdash; Cotización generada automáticamente
    </div>

</div>
</body>
</html>
