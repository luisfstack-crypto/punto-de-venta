@extends('layouts.app')

@section('title','Cotizaciones')

@push('css-datatable')
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
@endpush
@push('css')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
    .row-not-space {
        width: 110px;
    }
</style>
@endpush

@section('content')

<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Cotizaciones</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item active">Cotizaciones</li>
    </ol>

    <div class="row mb-4 justify-content-center"> <!-- Centered Row -->
        <!-- Enviado -->
        <div class="col-xl-2 col-md-4 mb-2">
            <div class="card text-white text-center h-100" style="background-color: #d63384;"> <!-- Pinkish Red -->
                <div class="card-body py-2">
                    <h6 class="card-title text-uppercase font-weight-bold mb-0">Enviado</h6>
                    <h5 class="font-weight-bold mb-0">{{ $stats['total_sent'] }}</h5>
                    <small>${{ number_format($stats['amount_sent'], 2) }}</small>
                </div>
            </div>
        </div>
        <!-- Abierto / Pendiente -->
        <div class="col-xl-2 col-md-4 mb-2">
            <div class="card bg-primary text-white text-center h-100">
                <div class="card-body py-2">
                    <h6 class="card-title text-uppercase font-weight-bold mb-0">Pendiente</h6>
                    <h5 class="font-weight-bold mb-0">{{ $stats['total_pending'] }}</h5>
                    <small>${{ number_format($stats['amount_pending'], 2) }}</small>
                </div>
            </div>
        </div>
         <!-- Vencido -->
         <div class="col-xl-2 col-md-4 mb-2">
            <div class="card bg-warning text-dark text-center h-100">
                <div class="card-body py-2">
                    <h6 class="card-title text-uppercase font-weight-bold mb-0">Vencido</h6>
                    <h5 class="font-weight-bold mb-0">{{ $stats['total_expired'] }}</h5>
                    <small>${{ number_format($stats['amount_expired'], 2) }}</small>
                </div>
            </div>
        </div>
        <!-- Aceptado / Aprobado -->
        <div class="col-xl-2 col-md-4 mb-2">
            <div class="card bg-success text-white text-center h-100">
                <div class="card-body py-2">
                    <h6 class="card-title text-uppercase font-weight-bold mb-0">Aprobado</h6>
                    <h5 class="font-weight-bold mb-0">{{ $stats['total_approved'] }}</h5>
                    <small>${{ number_format($stats['amount_approved'], 2) }}</small>
                </div>
            </div>
        </div>
        <!-- Rechazado -->
        <div class="col-xl-2 col-md-4 mb-2">
            <div class="card bg-danger text-white text-center h-100">
                <div class="card-body py-2">
                    <h6 class="card-title text-uppercase font-weight-bold mb-0">Rechazado</h6>
                    <h5 class="font-weight-bold mb-0">{{ $stats['total_rejected'] }}</h5>
                    <small>${{ number_format($stats['amount_rejected'], 2) }}</small>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-4">
        <a href="{{route('cotizaciones.create')}}">
            <button type="button" class="btn btn-primary">Nueva Cotización</button>
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Tabla de Cotizaciones
        </div>
        <div class="card-body">
            <table id="datatablesSimple" class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Fecha</th>
                        <th>Validez</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cotizaciones as $item)
                    <tr>
                        <td>
                            CIT-{{$item->id}}
                        </td>
                        <td>
                            <p class="fw-semibold mb-1">
                                {{ ucfirst($item->cliente->persona->tipo_persona) }}
                            </p>
                            <p class="text-muted mb-0">
                                {{$item->cliente->persona->razon_social}}
                            </p>
                        </td>
                        <td>
                            {{$item->fecha}} {{$item->hora}}
                        </td>
                        <td>
                            {{$item->fecha_validez}}
                        </td>
                        <td>
                            {{$item->total}}
                        </td>
                        <td>
                            @if($item->estado == 1)
                                <span class="badge bg-primary">Pendiente</span> {{-- Changed to Primary (Blue) to match card --}}
                            @elseif($item->estado == 2)
                                <span class="badge bg-success">Aprobada</span>
                            @else
                                <span class="badge bg-danger">Rechazada</span>
                            @endif

                            @if($item->enviado_at)
                                <span class="badge text-white" style="background-color: #d63384;" title="Enviado: {{ $item->enviado_at }}">Enviado</span> {{-- Pink to match card --}}
                            @endif
                        </td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton{{$item->id}}" data-bs-toggle="dropdown" aria-expanded="false">
                                    Acciones
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{$item->id}}">
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="copyToClipboard('{{ route('cotizaciones.show', $item) }}')">
                                            <i class="fa-solid fa-copy me-2"></i> Copiar URL
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{route('cotizaciones.show', $item)}}">
                                            <i class="fa-solid fa-eye me-2"></i> Vista Previa
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('cotizaciones.email', $item) }}">
                                            <i class="fa-solid fa-envelope me-2"></i> Enviar Presupuesto
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    @if($item->estado == 1)
                                    <li>
                                        <a class="dropdown-item text-success" href="{{ route('ventas.create', ['cotizacion_id' => $item->id]) }}">
                                            <i class="fa-solid fa-check me-2"></i> Marcar como Aceptado
                                        </a>
                                    </li>
                                    <li>
                                        <!-- Form for rejection to use POST/PUT method safely -->
                                        <form action="{{ route('cotizaciones.update-status', $item) }}" method="POST" id="form-reject-{{$item->id}}">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="estado" value="0">
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="fa-solid fa-xmark me-2"></i> Marcar como Rechazado
                                            </button>
                                        </form>
                                    </li>
                                    @endif
                                    <li>
                                        <a class="dropdown-item" href="{{ route('cotizaciones.duplicate', $item) }}">
                                            <i class="fa-solid fa-copy me-2"></i> Duplicar Presupuesto
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
<script>
    window.addEventListener('DOMContentLoaded', event => {
        const dataTable = new simpleDatatables.DataTable("#datatablesSimple", {
            labels: {
                placeholder: "Buscar...",
                perPage: "{select} registros por página",
                noRows: "No se encontraron registros",
                info: "Mostrando {start} a {end} de {rows} registros",
            }
        });
    });

    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function() {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            Toast.fire({
                icon: 'success',
                title: 'URL copiada al portapapeles'
            });
        }, function(err) {
            console.error('Could not copy text: ', err);
        });
    }
</script>
@endpush
