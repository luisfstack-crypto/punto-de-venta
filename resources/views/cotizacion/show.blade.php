@extends('layouts.app')

@section('title','Ver Cotización')

@push('css')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Cotización</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('cotizaciones.index')}}">Cotizaciones</a></li>
        <li class="breadcrumb-item active">Ver Cotización #{{$cotizacion->id}}</li>
    </ol>
</div>

<div class="container-lg mt-4">
    
    <!-- Action Buttons (Top) -->
    <div class="d-flex justify-content-end mb-4">
        <a href="{{ route('cotizaciones.index') }}" class="btn btn-secondary me-2">Volver</a>
        
        <a href="{{ route('export.pdf-cotizacion', $cotizacion->id) }}" class="btn btn-primary me-2" target="_blank"><i class="fa-solid fa-file-pdf"></i> Imprimir/PDF</a>

        @if($cotizacion->estado != 2)
            <button type="button" class="btn btn-info me-2 text-white" data-bs-toggle="modal" data-bs-target="#emailModal">
                <i class="fa-solid fa-envelope"></i> Enviar Correo
            </button>
            <a href="{{ route('ventas.create', ['cotizacion_id' => $cotizacion->id]) }}" class="btn btn-success me-2"><i class="fa-solid fa-check"></i> Convertir a Venta</a>
            
            <button type="button" class="btn btn-warning text-dark" data-bs-toggle="modal" data-bs-target="#renewModal">
                <i class="fa-solid fa-calendar-days"></i> Renovar
            </button>
        @endif
    </div>

    <!-- Quotation Card -->
    <div class="card shadow-lg border-0 rounded-lg">
        <div class="card-header bg-white border-bottom p-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="mb-0 fw-bold text-primary">COTIZACIÓN #CIT-{{$cotizacion->id}}</h3>
                    <span class="text-muted small">Creado el {{$cotizacion->created_at->format('d/m/Y H:i')}}</span>
                </div>
                <div class="text-end">
                    @if($cotizacion->estado == 1)
                        <span class="badge bg-primary fs-6 px-3 py-2">Pendiente</span>
                    @elseif($cotizacion->estado == 2)
                        <span class="badge bg-success fs-6 px-3 py-2">Aprobada</span>
                    @else
                        <span class="badge bg-danger fs-6 px-3 py-2">Rechazada</span>
                    @endif
                    
                    @if($cotizacion->enviado_at)
                    <div class="mt-2">
                        <span class="badge text-white px-2 py-1" style="background-color: #d63384; font-size: 0.8rem;">
                            <i class="fa-solid fa-paper-plane"></i> Enviado
                        </span>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="card-body p-5">
            <!-- Client & Company Info -->
            <div class="row mb-5">
                <div class="col-md-6">
                    <h5 class="fw-bold text-secondary mb-3">Cliente</h5>
                    <div class="p-3 bg-light rounded border">
                        <h5 class="fw-bold mb-1">{{$cotizacion->cliente->persona->razon_social}}</h5>
                        <p class="mb-1 text-muted">{{$cotizacion->cliente->persona->tipo_documento}}: {{$cotizacion->cliente->persona->numero_documento}}</p>
                        <p class="mb-0 text-muted"><i class="fa-solid fa-envelope"></i> {{$cotizacion->cliente->persona->email}}</p>
                    </div>
                </div>
                <div class="col-md-6 text-md-end">
                    <h5 class="fw-bold text-secondary mb-3">Detalles</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><strong>Atendido por:</strong> {{$cotizacion->user->name}}</li>
                        <li class="mb-2"><strong>Fecha Emisión:</strong> <span class="text-dark">{{$cotizacion->fecha}}</span></li>
                        <li class="mb-2"><strong>Válida hasta:</strong> 
                            <span class="@if($cotizacion->fecha_validez < now()->format('Y-m-d')) text-danger fw-bold @else text-success fw-bold @endif">
                                {{$cotizacion->fecha_validez}}
                            </span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Products Table -->
            <div class="table-responsive mb-4">
                <table class="table table-borderless table-striped align-middle">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th class="py-3 ps-4 rounded-start">Producto</th>
                            <th class="py-3 text-center">Cantidad</th>
                            <th class="py-3 text-end">Precio Unit.</th>
                            <th class="py-3 text-end pe-4 rounded-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cotizacion->productos as $producto)
                        <tr>
                            <td class="ps-4 fw-semibold">{{$producto->nombre}}</td>
                            <td class="text-center">{{$producto->pivot->cantidad}}</td>
                            <td class="text-end">${{number_format($producto->pivot->precio, 2)}}</td>
                            <td class="text-end pe-4">${{number_format($producto->pivot->cantidad * $producto->pivot->precio, 2)}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Totals -->
            <div class="row justify-content-end">
                <div class="col-md-5 col-lg-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Subtotal:</span>
                        <span class="fw-bold">${{number_format($cotizacion->total - $cotizacion->impuesto, 2)}}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">{{$empresa->abreviatura_impuesto}} ({{$empresa->porcentaje_impuesto}}%):</span>
                        <span class="fw-bold">${{number_format($cotizacion->impuesto, 2)}}</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="h5 fw-bold text-primary">Total:</span>
                        <span class="h4 fw-bold text-primary">${{number_format($cotizacion->total, 2)}}</span>
                    </div>
                </div>
            </div>

            @if($cotizacion->observaciones)
            <div class="mt-5 p-3 bg-light border rounded">
                <h6 class="fw-bold text-secondary">Observaciones:</h6>
                <p class="text-muted mb-0">{{$cotizacion->observaciones}}</p>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Renew Modal -->
<div class="modal fade" id="renewModal" tabindex="-1" aria-labelledby="renewModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('cotizaciones.renew', $cotizacion) }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title text-dark fw-bold" id="renewModalLabel">Renovar Cotización</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>La vigencia actual es hasta: <strong>{{$cotizacion->fecha_validez}}</strong></p>
                    <div class="mb-3">
                        <label for="fecha_validez" class="form-label">Nueva Fecha de Validez:</label>
                        <input type="date" class="form-control" name="fecha_validez" id="fecha_validez" value="{{ date('Y-m-d', strtotime('+15 days')) }}" required min="{{ date('Y-m-d') }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning text-dark fw-bold">Actualizar Vigencia</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- ══════════════════════════════════════════
     MODAL — Enviar Cotización por Correo
══════════════════════════════════════════ -->
<div class="modal fade" id="emailModal" tabindex="-1" aria-labelledby="emailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form action="{{ route('cotizaciones.email', $cotizacion) }}" method="POST">
            @csrf
            <div class="modal-content border-0 shadow-lg">

                {{-- Header --}}
                <div class="modal-header" style="background: linear-gradient(135deg, #1B2D4F, #2a4070); border-bottom: 3px solid #C9A84C;">
                    <div>
                        <h5 class="modal-title text-white fw-bold mb-0" id="emailModalLabel">
                            <i class="fa-solid fa-envelope me-2" style="color:#C9A84C;"></i>
                            Enviar Cotización #CIT-{{ $cotizacion->id }}
                        </h5>
                        <small style="color:rgba(255,255,255,0.5); font-size:0.75rem;">
                            Personaliza el correo antes de enviarlo
                        </small>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                {{-- Body --}}
                <div class="modal-body p-4" style="background:#f8fafc;">

                    {{-- Destinatario --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:0.8rem; letter-spacing:0.05em; text-transform:uppercase; color:#6B7280;">
                            <i class="fa-solid fa-user me-1" style="color:#C9A84C;"></i> Destinatario
                        </label>
                        <input
                            type="email"
                            name="destinatario"
                            class="form-control"
                            value="{{ $cotizacion->cliente->persona->email ?? '' }}"
                            placeholder="correo@ejemplo.com"
                            required
                            style="border-radius:8px; border:1.5px solid #e2e8f0; font-size:0.9rem;"
                        >
                        @if(empty($cotizacion->cliente->persona->email))
                            <div class="form-text text-warning">
                                <i class="fa-solid fa-triangle-exclamation"></i>
                                El cliente no tiene correo registrado. Escribe uno manualmente.
                            </div>
                        @else
                            <div class="form-text text-muted">
                                Correo del cliente. Puedes cambiarlo para este envío sin afectar el registro.
                            </div>
                        @endif
                    </div>

                    {{-- Asunto --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:0.8rem; letter-spacing:0.05em; text-transform:uppercase; color:#6B7280;">
                            <i class="fa-solid fa-tag me-1" style="color:#C9A84C;"></i> Asunto
                        </label>
                        <input
                            type="text"
                            name="asunto"
                            class="form-control"
                            value="Cotización {{ $empresa->nombre ?? config('app.name') }} - {{ $cotizacion->observaciones ?? 'Presupuesto #CIT-'.$cotizacion->id }}"
                            required
                            style="border-radius:8px; border:1.5px solid #e2e8f0; font-size:0.9rem;"
                        >
                    </div>

                    {{-- Mensaje personalizado --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:0.8rem; letter-spacing:0.05em; text-transform:uppercase; color:#6B7280;">
                            <i class="fa-solid fa-message me-1" style="color:#C9A84C;"></i> Mensaje
                        </label>
                        <textarea
                            name="mensaje"
                            class="form-control"
                            rows="4"
                            placeholder="Estimado cliente, adjuntamos la cotización solicitada. Quedamos a sus órdenes para cualquier consulta..."
                            style="border-radius:8px; border:1.5px solid #e2e8f0; font-size:0.9rem; resize:vertical;"
                        ></textarea>
                        <div class="form-text text-muted">Opcional. Si lo dejas vacío se usará un mensaje estándar.</div>
                    </div>

                    {{-- Firma --}}
                    <div class="mb-1">
                        <label class="form-label fw-semibold" style="font-size:0.8rem; letter-spacing:0.05em; text-transform:uppercase; color:#6B7280;">
                            <i class="fa-solid fa-pen-nib me-1" style="color:#C9A84C;"></i> Firma
                        </label>
                        <textarea
                            name="firma"
                            class="form-control"
                            rows="4"
                            style="border-radius:8px; border:1.5px solid #e2e8f0; font-size:0.9rem; font-family:monospace; resize:vertical;"
                        >{{ auth()->user()->name }}
{{ auth()->user()->empresa_nombre ?? $empresa->nombre ?? '' }}
{{ $empresa->telefono ?? '' }}
{{ auth()->user()->email }}</textarea>
                        <div class="form-text text-muted">Aparece al final del correo. Puedes editarla para este envío.</div>
                    </div>

                </div>

                {{-- Footer --}}
                <div class="modal-footer" style="background:#f8fafc; border-top:1px solid #e2e8f0;">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="submit" class="btn text-white fw-bold px-4"
                        style="background: linear-gradient(135deg, #C9A84C, #A0742A); border:none; border-radius:8px;">
                        <i class="fa-solid fa-paper-plane me-2"></i> Enviar correo
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>
@endsection
