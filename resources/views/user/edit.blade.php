@extends('layouts.app')
@section('title','Editar Usuario')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<style>
    body { font-family: 'DM Sans', sans-serif; background: #f8fafc; }

    .pv-page-header { display: flex; align-items: center; gap: 12px; margin-bottom: 28px; }
    .pv-page-header a {
        width: 36px; height: 36px; border-radius: 8px;
        border: 1px solid #E4E7EF; background: #fff;
        display: flex; align-items: center; justify-content: center;
        color: #64748b; text-decoration: none; transition: all .15s;
    }
    .pv-page-header a:hover { border-color: #3B82F6; color: #3B82F6; }
    .pv-page-header h2 { margin: 0; font-family: 'Syne', sans-serif; font-size: 1.4rem; font-weight: 800; color: #0E1117; }

    .pv-card { background: #fff; border-radius: 12px; border: 1px solid #E4E7EF; overflow: hidden; margin-bottom: 20px; }
    .pv-card-header { background: #0E1117; padding: 14px 22px; display: flex; align-items: center; gap: 12px; }
    .pv-card-header-num {
        width: 28px; height: 28px; border-raZdius: 50%;
        background: linear-gradient(135deg, #3B82F6, #6366F1);
        color: #fff; font-family: 'Syne', sans-serif; font-size: .8rem; font-weight: 700;
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .pv-card-header-title { font-family: 'Syne', sans-serif; font-size: .9rem; font-weight: 600; color: rgba(255,255,255,.9); margin: 0; }
    .pv-card-body { padding: 22px; }

    .pv-field { border: 1.5px solid #E4E7EF; border-radius: 10px; overflow: hidden; transition: border-color .15s; background: #fff; }
    .pv-field:focus-within { border-color: #3B82F6; }
    .pv-field label { display: block; font-family: 'Syne', sans-serif; font-size: .65rem; font-weight: 700; letter-spacing: .06em; text-transform: uppercase; color: #64748b; padding: 8px 14px 0; margin: 0; cursor: text; }
    .pv-field input,
    .pv-field select { display: block; width: 100%; border: none !important; outline: none !important; box-shadow: none !important; padding: 3px 14px 9px; font-family: 'DM Sans', sans-serif; font-size: .9rem; color: #1e293b; background: transparent; }
    .pv-field select { cursor: pointer; }
    .pv-field.is-invalid { border-color: #ef4444; }
    .invalid-feedback { font-size: .8rem; color: #ef4444; margin-top: 4px; display: block; }

    .pv-info-box { background: linear-gradient(135deg, rgba(59,130,246,.06), rgba(99,102,241,.06)); border: 1px solid rgba(99,102,241,.2); border-radius: 10px; padding: 12px 16px; font-size: .82rem; color: #64748b; font-family: 'DM Sans', sans-serif; margin-bottom: 20px; }
    .pv-info-box strong { font-family: 'Syne', sans-serif; color: #6366F1; }

    .btn-receipt { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border: 1.5px solid #3B82F6; border-radius: 8px; color: #3B82F6; font-family: 'Syne', sans-serif; font-size: .8rem; font-weight: 600; text-decoration: none; transition: all .15s; }
    .btn-receipt:hover { background: #3B82F6; color: #fff; }

    .btn-pv-save { background: linear-gradient(135deg, #10B981, #059669); color: #fff; border: none; border-radius: 10px; padding: 11px 32px; font-family: 'Syne', sans-serif; font-weight: 700; font-size: .88rem; transition: opacity .15s, transform .1s; cursor: pointer; }
    .btn-pv-save:hover { opacity: .9; transform: translateY(-1px); color: #fff; }
    .btn-pv-cancel { background: transparent; color: #64748b; border: 1.5px solid #E4E7EF; border-radius: 10px; padding: 10px 22px; font-family: 'Syne', sans-serif; font-weight: 600; font-size: .88rem; transition: all .15s; text-decoration: none; display: inline-flex; align-items: center; }
    .btn-pv-cancel:hover { border-color: #64748b; color: #1e293b; }

    .pv-form-footer { display: flex; justify-content: flex-end; align-items: center; gap: 12px; padding: 18px 22px; border-top: 1px solid #E4E7EF; background: #f8fafc; }
</style>
@endpush

@section('content')
<div class="container-fluid px-4 py-4">

    <div class="pv-page-header">
        <a href="{{ route('users.index') }}" title="Volver">&#8592;</a>
        <h2>Editar Usuario</h2>
    </div>

    <form action="{{ route('users.update', ['user' => $user]) }}" method="POST">
        @csrf
        @method('PATCH')

        {{-- Datos de acceso --}}
        <div class="pv-card">
            <div class="pv-card-header">
                <div class="pv-card-header-num">1</div>
                <p class="pv-card-header-title">Datos de acceso</p>
            </div>
            <div class="pv-card-body">
                <div class="row g-3">

                    <div class="col-md-6">
                        <div class="pv-field @error('empleado_id') is-invalid @enderror">
                            <label for="empleado_id">Empleado vinculado</label>
                            <select name="empleado_id" id="empleado_id">
                                <option value="">— Sin empleado —</option>
                                @foreach ($empleados as $item)
                                <option value="{{ $item->id }}" @selected(old('empleado_id', $user->empleado_id) == $item->id)>
                                    {{ $item->razon_social }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        @error('empleado_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <div class="pv-field @error('role') is-invalid @enderror">
                            <label for="role">Rol del sistema</label>
                            <select name="role" id="role">
                                <option value="">— Sin rol —</option>
                                @foreach ($roles as $item)
                                <option value="{{ $item->name }}"
                                    @selected(in_array($item->name, $user->roles->pluck('name')->toArray()) || old('role') == $item->name)>
                                    {{ $item->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <div class="pv-field @error('name') is-invalid @enderror">
                            <label for="name">Nombre</label>
                            <input type="text" id="name" name="name"
                                   value="{{ old('name', $user->name) }}" placeholder="Nombre del usuario">
                        </div>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <div class="pv-field @error('email') is-invalid @enderror">
                            <label for="email">Correo electrónico</label>
                            <input type="email" id="email" name="email"
                                   value="{{ old('email', $user->email) }}" placeholder="correo@ejemplo.com">
                        </div>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                </div>
            </div>
        </div>

        {{-- Contraseña --}}
        <div class="pv-card">
            <div class="pv-card-header">
                <div class="pv-card-header-num">2</div>
                <p class="pv-card-header-title">Contraseña</p>
            </div>
            <div class="pv-card-body">
                <div class="pv-info-box">
                    <strong>Opcional</strong> — Deja estos campos vacíos si no deseas cambiar la contraseña actual.
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="pv-field @error('password') is-invalid @enderror">
                            <label for="password">Nueva contraseña</label>
                            <input type="password" id="password" name="password" placeholder="Mínimo 8 caracteres">
                        </div>
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <div class="pv-field @error('password_confirm') is-invalid @enderror">
                            <label for="password_confirm">Confirmar contraseña</label>
                            <input type="password" id="password_confirm" name="password_confirm" placeholder="Repite la contraseña">
                        </div>
                        @error('password_confirm')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Estado --}}
        <div class="pv-card">
            <div class="pv-card-header">
                <div class="pv-card-header-num">3</div>
                <p class="pv-card-header-title">Estado y aprobación</p>
            </div>
            <div class="pv-card-body">
                <div class="row g-3">

                    <div class="col-md-4">
                        <div class="pv-field @error('estado') is-invalid @enderror">
                            <label for="estado">Estado en el sistema</label>
                            <select name="estado" id="estado">
                                <option value="1" @selected(old('estado', $user->estado) == 1)>Activo</option>
                                <option value="0" @selected(old('estado', $user->estado) == 0)>Inactivo</option>
                            </select>
                        </div>
                        @error('estado')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-4">
                        <div class="pv-field @error('status') is-invalid @enderror">
                            <label for="status">Aprobación de registro</label>
                            <select name="status" id="status">
                                <option value="pending"  @selected(old('status', $user->status) == 'pending')>Pendiente</option>
                                <option value="active"   @selected(old('status', $user->status) == 'active')>Activo (Aprobado)</option>
                                <option value="rejected" @selected(old('status', $user->status) == 'rejected')>Rechazado</option>
                            </select>
                        </div>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    @if($user->payment_receipt)
                    <div class="col-md-4 d-flex align-items-end">
                        <div>
                            <p style="font-family:'Syne',sans-serif;font-size:.65rem;font-weight:700;letter-spacing:.06em;text-transform:uppercase;color:#9CA3AF;margin-bottom:8px;">
                                Comprobante adjunto
                            </p>
                            <a href="{{ route('admin.users.receipt', $user) }}" target="_blank" class="btn-receipt">
                                <i class="bi bi-file-earmark-text"></i> Ver documento
                            </a>
                        </div>
                    </div>
                    @endif

                </div>
            </div>
        </div>

        <div class="pv-card" style="margin-top:-1px;">
            <div class="pv-form-footer">
                <a href="{{ route('users.index') }}" class="btn-pv-cancel">Cancelar</a>
                <button type="submit" class="btn-pv-save">Guardar cambios</button>
            </div>
        </div>

    </form>
</div>
@endsection