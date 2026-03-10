@extends('layouts.app')
@section('title', 'Nuevo Cliente')

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

    /* ── Encabezado de página ── */
    .pv-page-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 28px;
    }
    .pv-page-header a {
        width: 36px; height: 36px;
        border-radius: 8px;
        border: 1px solid var(--pv-border);
        background: #fff;
        display: flex; align-items: center; justify-content: center;
        color: var(--pv-muted);
        text-decoration: none;
        transition: all .15s;
    }
    .pv-page-header a:hover { border-color: var(--pv-blue); color: var(--pv-blue); }
    .pv-page-header h2 {
        margin: 0;
        font-family: 'Syne', sans-serif;
        font-size: 1.35rem;
        font-weight: 700;
        color: var(--pv-dark);
    }

    /* ── Barra de pasos ── */
    .pv-steps {
        display: flex;
        gap: 8px;
        margin-bottom: 28px;
    }
    .pv-step {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 18px;
        border-radius: 10px;
        border: 1.5px solid var(--pv-border);
        background: #fff;
        cursor: pointer;
        transition: all .2s;
        flex: 1;
        text-decoration: none;
    }
    .pv-step.active {
        border-color: var(--pv-blue);
        background: linear-gradient(135deg, rgba(59,130,246,.07), rgba(99,102,241,.07));
    }
    .pv-step-num {
        width: 26px; height: 26px;
        border-radius: 50%;
        background: linear-gradient(135deg, #3B82F6, #6366F1);
        color: #fff;
        font-family: 'Syne', sans-serif;
        font-size: .75rem;
        font-weight: 700;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .pv-step:not(.active) .pv-step-num {
        background: #e2e8f0;
        color: var(--pv-muted);
    }
    .pv-step-label {
        font-family: 'Syne', sans-serif;
        font-size: .8rem;
        font-weight: 600;
        color: var(--pv-text);
        line-height: 1.2;
    }
    .pv-step-sub {
        font-size: .7rem;
        color: var(--pv-muted);
        font-weight: 400;
        font-family: 'DM Sans', sans-serif;
    }

    /* ── Card ── */
    .pv-card {
        background: var(--pv-card-bg);
        border-radius: 12px;
        border: 1px solid var(--pv-border);
        overflow: hidden;
        margin-bottom: 20px;
    }
    .pv-card-header {
        background: var(--pv-dark);
        padding: 14px 22px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .pv-card-header-num {
        width: 28px; height: 28px;
        border-radius: 50%;
        background: linear-gradient(135deg, #3B82F6, #6366F1);
        color: #fff;
        font-family: 'Syne', sans-serif;
        font-size: .8rem;
        font-weight: 700;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .pv-card-header-title {
        font-family: 'Syne', sans-serif;
        font-size: .9rem;
        font-weight: 600;
        color: rgba(255,255,255,.9);
        margin: 0;
    }
    .pv-card-body { padding: 22px; }

    /* ── Field pill ── */
    .pv-field {
        border: 1.5px solid var(--pv-border);
        border-radius: 10px;
        overflow: hidden;
        transition: border-color .15s;
        background: #fff;
    }
    .pv-field:focus-within { border-color: var(--pv-blue); }
    .pv-field label {
        display: block;
        font-family: 'Syne', sans-serif;
        font-size: .65rem;
        font-weight: 700;
        letter-spacing: .06em;
        text-transform: uppercase;
        color: var(--pv-muted);
        padding: 8px 14px 0;
        margin: 0;
        cursor: text;
    }
    .pv-field input,
    .pv-field select,
    .pv-field textarea {
        display: block;
        width: 100%;
        border: none !important;
        outline: none !important;
        box-shadow: none !important;
        padding: 3px 14px 9px;
        font-family: 'DM Sans', sans-serif;
        font-size: .9rem;
        color: var(--pv-text);
        background: transparent;
    }
    .pv-field select { cursor: pointer; }
    .is-invalid ~ .invalid-feedback { display: block; }
    .pv-field.is-invalid { border-color: #ef4444; }

    /* ── Toggle Factura ── */
    .pv-toggle-card {
        border: 1.5px solid var(--pv-border);
        border-radius: 10px;
        padding: 14px 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        cursor: pointer;
        transition: border-color .2s, background .2s;
        background: #fff;
        margin-bottom: 20px;
    }
    .pv-toggle-card.active {
        border-color: var(--pv-blue);
        background: linear-gradient(135deg, rgba(59,130,246,.05), rgba(99,102,241,.05));
    }
    .pv-toggle-label { font-family: 'Syne', sans-serif; font-size: .9rem; font-weight: 600; color: var(--pv-text); }
    .pv-toggle-sub   { font-size: .78rem; color: var(--pv-muted); margin-top: 2px; }
    .form-check-input { width: 2.6em !important; height: 1.3em !important; cursor: pointer; }
    .form-check-input:checked { background-color: var(--pv-blue) !important; border-color: var(--pv-blue) !important; }

    /* ── Sección colapsable datos fiscales ── */
    #seccion-fiscal { display: none; }
    #seccion-fiscal.show { display: block; animation: fadeIn .25s ease; }
    @keyframes fadeIn { from { opacity:0; transform:translateY(-6px); } to { opacity:1; transform:translateY(0); } }

    /* ── Separador de sección ── */
    .pv-section-label {
        font-family: 'Syne', sans-serif;
        font-size: .72rem;
        font-weight: 700;
        letter-spacing: .08em;
        text-transform: uppercase;
        color: var(--pv-muted);
        margin: 0 0 14px;
        padding-bottom: 8px;
        border-bottom: 1px solid var(--pv-border);
    }

    /* ── Botones ── */
    .btn-pv-primary {
        background: linear-gradient(135deg, #3B82F6, #6366F1);
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 11px 28px;
        font-family: 'Syne', sans-serif;
        font-weight: 700;
        font-size: .88rem;
        letter-spacing: .03em;
        transition: opacity .15s, transform .1s;
        cursor: pointer;
    }
    .btn-pv-primary:hover { opacity: .9; transform: translateY(-1px); color: #fff; }

    .btn-pv-cancel {
        background: transparent;
        color: var(--pv-muted);
        border: 1.5px solid var(--pv-border);
        border-radius: 10px;
        padding: 10px 22px;
        font-family: 'Syne', sans-serif;
        font-weight: 600;
        font-size: .88rem;
        transition: all .15s;
        cursor: pointer;
    }
    .btn-pv-cancel:hover { border-color: var(--pv-muted); color: var(--pv-text); }

    .btn-pv-save {
        background: linear-gradient(135deg, #10B981, #059669);
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 11px 32px;
        font-family: 'Syne', sans-serif;
        font-weight: 700;
        font-size: .88rem;
        letter-spacing: .03em;
        transition: opacity .15s, transform .1s;
        cursor: pointer;
    }
    .btn-pv-save:hover { opacity: .9; transform: translateY(-1px); color: #fff; }

    /* ── Pie del form ── */
    .pv-form-footer {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 12px;
        padding: 18px 22px;
        border-top: 1px solid var(--pv-border);
        background: #f8fafc;
    }

    /* ── Tipo de persona badge ── */
    .pv-tipo-selector { display: flex; gap: 10px; }
    .pv-tipo-option { display: none; }
    .pv-tipo-label {
        flex: 1;
        text-align: center;
        border: 1.5px solid var(--pv-border);
        border-radius: 10px;
        padding: 12px;
        cursor: pointer;
        transition: all .2s;
        font-family: 'Syne', sans-serif;
        font-weight: 600;
        font-size: .85rem;
        color: var(--pv-muted);
    }
    .pv-tipo-label span { display: block; font-size: .7rem; font-weight: 400; color: var(--pv-muted); margin-top: 2px; font-family: 'DM Sans', sans-serif; }
    .pv-tipo-option:checked + .pv-tipo-label {
        border-color: var(--pv-blue);
        background: linear-gradient(135deg, rgba(59,130,246,.08), rgba(99,102,241,.08));
        color: var(--pv-blue);
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4 py-4">

    {{-- Encabezado --}}
    <div class="pv-page-header">
        <a href="{{ route('clientes.index') }}" title="Volver">&#8592;</a>
        <h2>Nuevo Cliente</h2>
    </div>

    {{-- Barra de pasos --}}
    <div class="pv-steps">
        <div class="pv-step active">
            <div class="pv-step-num">1</div>
            <div>
                <div class="pv-step-label">Datos generales</div>
                <div class="pv-step-sub">Identificación y contacto</div>
            </div>
        </div>
        <div class="pv-step active">
            <div class="pv-step-num">2</div>
            <div>
                <div class="pv-step-label">Datos fiscales</div>
                <div class="pv-step-sub">RFC, CFDI y dirección</div>
            </div>
        </div>
    </div>

    <form action="{{ route('clientes.store') }}" method="POST" id="form-cliente">
        @csrf

        {{-- ── SECCIÓN 1: Datos generales ── --}}
        <div class="pv-card">
            <div class="pv-card-header">
                <div class="pv-card-header-num">1</div>
                <p class="pv-card-header-title">Información general</p>
            </div>
            <div class="pv-card-body">

                {{-- Tipo de persona --}}
                <div class="mb-4">
                    <p class="pv-section-label">Tipo de persona</p>
                    <div class="pv-tipo-selector">
                        <input class="pv-tipo-option" type="radio" name="tipo" id="tipo_fisica" value="NATURAL"
                            {{ old('tipo','NATURAL') === 'NATURAL' ? 'checked' : '' }}>
                        <label class="pv-tipo-label" for="tipo_fisica">
                            Persona Física
                            <span>Individuo o trabajador independiente</span>
                        </label>

                        <input class="pv-tipo-option" type="radio" name="tipo" id="tipo_moral" value="JURIDICA"
                            {{ old('tipo') === 'JURIDICA' ? 'checked' : '' }}>
                        <label class="pv-tipo-label" for="tipo_moral">
                            Persona Moral
                            <span>Empresa, asociación o sociedad</span>
                        </label>
                    </div>
                    @error('tipo')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>

                <div class="row g-3">
                    {{-- Razón social --}}
                    <div class="col-md-6">
                        <div class="pv-field @error('razon_social') is-invalid @enderror">
                            <label for="razon_social">Razón social *</label>
                            <input type="text" id="razon_social" name="razon_social"
                                   value="{{ old('razon_social') }}" placeholder="Nombre completo o empresa">
                        </div>
                        @error('razon_social')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Nombre de contacto --}}
                    <div class="col-md-6">
                        <div class="pv-field">
                            <label for="nombre_contacto">Nombre de contacto</label>
                            <input type="text" id="nombre_contacto" name="nombre_contacto"
                                   value="{{ old('nombre_contacto') }}" placeholder="Persona de contacto principal">
                        </div>
                    </div>

                    {{-- Identificación oficial --}}
                    <div class="col-md-4">
                        <div class="pv-field @error('documento_id') is-invalid @enderror">
                            <label for="documento_id">Tipo de identificación oficial *</label>
                            <select id="documento_id" name="documento_id">
                                <option value="">— Seleccionar —</option>
                                @foreach ($documentos as $doc)
                                    <option value="{{ $doc->id }}" {{ old('documento_id') == $doc->id ? 'selected' : '' }}>
                                        {{ $doc->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('documento_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Número de identificación --}}
                    <div class="col-md-4">
                        <div class="pv-field @error('numero_documento') is-invalid @enderror">
                            <label for="numero_documento">Número de identificación *</label>
                            <input type="text" id="numero_documento" name="numero_documento"
                                   value="{{ old('numero_documento') }}" placeholder="Folio o número">
                        </div>
                        @error('numero_documento')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Estado del cliente --}}
                    <div class="col-md-4">
                        <div class="pv-field">
                            <label for="estado">Estado</label>
                            <select id="estado" name="estado">
                                <option value="1" {{ old('estado','1') == '1' ? 'selected' : '' }}>Activo</option>
                                <option value="0" {{ old('estado') == '0' ? 'selected' : '' }}>Inactivo</option>
                            </select>
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="col-md-6">
                        <div class="pv-field @error('email') is-invalid @enderror">
                            <label for="email">Correo electrónico</label>
                            <input type="email" id="email" name="email"
                                   value="{{ old('email') }}" placeholder="correo@ejemplo.com">
                        </div>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Teléfono --}}
                    <div class="col-md-6">
                        <div class="pv-field">
                            <label for="telefono">Teléfono</label>
                            <input type="text" id="telefono" name="telefono"
                                   value="{{ old('telefono') }}" placeholder="10 dígitos">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── SECCIÓN 2: Datos fiscales ── --}}
        <div class="pv-card">
            <div class="pv-card-header">
                <div class="pv-card-header-num">2</div>
                <p class="pv-card-header-title">Datos fiscales</p>
            </div>
            <div class="pv-card-body">

                {{-- Toggle requiere factura --}}
                <div class="pv-toggle-card" id="toggle-factura-card">
                    <div>
                        <div class="pv-toggle-label">Requiere factura (CFDI)</div>
                        <div class="pv-toggle-sub">Activa si el cliente necesita comprobante fiscal digital</div>
                    </div>
                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input" type="checkbox" role="switch"
                               id="requiere_factura" name="requiere_factura" value="1"
                               {{ old('requiere_factura') ? 'checked' : '' }}>
                    </div>
                </div>

                {{-- Sección fiscal colapsable --}}
                <div id="seccion-fiscal" class="{{ old('requiere_factura') ? 'show' : '' }}">

                    <p class="pv-section-label">Información fiscal</p>
                    <div class="row g-3 mb-4">
                        {{-- RFC --}}
                        <div class="col-md-4">
                            <div class="pv-field @error('rfc') is-invalid @enderror">
                                <label for="rfc">RFC *</label>
                                <input type="text" id="rfc" name="rfc"
                                       value="{{ old('rfc') }}" placeholder="XAXX010101000"
                                       maxlength="13" style="text-transform:uppercase">
                            </div>
                            @error('rfc')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- Régimen fiscal --}}
                        <div class="col-md-4">
                            <div class="pv-field @error('regimen_fiscal') is-invalid @enderror">
                                <label for="regimen_fiscal">Régimen fiscal *</label>
                                <select id="regimen_fiscal" name="regimen_fiscal">
                                    <option value="">— Seleccionar —</option>
                                    <option value="601" {{ old('regimen_fiscal')=='601' ? 'selected' : '' }}>601 – General de Ley Personas Morales</option>
                                    <option value="603" {{ old('regimen_fiscal')=='603' ? 'selected' : '' }}>603 – Personas Morales con Fines No Lucrativos</option>
                                    <option value="605" {{ old('regimen_fiscal')=='605' ? 'selected' : '' }}>605 – Sueldos y Salarios</option>
                                    <option value="606" {{ old('regimen_fiscal')=='606' ? 'selected' : '' }}>606 – Arrendamiento</option>
                                    <option value="608" {{ old('regimen_fiscal')=='608' ? 'selected' : '' }}>608 – Demás Ingresos</option>
                                    <option value="609" {{ old('regimen_fiscal')=='609' ? 'selected' : '' }}>609 – Consolidación</option>
                                    <option value="612" {{ old('regimen_fiscal')=='612' ? 'selected' : '' }}>612 – Personas Físicas con Actividad Empresarial</option>
                                    <option value="616" {{ old('regimen_fiscal')=='616' ? 'selected' : '' }}>616 – Sin Obligaciones Fiscales</option>
                                    <option value="621" {{ old('regimen_fiscal')=='621' ? 'selected' : '' }}>621 – Incorporación Fiscal</option>
                                    <option value="625" {{ old('regimen_fiscal')=='625' ? 'selected' : '' }}>625 – Régimen de Actividades Empresariales con Ingresos a través de Plataformas Tecnológicas</option>
                                    <option value="626" {{ old('regimen_fiscal')=='626' ? 'selected' : '' }}>626 – Régimen Simplificado de Confianza</option>
                                </select>
                            </div>
                            @error('regimen_fiscal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- Uso CFDI --}}
                        <div class="col-md-4">
                            <div class="pv-field @error('uso_cfdi') is-invalid @enderror">
                                <label for="uso_cfdi">Uso del CFDI *</label>
                                <select id="uso_cfdi" name="uso_cfdi">
                                    <option value="">— Seleccionar —</option>
                                    <option value="G01" {{ old('uso_cfdi')=='G01' ? 'selected' : '' }}>G01 – Adquisición de mercancias</option>
                                    <option value="G02" {{ old('uso_cfdi')=='G02' ? 'selected' : '' }}>G02 – Devoluciones, descuentos o bonificaciones</option>
                                    <option value="G03" {{ old('uso_cfdi')=='G03' ? 'selected' : '' }}>G03 – Gastos en general</option>
                                    <option value="I01" {{ old('uso_cfdi')=='I01' ? 'selected' : '' }}>I01 – Construcciones</option>
                                    <option value="I02" {{ old('uso_cfdi')=='I02' ? 'selected' : '' }}>I02 – Mobiliario y equipo de oficina</option>
                                    <option value="I04" {{ old('uso_cfdi')=='I04' ? 'selected' : '' }}>I04 – Equipo de cómputo y accesorios</option>
                                    <option value="I06" {{ old('uso_cfdi')=='I06' ? 'selected' : '' }}>I06 – Comunicaciones telefónicas</option>
                                    <option value="P01" {{ old('uso_cfdi')=='P01' ? 'selected' : '' }}>P01 – Por definir</option>
                                    <option value="S01" {{ old('uso_cfdi')=='S01' ? 'selected' : '' }}>S01 – Sin efectos fiscales</option>
                                    <option value="CP01" {{ old('uso_cfdi')=='CP01' ? 'selected' : '' }}>CP01 – Pagos</option>
                                    <option value="CN01" {{ old('uso_cfdi')=='CN01' ? 'selected' : '' }}>CN01 – Nómina</option>
                                </select>
                            </div>
                            @error('uso_cfdi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    {{-- Dirección fiscal --}}
                    <p class="pv-section-label">Dirección fiscal</p>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="pv-field">
                                <label for="pais">País</label>
                                <select id="pais" name="pais">
                                    <option value="">— Seleccionar —</option>
                                    <option value="México" {{ old('pais','México') === 'México' ? 'selected' : '' }}>México</option>
                                    <option value="Estados Unidos" {{ old('pais') === 'Estados Unidos' ? 'selected' : '' }}>Estados Unidos</option>
                                    <option value="Canadá" {{ old('pais') === 'Canadá' ? 'selected' : '' }}>Canadá</option>
                                    <option value="Otro" {{ old('pais') === 'Otro' ? 'selected' : '' }}>Otro</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="pv-field">
                                <label for="estado_fiscal">Estado</label>
                                <input type="text" id="estado_fiscal" name="estado_fiscal"
                                       value="{{ old('estado_fiscal') }}" placeholder="Ej: Jalisco">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="pv-field">
                                <label for="ciudad">Ciudad / Municipio</label>
                                <input type="text" id="ciudad" name="ciudad"
                                       value="{{ old('ciudad') }}" placeholder="Ej: Guadalajara">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="pv-field">
                                <label for="codigo_postal">Código postal</label>
                                <input type="text" id="codigo_postal" name="codigo_postal"
                                       value="{{ old('codigo_postal') }}" placeholder="44100" maxlength="10">
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="pv-field">
                                <label for="calle">Calle</label>
                                <input type="text" id="calle" name="calle"
                                       value="{{ old('calle') }}" placeholder="Nombre de la calle">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="pv-field">
                                <label for="numero_exterior">Núm. exterior</label>
                                <input type="text" id="numero_exterior" name="numero_exterior"
                                       value="{{ old('numero_exterior') }}" placeholder="123">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="pv-field">
                                <label for="numero_interior">Núm. interior</label>
                                <input type="text" id="numero_interior" name="numero_interior"
                                       value="{{ old('numero_interior') }}" placeholder="Depto 4B">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="pv-field">
                                <label for="cruzamientos">Cruzamientos / Entre calles</label>
                                <input type="text" id="cruzamientos" name="cruzamientos"
                                       value="{{ old('cruzamientos') }}" placeholder="Entre Av. Reforma y Calle Morelos">
                            </div>
                        </div>
                    </div>
                </div>{{-- /seccion-fiscal --}}

            </div>
        </div>

        {{-- Pie del formulario --}}
        <div class="pv-form-footer pv-card" style="margin-top:-1px; border-top: none;">
            <a href="{{ route('clientes.index') }}" class="btn-pv-cancel">Cancelar</a>
            <button type="submit" class="btn-pv-save">Guardar cliente</button>
        </div>

    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggle       = document.getElementById('requiere_factura');
    const seccion      = document.getElementById('seccion-fiscal');
    const toggleCard   = document.getElementById('toggle-factura-card');

    function actualizarFiscal() {
        if (toggle.checked) {
            seccion.classList.add('show');
            toggleCard.classList.add('active');
        } else {
            seccion.classList.remove('show');
            toggleCard.classList.remove('active');
        }
    }

    toggle.addEventListener('change', actualizarFiscal);
    actualizarFiscal(); // estado inicial

    // Mayúsculas automáticas en RFC
    document.getElementById('rfc')?.addEventListener('input', function () {
        this.value = this.value.toUpperCase();
    });
});
</script>
@endpush