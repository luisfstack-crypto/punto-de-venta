@extends('layouts.app')
@section('title', 'Nueva Categoría')

@push('styles')
<style>
    :root {
        --pv-blue:    #3B82F6;
        --pv-indigo:  #6366F1;
        --pv-green:   #10B981;
        --pv-dark:    #0E1117;
        --pv-card-bg: #ffffff;
        --pv-border:  #E4E7EF;
        --pv-text:    #1e293b;
        --pv-muted:   #64748b;
    }

    body { font-family: 'DM Sans', sans-serif; background: #f8fafc; }

    .pv-page-header {
        display: flex; align-items: center; gap: 12px; margin-bottom: 28px;
    }
    .pv-page-header a {
        width: 36px; height: 36px; border-radius: 8px;
        border: 1px solid var(--pv-border); background: #fff;
        display: flex; align-items: center; justify-content: center;
        color: var(--pv-muted); text-decoration: none; transition: all .15s;
    }
    .pv-page-header a:hover { border-color: var(--pv-blue); color: var(--pv-blue); }
    .pv-page-header h2 {
        margin: 0; font-family: 'Syne', sans-serif;
        font-size: 1.35rem; font-weight: 700; color: var(--pv-dark);
    }

    .pv-card { background: var(--pv-card-bg); border-radius: 12px; border: 1px solid var(--pv-border); overflow: hidden; margin-bottom: 20px; }
    .pv-card-header { background: var(--pv-dark); padding: 14px 22px; display: flex; align-items: center; gap: 12px; }
    .pv-card-header-num {
        width: 28px; height: 28px; border-radius: 50%;
        background: linear-gradient(135deg, #3B82F6, #6366F1);
        color: #fff; font-family: 'Syne', sans-serif;
        font-size: .8rem; font-weight: 700;
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .pv-card-header-title { font-family: 'Syne', sans-serif; font-size: .9rem; font-weight: 600; color: rgba(255,255,255,.9); margin: 0; }
    .pv-card-body { padding: 22px; }

    .pv-field { border: 1.5px solid var(--pv-border); border-radius: 10px; overflow: hidden; transition: border-color .15s; background: #fff; }
    .pv-field:focus-within { border-color: var(--pv-blue); }
    .pv-field label {
        display: block; font-family: 'Syne', sans-serif;
        font-size: .65rem; font-weight: 700;
        letter-spacing: .06em; text-transform: uppercase;
        color: var(--pv-muted); padding: 8px 14px 0; margin: 0; cursor: text;
    }
    .pv-field input,
    .pv-field select,
    .pv-field textarea {
        display: block; width: 100%; border: none !important; outline: none !important;
        box-shadow: none !important; padding: 3px 14px 9px;
        font-family: 'DM Sans', sans-serif; font-size: .9rem;
        color: var(--pv-text); background: transparent;
    }
    .pv-field textarea { resize: vertical; min-height: 100px; }
    .pv-field.is-invalid { border-color: #ef4444; }
    .invalid-feedback { font-size: .8rem; color: #ef4444; margin-top: 4px; display: block; }

    .btn-pv-save {
        background: linear-gradient(135deg, #10B981, #059669);
        color: #fff; border: none; border-radius: 10px;
        padding: 11px 32px; font-family: 'Syne', sans-serif;
        font-weight: 700; font-size: .88rem; letter-spacing: .03em;
        transition: opacity .15s, transform .1s; cursor: pointer;
    }
    .btn-pv-save:hover { opacity: .9; transform: translateY(-1px); color: #fff; }
    .btn-pv-cancel {
        background: transparent; color: var(--pv-muted);
        border: 1.5px solid var(--pv-border); border-radius: 10px;
        padding: 10px 22px; font-family: 'Syne', sans-serif;
        font-weight: 600; font-size: .88rem; transition: all .15s; cursor: pointer; text-decoration: none;
        display: inline-flex; align-items: center;
    }
    .btn-pv-cancel:hover { border-color: var(--pv-muted); color: var(--pv-text); }

    .pv-form-footer {
        display: flex; justify-content: flex-end; align-items: center; gap: 12px;
        padding: 18px 22px; border-top: 1px solid var(--pv-border); background: #f8fafc;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4 py-4">

    <div class="pv-page-header">
        <a href="{{ route('categorias.index') }}" title="Volver">&#8592;</a>
        <h2>Nueva Categoría</h2>
    </div>

    <form action="{{ route('categorias.store') }}" method="POST">
        @csrf

        <div class="pv-card">
            <div class="pv-card-header">
                <div class="pv-card-header-num">1</div>
                <p class="pv-card-header-title">Información de la categoría</p>
            </div>
            <div class="pv-card-body">
                <div class="row g-4">
                    {{-- Nombre --}}
                    <div class="col-md-12">
                        <div class="pv-field @error('nombre') is-invalid @enderror">
                            <label for="nombre">Nombre de la categoría *</label>
                            <input type="text" id="nombre" name="nombre"
                                   value="{{ old('nombre') }}" placeholder="Ej: Electrónicos, Abarrotes...">
                        </div>
                        @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Descripción --}}
                    <div class="col-md-12">
                        <div class="pv-field @error('descripcion') is-invalid @enderror">
                            <label for="descripcion">Descripción</label>
                            <textarea id="descripcion" name="descripcion" placeholder="Breve descripción de los productos que pertenecen a esta categoría...">{{ old('descripcion') }}</textarea>
                        </div>
                        @error('descripcion')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Pie del formulario --}}
        <div class="pv-form-footer pv-card" style="margin-top:-1px; border-top: none;">
            <a href="{{ route('categorias.index') }}" class="btn-pv-cancel">Cancelar</a>
            <button type="submit" class="btn-pv-save">Guardar categoría</button>
        </div>

    </form>
</div>
@endsection