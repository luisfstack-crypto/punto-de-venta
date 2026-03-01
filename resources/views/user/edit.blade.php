@extends('layouts.app')

@section('title','Editar usuario')

@push('css')
@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Editar Usuario</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('users.index')}}">Usuarios</a></li>
        <li class="breadcrumb-item active">Editar Usuario</li>
    </ol>

    <div class="card text-bg-light">
        <form action="{{ route('users.update',['user' => $user]) }}" method="post">
            @method('PATCH')
            @csrf
            <div class="card-header">
                <p class="">Nota: Los usuarios son los que pueden ingresar al sistema</p>
            </div>
            <div class="card-body">

                <!-----Empleado----->
                <div class="row mb-4">
                    <label for="empleado_id" class="col-lg-2 col-form-label">Empleado:</label>
                    <div class="col-lg-4">
                        <select name="empleado_id" id="empleado_id" class="form-select">
                            <option value="">- Sin Empleado -</option>
                            @foreach ($empleados as $item)
                            <option value="{{$item->id}}" @selected(old('empleado_id', $user->empleado_id) == $item->id)>
                                {{$item->razon_social}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-text">Vincular usuario con un empleado</div>
                    </div>
                    <div class="col-lg-2">
                        @error('empleado_id')
                        <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>
                </div>

                <!---Nombre---->
                <div class="row mb-4">
                    <label for="name" class="col-lg-2 col-form-label">
                        Nombres:</label>
                    <div class="col-lg-4">
                        <input type="text"
                            name="name"
                            id="name"
                            class="form-control"
                            value="{{old('name',$user->name)}}">
                    </div>
                    <div class="col-lg-4">
                        <div class="form-text">
                            Escriba un solo nombre
                        </div>
                    </div>
                    <div class="col-lg-2">
                        @error('name')
                        <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>
                </div>

                <!---Email---->
                <div class="row mb-4">
                    <label for="email" class="col-lg-2 col-form-label">
                        Email:</label>
                    <div class="col-lg-4">
                        <input type="email"
                            name="email"
                            id="email"
                            class="form-control"
                            value="{{old('email',$user->email)}}">
                    </div>
                    <div class="col-lg-4">
                        <div class="form-text">
                            Dirección de correo eléctronico
                        </div>
                    </div>
                    <div class="col-lg-2">
                        @error('email')
                        <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>
                </div>

                <!---Password---->
                <div class="row mb-4">
                    <label for="password" class="col-lg-2 col-form-label">
                        Contraseña:</label>
                    <div class="col-lg-4">
                        <input type="password"
                            name="password"
                            id="password"
                            class="form-control">
                    </div>
                    <div class="col-lg-4">
                        <div class="form-text">
                            Escriba una constraseña segura. Debe incluir números.
                        </div>
                    </div>
                    <div class="col-lg-2">
                        @error('password')
                        <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>
                </div>

                <!---Confirm_Password---->
                <div class="row mb-4">
                    <label for="password_confirm" class="col-lg-2 col-form-label">
                        Confirmar:</label>
                    <div class="col-lg-4">
                        <input type="password"
                            name="password_confirm"
                            id="password_confirm"
                            class="form-control">
                    </div>
                    <div class="col-lg-4">
                        <div class="form-text">
                            Vuelva a escribir su contraseña.
                        </div>
                    </div>
                    <div class="col-lg-2">
                        @error('password_confirm')
                        <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>
                </div>

                <!---Roles---->
                <div class="row mb-4">
                    <label for="role" class="col-lg-2 col-form-label">
                        Seleccionar rol:</label>
                    <div class="col-lg-4">
                        <select name="role" id="role" class="form-select">
                            <option value="">- Sin Rol -</option>
                            @foreach ($roles as $item)
                            <option
                                value="{{$item->name}}"
                                @selected(in_array($item->name, $user->roles->pluck('name')->toArray()) || old('role') == $item->name)>
                                {{$item->name}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-text">
                            Escoja un rol para el usuario.
                        </div>
                    </div>
                    <div class="col-lg-2">
                        @error('role')
                        <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>
                </div>

                <!---Estado Sistema---->
                <div class="row mb-4">
                    <label for="estado" class="col-lg-2 col-form-label">Estado (Sistema):</label>
                    <div class="col-lg-4">
                        <select name="estado" id="estado" class="form-select">
                            <option value="1" @selected(old('estado', $user->estado) == 1)>Activo</option>
                            <option value="0" @selected(old('estado', $user->estado) == 0)>Inactivo</option>
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-text">Si está inactivo, no podrá ingresar al sistema bajo ningún motivo.</div>
                    </div>
                    <div class="col-lg-2">
                        @error('estado')
                        <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>
                </div>

                <!---Status de Aprobación---->
                <div class="row mb-4">
                    <label for="status" class="col-lg-2 col-form-label">Aprobación (Registro):</label>
                    <div class="col-lg-4">
                        <select name="status" id="status" class="form-select">
                            <option value="pending" @selected(old('status', $user->status) == 'pending')>Pendiente</option>
                            <option value="active" @selected(old('status', $user->status) == 'active')>Activo (Aprobado)</option>
                            <option value="rejected" @selected(old('status', $user->status) == 'rejected')>Rechazado</option>
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-text">Estado de validación de su registro.</div>
                    </div>
                    <div class="col-lg-2">
                        @error('status')
                        <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>
                </div>

                <!---Comprobante---->
                @if($user->payment_receipt)
                <div class="row mb-4">
                    <label class="col-lg-2 col-form-label">Comprobante Actual:</label>
                    <div class="col-lg-4 d-flex align-items-center">
                        <a href="{{ route('admin.users.receipt', $user) }}" target="_blank" class="btn btn-sm btn-info text-white">
                            <i class="fas fa-eye me-1"></i> Ver Documento
                        </a>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-text">El usuario adjuntó un documento en su registro.</div>
                    </div>
                </div>
                @endif

            </div>
            <div class="card-footer text-center">
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('js')

@endpush