@extends('layouts.app')

@section('title','Usuarios Pendientes')

@push('css-datatable')
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
@endpush

@push('css')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@section('content')

<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Usuarios Pendientes de Aprobación</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item active">Usuarios Pendientes</li>
    </ol>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <i class="fas fa-clock me-1"></i>
            Solicitudes pendientes
        </div>
        <div class="card-body">
            <table id="datatablesSimple" class="table table-striped fs-6">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Estado</th>
                        <th>Comprobante</th>
                        <th>Asignar Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>
                            <span class="badge bg-warning text-dark">Pendiente</span>
                        </td>
                        <td>
                            @if($user->payment_receipt)
                                <a href="{{ route('admin.users.receipt', $user) }}" target="_blank" class="btn btn-sm btn-info text-white">
                                    <i class="fas fa-eye me-1"></i> Ver Documento
                                </a>
                            @else
                                <span class="text-muted">No adjunto</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('admin.users.approve', $user) }}" method="POST" id="approve-form-{{ $user->id }}">
                                @csrf
                                <select name="role" class="form-select form-select-sm" required>
                                    <option value="" selected disabled>Seleccione un rol...</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}">{{ ucfirst(str_replace('_', ' ', $role->name)) }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                        <td>
                            <div class="d-flex justify-content-start">
                                <button type="submit" form="approve-form-{{ $user->id }}" class="btn btn-sm btn-success me-2" title="Aprobar Solicitud">
                                    <i class="fas fa-check me-1"></i> Aprobar
                                </button>

                                <form action="{{ route('admin.users.reject', $user) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger" title="Rechazar Solicitud">
                                        <i class="fas fa-times me-1"></i> Rechazar
                                    </button>
                                </form>
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
<script src="{{ asset('js/datatables-simple-demo.js') }}"></script>
@endpush
