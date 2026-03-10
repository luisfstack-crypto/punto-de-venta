@extends('layouts.app')
@section('title', 'Nuevo Producto')

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

    .pv-steps { display: flex; gap: 8px; margin-bottom: 28px; }
    .pv-step {
        display: flex; align-items: center; gap: 10px;
        padding: 10px 18px; border-radius: 10px;
        border: 1.5px solid var(--pv-border); background: #fff;
        flex: 1; text-decoration: none;
    }
    .pv-step.active {
        border-color: var(--pv-blue);
        background: linear-gradient(135deg, rgba(59,130,246,.07), rgba(99,102,241,.07));
    }
    .pv-step-num {
        width: 26px; height: 26px; border-radius: 50%;
        background: linear-gradient(135deg, #3B82F6, #6366F1);
        color: #fff; font-family: 'Syne', sans-serif;
        font-size: .75rem; font-weight: 700;
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .pv-step:not(.active) .pv-step-num { background: #e2e8f0; color: var(--pv-muted); }
    .pv-step-label { font-family: 'Syne', sans-serif; font-size: .8rem; font-weight: 600; color: var(--pv-text); line-height: 1.2; }
    .pv-step-sub { font-size: .7rem; color: var(--pv-muted); font-weight: 400; font-family: 'DM Sans', sans-serif; }

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
    .pv-field textarea { resize: vertical; min-height: 80px; }
    .pv-field.is-invalid { border-color: #ef4444; }
    .invalid-feedback { font-size: .8rem; color: #ef4444; margin-top: 4px; }

    .pv-section-label {
        font-family: 'Syne', sans-serif; font-size: .72rem; font-weight: 700;
        letter-spacing: .08em; text-transform: uppercase; color: var(--pv-muted);
        margin: 0 0 14px; padding-bottom: 8px; border-bottom: 1px solid var(--pv-border);
    }

    /* Toggle facturable */
    .pv-toggle-card {
        border: 1.5px solid var(--pv-border); border-radius: 10px;
        padding: 14px 18px; display: flex; align-items: center;
        justify-content: space-between; cursor: pointer;
        transition: border-color .2s, background .2s; background: #fff; margin-bottom: 20px;
    }
    .pv-toggle-card.active {
        border-color: var(--pv-blue);
        background: linear-gradient(135deg, rgba(59,130,246,.05), rgba(99,102,241,.05));
    }
    .pv-toggle-label { font-family: 'Syne', sans-serif; font-size: .9rem; font-weight: 600; color: var(--pv-text); }
    .pv-toggle-sub   { font-size: .78rem; color: var(--pv-muted); margin-top: 2px; }
    .form-check-input { width: 2.6em !important; height: 1.3em !important; cursor: pointer; }
    .form-check-input:checked { background-color: var(--pv-blue) !important; border-color: var(--pv-blue) !important; }

    #seccion-sat { display: none; }
    #seccion-sat.show { display: block; animation: fadeIn .25s ease; }
    @keyframes fadeIn { from { opacity:0; transform:translateY(-6px); } to { opacity:1; transform:translateY(0); } }

    /* Imagen de producto */
    .pv-img-upload {
        border: 2px dashed var(--pv-border); border-radius: 12px;
        padding: 28px; text-align: center; cursor: pointer;
        transition: border-color .2s; position: relative;
        background: #fafafa;
    }
    .pv-img-upload:hover { border-color: var(--pv-blue); }
    .pv-img-upload input[type="file"] { position: absolute; inset: 0; opacity: 0; cursor: pointer; }
    .pv-img-upload-label { font-family: 'Syne', sans-serif; font-size: .85rem; font-weight: 600; color: var(--pv-muted); }
    .pv-img-upload-sub   { font-size: .75rem; color: var(--pv-muted); margin-top: 4px; }
    #img-preview { max-width: 100%; max-height: 140px; border-radius: 8px; display: none; margin-top: 12px; }

    /* Precio badge */
    .pv-precio-prefix {
        font-family: 'Syne', sans-serif; font-size: .9rem; font-weight: 700;
        color: var(--pv-muted); padding: 0 0 9px 14px; align-self: flex-end;
        line-height: 1;
    }
    .pv-field-precio { display: flex; align-items: flex-end; }
    .pv-field-precio input { padding-left: 4px; }

    /* Info SAT pill */
    .pv-sat-info {
        background: linear-gradient(135deg, rgba(59,130,246,.06), rgba(99,102,241,.06));
        border: 1px solid rgba(99,102,241,.2);
        border-radius: 10px; padding: 12px 16px;
        margin-bottom: 18px;
        font-size: .8rem; color: var(--pv-muted);
        font-family: 'DM Sans', sans-serif;
    }
    .pv-sat-info strong { font-family: 'Syne', sans-serif; color: var(--pv-indigo); }

    /* Botones */
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
        <a href="{{ route('productos.index') }}" title="Volver">&#8592;</a>
        <h2>Nuevo Producto</h2>
    </div>

    {{-- Barra de pasos --}}
    <div class="pv-steps">
        <div class="pv-step active">
            <div class="pv-step-num">1</div>
            <div>
                <div class="pv-step-label">Datos generales</div>
                <div class="pv-step-sub">Nombre, precio y categoría</div>
            </div>
        </div>
        <div class="pv-step active">
            <div class="pv-step-num">2</div>
            <div>
                <div class="pv-step-label">Datos fiscales SAT</div>
                <div class="pv-step-sub">Clave, unidad y tasa</div>
            </div>
        </div>
    </div>

    <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data" id="form-producto">
        @csrf

        {{-- ── SECCIÓN 1: Datos generales ── --}}
        <div class="pv-card">
            <div class="pv-card-header">
                <div class="pv-card-header-num">1</div>
                <p class="pv-card-header-title">Datos generales</p>
            </div>
            <div class="pv-card-body">
                <div class="row g-3">
                    {{-- Nombre --}}
                    <div class="col-md-6">
                        <div class="pv-field @error('nombre') is-invalid @enderror">
                            <label for="nombre">Nombre del producto *</label>
                            <input type="text" id="nombre" name="nombre"
                                   value="{{ old('nombre') }}" placeholder="Ej: Laptop Dell Inspiron">
                        </div>
                        @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Código --}}
                    <div class="col-md-3">
                        <div class="pv-field">
                            <label for="codigo">Código interno</label>
                            <input type="text" id="codigo" name="codigo"
                                   value="{{ old('codigo') }}" placeholder="Autogenerado si se deja vacío">
                        </div>
                    </div>

                    {{-- Precio --}}
                    <div class="col-md-3">
                        <div class="pv-field @error('precio') is-invalid @enderror pv-field-precio">
                            <label for="precio">Precio de venta *</label>
                            <div style="display:flex; align-items:flex-end;">
                                <span class="pv-precio-prefix">$</span>
                                <input type="number" id="precio" name="precio"
                                       value="{{ old('precio') }}" placeholder="0.00"
                                       step="0.01" min="0" style="padding-left:4px;">
                            </div>
                        </div>
                        @error('precio')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Descripción --}}
                    <div class="col-md-12">
                        <div class="pv-field">
                            <label for="descripcion">Descripción</label>
                            <textarea id="descripcion" name="descripcion" placeholder="Descripción breve del producto...">{{ old('descripcion') }}</textarea>
                        </div>
                    </div>

                    {{-- Categoría --}}
                    <div class="col-md-4">
                        <div class="pv-field @error('categoria_id') is-invalid @enderror">
                            <label for="categoria_id">Categoría</label>
                            <select id="categoria_id" name="categoria_id">
                                <option value="">— Sin categoría —</option>
                                @foreach ($categorias as $cat)
                                    <option value="{{ $cat->id }}" {{ old('categoria_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('categoria_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Marca --}}
                    <div class="col-md-4">
                        <div class="pv-field @error('marca_id') is-invalid @enderror">
                            <label for="marca_id">Marca</label>
                            <select id="marca_id" name="marca_id">
                                <option value="">— Sin marca —</option>
                                @foreach ($marcas as $marca)
                                    <option value="{{ $marca->id }}" {{ old('marca_id') == $marca->id ? 'selected' : '' }}>
                                        {{ $marca->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('marca_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Presentación --}}
                    <div class="col-md-4">
                        <div class="pv-field @error('presentacione_id') is-invalid @enderror">
                            <label for="presentacione_id">Presentación *</label>
                            <select id="presentacione_id" name="presentacione_id">
                                <option value="">— Seleccionar —</option>
                                @foreach ($presentaciones as $pres)
                                    <option value="{{ $pres->id }}" {{ old('presentacione_id') == $pres->id ? 'selected' : '' }}>
                                        {{ $pres->nombre }} ({{ $pres->sigla }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('presentacione_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Imagen --}}
                    <div class="col-md-12">
                        <p class="pv-section-label" style="margin-top:8px;">Imagen del producto</p>
                        <div class="pv-img-upload" id="drop-zone">
                            <input type="file" name="imagen" id="imagen" accept="image/*">
                            <div class="pv-img-upload-label">Arrastra una imagen o haz clic para seleccionar</div>
                            <div class="pv-img-upload-sub">PNG, JPG o WEBP — máx. 2 MB</div>
                            <img id="img-preview" src="" alt="Vista previa">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── SECCIÓN 2: Datos fiscales SAT ── --}}
        <div class="pv-card">
            <div class="pv-card-header">
                <div class="pv-card-header-num">2</div>
                <p class="pv-card-header-title">Datos fiscales SAT</p>
            </div>
            <div class="pv-card-body">

                {{-- Toggle facturable --}}
                <div class="pv-toggle-card" id="toggle-facturable-card">
                    <div>
                        <div class="pv-toggle-label">Facturable</div>
                        <div class="pv-toggle-sub">Este producto aparecerá en comprobantes fiscales digitales (CFDI)</div>
                    </div>
                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input" type="checkbox" role="switch"
                               id="facturable" name="facturable" value="1"
                               {{ old('facturable') ? 'checked' : '' }}>
                    </div>
                </div>

                {{-- Sección SAT colapsable --}}
                <div id="seccion-sat" class="{{ old('facturable') ? 'show' : '' }}">

                    <div class="pv-sat-info">
                        <strong>Catálogos SAT</strong> — Los valores de clave de producto/servicio y clave de unidad
                        deben coincidir con los catálogos oficiales del SAT para la emisión de CFDI 4.0.
                        Consulta el catálogo en <strong>sat.gob.mx</strong>.
                    </div>

                    <div class="row g-3">
                        {{-- Clave producto SAT --}}
                        <div class="col-md-5">
                            <div class="pv-field @error('clave_producto_sat') is-invalid @enderror">
                                <label for="clave_producto_sat">Clave de producto / servicio (SAT) *</label>
                                <input type="text" id="clave_producto_sat" name="clave_producto_sat"
                                       value="{{ old('clave_producto_sat') }}"
                                       placeholder="Ej: 43211507 (Laptops)"
                                       maxlength="20">
                            </div>
                            @error('clave_producto_sat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- Código interno --}}
                        <div class="col-md-3">
                            <div class="pv-field">
                                <label for="codigo_interno">Código interno</label>
                                <input type="text" id="codigo_interno" name="codigo_interno"
                                       value="{{ old('codigo_interno') }}" placeholder="Tu referencia interna">
                            </div>
                        </div>

                        {{-- Tasa o cuota --}}
                        <div class="col-md-4">
                            <div class="pv-field @error('tasa_cuota') is-invalid @enderror">
                                <label for="tasa_cuota">Tasa o cuota *</label>
                                <select id="tasa_cuota" name="tasa_cuota">
                                    <option value="">— Seleccionar —</option>
                                    <option value="0.160000" {{ old('tasa_cuota')=='0.160000' ? 'selected' : '' }}>IVA 16%</option>
                                    <option value="0.080000" {{ old('tasa_cuota')=='0.080000' ? 'selected' : '' }}>IVA 8% (zona fronteriza)</option>
                                    <option value="0.000000" {{ old('tasa_cuota')=='0.000000' ? 'selected' : '' }}>Tasa 0%</option>
                                    <option value="Exento"   {{ old('tasa_cuota')=='Exento'   ? 'selected' : '' }}>Exento</option>
                                </select>
                            </div>
                            @error('tasa_cuota')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- Unidad de medida --}}
                        <div class="col-md-6">
                            <div class="pv-field @error('unidad_medida') is-invalid @enderror">
                                <label for="unidad_medida">Unidad de medida *</label>
                                <select id="unidad_medida" name="unidad_medida">
                                    <option value="">— Seleccionar —</option>
                                    <option value="Pieza"      {{ old('unidad_medida')=='Pieza'      ? 'selected' : '' }}>Pieza</option>
                                    <option value="Kilogramo"  {{ old('unidad_medida')=='Kilogramo'  ? 'selected' : '' }}>Kilogramo</option>
                                    <option value="Litro"      {{ old('unidad_medida')=='Litro'      ? 'selected' : '' }}>Litro</option>
                                    <option value="Metro"      {{ old('unidad_medida')=='Metro'      ? 'selected' : '' }}>Metro</option>
                                    <option value="Caja"       {{ old('unidad_medida')=='Caja'       ? 'selected' : '' }}>Caja</option>
                                    <option value="Servicio"   {{ old('unidad_medida')=='Servicio'   ? 'selected' : '' }}>Servicio</option>
                                    <option value="Hora"       {{ old('unidad_medida')=='Hora'       ? 'selected' : '' }}>Hora</option>
                                    <option value="Paquete"    {{ old('unidad_medida')=='Paquete'    ? 'selected' : '' }}>Paquete</option>
                                </select>
                            </div>
                            @error('unidad_medida')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- Clave unidad SAT --}}
                        <div class="col-md-6">
                            <div class="pv-field @error('clave_unidad_sat') is-invalid @enderror">
                                <label for="clave_unidad_sat">Clave de unidad de medida (SAT) *</label>
                                <select id="clave_unidad_sat" name="clave_unidad_sat">
                                    <option value="">— Seleccionar —</option>
                                    <option value="H87" {{ old('clave_unidad_sat')=='H87' ? 'selected' : '' }}>H87 – Pieza</option>
                                    <option value="KGM" {{ old('clave_unidad_sat')=='KGM' ? 'selected' : '' }}>KGM – Kilogramo</option>
                                    <option value="LTR" {{ old('clave_unidad_sat')=='LTR' ? 'selected' : '' }}>LTR – Litro</option>
                                    <option value="MTR" {{ old('clave_unidad_sat')=='MTR' ? 'selected' : '' }}>MTR – Metro</option>
                                    <option value="XBX" {{ old('clave_unidad_sat')=='XBX' ? 'selected' : '' }}>XBX – Caja</option>
                                    <option value="E48" {{ old('clave_unidad_sat')=='E48' ? 'selected' : '' }}>E48 – Servicio</option>
                                    <option value="HUR" {{ old('clave_unidad_sat')=='HUR' ? 'selected' : '' }}>HUR – Hora</option>
                                    <option value="XPK" {{ old('clave_unidad_sat')=='XPK' ? 'selected' : '' }}>XPK – Paquete</option>
                                    <option value="ACT" {{ old('clave_unidad_sat')=='ACT' ? 'selected' : '' }}>ACT – Actividad</option>
                                    <option value="GRM" {{ old('clave_unidad_sat')=='GRM' ? 'selected' : '' }}>GRM – Gramo</option>
                                </select>
                            </div>
                            @error('clave_unidad_sat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>{{-- /seccion-sat --}}

            </div>
        </div>

        {{-- Pie del formulario --}}
        <div class="pv-form-footer pv-card" style="margin-top:-1px; border-top: none;">
            <a href="{{ route('productos.index') }}" class="btn-pv-cancel">Cancelar</a>
            <button type="submit" class="btn-pv-save">Guardar producto</button>
        </div>

    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // ── Toggle facturable ──
    const toggle       = document.getElementById('facturable');
    const seccion      = document.getElementById('seccion-sat');
    const toggleCard   = document.getElementById('toggle-facturable-card');

    function actualizarSAT() {
        if (toggle.checked) {
            seccion.classList.add('show');
            toggleCard.classList.add('active');
        } else {
            seccion.classList.remove('show');
            toggleCard.classList.remove('active');
        }
    }

    toggle.addEventListener('change', actualizarSAT);
    actualizarSAT();

    // ── Preview imagen ──
    const inputImg = document.getElementById('imagen');
    const preview  = document.getElementById('img-preview');

    inputImg?.addEventListener('change', function () {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(this.files[0]);
        }
    });

    // ── Sincronizar unidad de medida → clave SAT ──
    const unidadSelect = document.getElementById('unidad_medida');
    const claveSelect  = document.getElementById('clave_unidad_sat');

    const mapaUnidad = {
        'Pieza':     'H87',
        'Kilogramo': 'KGM',
        'Litro':     'LTR',
        'Metro':     'MTR',
        'Caja':      'XBX',
        'Servicio':  'E48',
        'Hora':      'HUR',
        'Paquete':   'XPK',
    };

    unidadSelect?.addEventListener('change', function () {
        const clave = mapaUnidad[this.value];
        if (clave && !claveSelect.value) {
            claveSelect.value = clave;
        }
    });
});
</script>
@endpush