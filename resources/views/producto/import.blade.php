@extends('layouts.app')
@section('title', 'Importar Productos')

@push('styles')
<style>
    :root {
        --pv-blue:   #3B82F6;
        --pv-indigo: #6366F1;
        --pv-green:  #10B981;
        --pv-dark:   #0E1117;
        --pv-border: #E4E7EF;
        --pv-text:   #1e293b;
        --pv-muted:  #64748b;
    }
    body { font-family: 'DM Sans', sans-serif; background: #f8fafc; }

    .pv-page-header { display: flex; align-items: center; gap: 12px; margin-bottom: 28px; }
    .pv-page-header a {
        width: 36px; height: 36px; border-radius: 8px;
        border: 1px solid var(--pv-border); background: #fff;
        display: flex; align-items: center; justify-content: center;
        color: var(--pv-muted); text-decoration: none; transition: all .15s;
    }
    .pv-page-header a:hover { border-color: var(--pv-blue); color: var(--pv-blue); }
    .pv-page-header h2 { margin: 0; font-family: 'Syne', sans-serif; font-size: 1.35rem; font-weight: 700; color: var(--pv-dark); }

    .pv-card { background: #fff; border-radius: 12px; border: 1px solid var(--pv-border); overflow: hidden; margin-bottom: 20px; }
    .pv-card-header { background: var(--pv-dark); padding: 14px 22px; display: flex; align-items: center; gap: 12px; }
    .pv-card-header-num {
        width: 28px; height: 28px; border-radius: 50%;
        background: linear-gradient(135deg, #3B82F6, #6366F1);
        color: #fff; font-family: 'Syne', sans-serif; font-size: .8rem; font-weight: 700;
        display: flex; align-items: center; justify-content: center;
    }
    .pv-card-header-title { font-family: 'Syne', sans-serif; font-size: .9rem; font-weight: 600; color: rgba(255,255,255,.9); margin: 0; }
    .pv-card-body { padding: 24px; }

    /* Opciones de método */
    .pv-method-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; margin-bottom: 28px; }
    .pv-method-option { display: none; }
    .pv-method-label {
        border: 1.5px solid var(--pv-border); border-radius: 12px;
        padding: 20px 16px; text-align: center; cursor: pointer;
        transition: all .2s; background: #fff; display: block;
    }
    .pv-method-label:hover { border-color: var(--pv-blue); }
    .pv-method-option:checked + .pv-method-label {
        border-color: var(--pv-blue);
        background: linear-gradient(135deg, rgba(59,130,246,.07), rgba(99,102,241,.07));
    }
    .pv-method-icon { font-size: 1.8rem; margin-bottom: 8px; }
    .pv-method-name { font-family: 'Syne', sans-serif; font-size: .88rem; font-weight: 700; color: var(--pv-text); }
    .pv-method-desc { font-size: .75rem; color: var(--pv-muted); margin-top: 3px; }
    .pv-method-badge {
        display: inline-block; font-size: .65rem; font-weight: 700; letter-spacing: .05em;
        text-transform: uppercase; background: linear-gradient(135deg, #3B82F6, #6366F1);
        color: #fff; padding: 2px 7px; border-radius: 20px; margin-top: 6px;
    }

    /* Upload zone */
    .pv-upload-zone {
        border: 2px dashed var(--pv-border); border-radius: 12px;
        padding: 40px 24px; text-align: center; cursor: pointer;
        transition: border-color .2s, background .2s; background: #fafafa;
        position: relative;
    }
    .pv-upload-zone:hover, .pv-upload-zone.drag-over { border-color: var(--pv-blue); background: rgba(59,130,246,.03); }
    .pv-upload-zone input[type="file"] { position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%; }
    .pv-upload-title { font-family: 'Syne', sans-serif; font-size: 1rem; font-weight: 700; color: var(--pv-text); margin-bottom: 6px; }
    .pv-upload-sub { font-size: .82rem; color: var(--pv-muted); }
    .pv-upload-selected { margin-top: 12px; font-family: 'Syne', sans-serif; font-size: .85rem; font-weight: 600; color: var(--pv-blue); display: none; }

    /* Plantilla */
    .pv-template-bar {
        display: flex; align-items: center; justify-content: space-between;
        background: linear-gradient(135deg, rgba(59,130,246,.06), rgba(99,102,241,.06));
        border: 1px solid rgba(99,102,241,.2); border-radius: 10px;
        padding: 14px 18px; margin-bottom: 24px;
    }
    .pv-template-text { font-family: 'Syne', sans-serif; font-size: .85rem; font-weight: 600; color: var(--pv-text); }
    .pv-template-sub  { font-size: .75rem; color: var(--pv-muted); margin-top: 2px; }

    /* Columnas tabla */
    .pv-columns-table { width: 100%; border-collapse: collapse; font-size: .82rem; }
    .pv-columns-table th { font-family: 'Syne', sans-serif; font-size: .7rem; text-transform: uppercase; letter-spacing: .06em; color: rgba(255,255,255,.55); background: var(--pv-dark); padding: 10px 14px; text-align: left; }
    .pv-columns-table td { padding: 10px 14px; border-bottom: 1px solid var(--pv-border); color: var(--pv-text); }
    .pv-columns-table tr:last-child td { border-bottom: none; }
    .badge-req  { background: #fee2e2; color: #dc2626; font-size: .68rem; font-weight: 700; padding: 2px 8px; border-radius: 20px; font-family: 'Syne', sans-serif; }
    .badge-opt  { background: #f1f5f9; color: var(--pv-muted); font-size: .68rem; font-weight: 700; padding: 2px 8px; border-radius: 20px; font-family: 'Syne', sans-serif; }

    /* Botones */
    .btn-pv-save {
        background: linear-gradient(135deg, #10B981, #059669); color: #fff; border: none;
        border-radius: 10px; padding: 11px 32px; font-family: 'Syne', sans-serif;
        font-weight: 700; font-size: .88rem; transition: opacity .15s, transform .1s; cursor: pointer;
    }
    .btn-pv-save:hover { opacity: .9; transform: translateY(-1px); color: #fff; }
    .btn-pv-cancel {
        background: transparent; color: var(--pv-muted); border: 1.5px solid var(--pv-border);
        border-radius: 10px; padding: 10px 22px; font-family: 'Syne', sans-serif;
        font-weight: 600; font-size: .88rem; transition: all .15s; text-decoration: none;
        display: inline-flex; align-items: center;
    }
    .btn-pv-cancel:hover { border-color: var(--pv-muted); color: var(--pv-text); }
    .btn-pv-outline {
        background: transparent; color: var(--pv-blue); border: 1.5px solid var(--pv-blue);
        border-radius: 10px; padding: 8px 18px; font-family: 'Syne', sans-serif;
        font-weight: 600; font-size: .82rem; transition: all .15s; text-decoration: none;
        display: inline-flex; align-items: center; gap: 6px;
    }
    .btn-pv-outline:hover { background: var(--pv-blue); color: #fff; }
    .pv-form-footer { display: flex; justify-content: flex-end; gap: 12px; padding: 18px 24px; border-top: 1px solid var(--pv-border); background: #f8fafc; }
</style>
@endpush

@section('content')
<div class="container-fluid px-4 py-4">

    <div class="pv-page-header">
        <a href="{{ route('productos.index') }}" title="Volver">&#8592;</a>
        <h2>Importar Productos</h2>
    </div>

    {{-- Alertas --}}
    @if(session('success'))
        <div class="alert alert-success border-0 rounded-3 mb-4">{{ session('success') }}</div>
    @endif
    @if(session('warning'))
        <div class="alert alert-warning border-0 rounded-3 mb-4">{{ session('warning') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger border-0 rounded-3 mb-4">{{ session('error') }}</div>
    @endif

    <form action="{{ route('productos.import.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- ── Selección de método ── --}}
        <div class="pv-card">
            <div class="pv-card-header">
                <div class="pv-card-header-num">1</div>
                <p class="pv-card-header-title">Elige cómo agregar tus productos</p>
            </div>
            <div class="pv-card-body">
                <div class="pv-method-grid">
                    {{-- Individual --}}
                    <div>
                        <a href="{{ route('productos.create') }}" class="pv-method-label" style="text-decoration:none;">
                            <div class="pv-method-icon">🗂️</div>
                            <div class="pv-method-name">Individualmente</div>
                            <div class="pv-method-desc">Agrega un producto a la vez de forma manual</div>
                        </a>
                    </div>

                    {{-- Excel masivo --}}
                    <div>
                        <input class="pv-method-option" type="radio" name="_metodo" id="metodo_excel" value="excel" checked>
                        <label class="pv-method-label" for="metodo_excel">
                            <div class="pv-method-icon">📊</div>
                            <div class="pv-method-name">Con una planilla</div>
                            <div class="pv-method-desc">Descarga una plantilla modelo y sube varios productos a la vez</div>
                            <span class="pv-method-badge">Seleccionado</span>
                        </label>
                    </div>

                    {{-- XML (beta) --}}
                    <div>
                        <label class="pv-method-label" style="opacity:.5; cursor:not-allowed;">
                            <div class="pv-method-icon">🧾</div>
                            <div class="pv-method-name">Con XML de facturas</div>
                            <div class="pv-method-desc">Agregue o actualice sus productos con el XML de facturas</div>
                            <span class="pv-method-badge" style="background:#94a3b8;">Próximamente</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Plantilla y columnas ── --}}
        <div class="pv-card">
            <div class="pv-card-header">
                <div class="pv-card-header-num">2</div>
                <p class="pv-card-header-title">Descarga la plantilla y llénala</p>
            </div>
            <div class="pv-card-body">

                <div class="pv-template-bar">
                    <div>
                        <div class="pv-template-text">Plantilla de productos (.xlsx)</div>
                        <div class="pv-template-sub">Incluye todos los campos necesarios con una fila de ejemplo</div>
                    </div>
                    <a href="{{ route('productos.import.template') }}" class="btn-pv-outline">
                        &#8595; Descargar plantilla
                    </a>
                </div>

                <p style="font-family:'Syne',sans-serif; font-size:.72rem; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:var(--pv-muted); margin-bottom:12px;">
                    Columnas del archivo
                </p>

                <table class="pv-columns-table">
                    <thead>
                        <tr>
                            <th>Columna</th>
                            <th>Descripción</th>
                            <th>Tipo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td><code>nombre</code></td><td>Nombre del producto</td><td><span class="badge-req">Requerido</span></td></tr>
                        <tr><td><code>precio</code></td><td>Precio de venta (número decimal)</td><td><span class="badge-req">Requerido</span></td></tr>
                        <tr><td><code>descripcion</code></td><td>Descripción del producto</td><td><span class="badge-opt">Opcional</span></td></tr>
                        <tr><td><code>codigo</code></td><td>Código interno (se autogenera si se deja vacío)</td><td><span class="badge-opt">Opcional</span></td></tr>
                        <tr><td><code>categoria</code></td><td>Nombre exacto de la categoría</td><td><span class="badge-opt">Opcional</span></td></tr>
                        <tr><td><code>marca</code></td><td>Nombre exacto de la marca</td><td><span class="badge-opt">Opcional</span></td></tr>
                        <tr><td><code>presentacion</code></td><td>Nombre de la presentación (usa la primera si se omite)</td><td><span class="badge-opt">Opcional</span></td></tr>
                        <tr><td><code>facturable</code></td><td>Escribe <strong>si</strong> si genera CFDI</td><td><span class="badge-opt">Opcional</span></td></tr>
                        <tr><td><code>clave_producto_sat</code></td><td>Clave SAT del producto/servicio</td><td><span class="badge-opt">Opcional</span></td></tr>
                        <tr><td><code>clave_unidad_sat</code></td><td>Clave SAT de unidad (H87, KGM…)</td><td><span class="badge-opt">Opcional</span></td></tr>
                        <tr><td><code>unidad_medida</code></td><td>Nombre de unidad (Pieza, Kilogramo…)</td><td><span class="badge-opt">Opcional</span></td></tr>
                        <tr><td><code>tasa_cuota</code></td><td>0.160000 / 0.000000 / Exento</td><td><span class="badge-opt">Opcional</span></td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ── Subir archivo ── --}}
        <div class="pv-card">
            <div class="pv-card-header">
                <div class="pv-card-header-num">3</div>
                <p class="pv-card-header-title">Sube tu archivo</p>
            </div>
            <div class="pv-card-body">
                <div class="pv-upload-zone" id="upload-zone">
                    <input type="file" name="archivo" id="archivo" accept=".xlsx,.xls,.csv">
                    <div class="pv-upload-title">Arrastra tu archivo aquí o haz clic para seleccionar</div>
                    <div class="pv-upload-sub">Formatos aceptados: .xlsx, .xls, .csv — máx. 5 MB</div>
                    <div class="pv-upload-selected" id="upload-filename"></div>
                </div>
                @error('archivo')
                    <div class="text-danger mt-2" style="font-size:.82rem;">{{ $message }}</div>
                @enderror
            </div>
            <div class="pv-form-footer">
                <a href="{{ route('productos.index') }}" class="btn-pv-cancel">Cancelar</a>
                <button type="submit" class="btn-pv-save" id="btn-importar" disabled>
                    Importar productos
                </button>
            </div>
        </div>

    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input    = document.getElementById('archivo');
    const filename = document.getElementById('upload-filename');
    const btnImport= document.getElementById('btn-importar');
    const zone     = document.getElementById('upload-zone');

    input.addEventListener('change', function () {
        if (this.files && this.files[0]) {
            filename.textContent = '✓ ' + this.files[0].name;
            filename.style.display = 'block';
            btnImport.removeAttribute('disabled');
        }
    });

    // Drag & drop
    zone.addEventListener('dragover',  e => { e.preventDefault(); zone.classList.add('drag-over'); });
    zone.addEventListener('dragleave', () => zone.classList.remove('drag-over'));
    zone.addEventListener('drop', e => {
        e.preventDefault();
        zone.classList.remove('drag-over');
        if (e.dataTransfer.files.length) {
            input.files = e.dataTransfer.files;
            filename.textContent = '✓ ' + e.dataTransfer.files[0].name;
            filename.style.display = 'block';
            btnImport.removeAttribute('disabled');
        }
    });
});
</script>
@endpush
