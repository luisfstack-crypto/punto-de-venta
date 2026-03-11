@extends('layouts.app')

@section('title','Nueva Cotización')

@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<style>
    .cot-wrap {
        max-width: 960px;
        margin: 0 auto;
        padding: 0 1rem 3rem;
    }

    /* ── Section headers ── */
    .section-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 1rem;
    }
    .section-header .step-num {
        width: 28px; height: 28px;
        background: linear-gradient(135deg, #3B82F6, #6366F1);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-family: 'Syne', sans-serif;
        font-size: 0.75rem; font-weight: 700;
        color: #fff; flex-shrink: 0;
    }
    .section-header h6 {
        font-family: 'Syne', sans-serif;
        font-size: 0.7rem; font-weight: 700;
        letter-spacing: 0.12em; text-transform: uppercase;
        color: #9CA3AF; margin: 0;
    }

    /* ── Cards ── */
    .cot-card {
        background: var(--pv-card-bg, #fff);
        border: 1px solid var(--pv-border, #E4E7EF);
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.25rem;
    }

    /* ── Form controls ── */
    .cot-wrap .form-label {
        font-family: 'DM Sans', sans-serif;
        font-size: 0.78rem;
        font-weight: 500;
        color: #6B7280;
        margin-bottom: 0.35rem;
        display: block;
    }
    .cot-wrap .form-control,
    .cot-wrap .form-select,
    .cot-wrap .bootstrap-select .btn {
        border-radius: 8px;
        border-color: var(--pv-border, #E4E7EF);
        font-size: 0.875rem;
        font-family: 'DM Sans', sans-serif;
    }
    .cot-wrap .form-control:focus {
        border-color: #3B82F6;
        box-shadow: 0 0 0 3px rgba(59,130,246,0.12);
    }

    /* IVA toggle */
    .iva-toggle-wrap {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 0.65rem 1rem;
        border: 1px solid var(--pv-border, #E4E7EF);
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s;
    }
    .iva-toggle-wrap:hover { border-color: #3B82F6; }
    .iva-toggle-wrap .form-check-input { margin: 0; cursor: pointer; }
    .iva-toggle-wrap .iva-label {
        font-family: 'DM Sans', sans-serif;
        font-size: 0.875rem; font-weight: 500;
        color: var(--pv-text, #111827);
        flex: 1;
    }
    .iva-toggle-wrap .iva-pct {
        font-family: 'Syne', sans-serif;
        font-size: 0.75rem; font-weight: 700;
        color: #3B82F6;
        background: rgba(59,130,246,0.1);
        padding: 2px 8px;
        border-radius: 20px;
    }

    /* ── Product search area ── */
    .product-search-card {
        background: var(--pv-card-header, #F7F8FB);
        border: 1px dashed var(--pv-border, #E4E7EF);
        border-radius: 10px;
        padding: 1.25rem;
        margin-bottom: 1rem;
    }
    .product-search-card .bootstrap-select .btn {
        background: var(--pv-card-bg, #fff);
    }

    .field-group {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr 1fr;
        gap: 0.75rem;
        margin-top: 0.75rem;
    }
    @media (max-width: 768px) {
        .field-group { grid-template-columns: 1fr 1fr; }
    }

    .field-pill {
        background: var(--pv-card-bg, #fff);
        border: 1px solid var(--pv-border, #E4E7EF);
        border-radius: 8px;
        padding: 0.6rem 0.9rem;
    }
    .field-pill label {
        font-size: 0.68rem;
        font-family: 'Syne', sans-serif;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #9CA3AF;
        display: block;
        margin-bottom: 3px;
    }
    .field-pill input {
        border: none;
        background: transparent;
        padding: 0;
        font-size: 0.9rem;
        font-family: 'DM Sans', sans-serif;
        font-weight: 500;
        color: var(--pv-text, #111827);
        width: 100%;
        outline: none;
    }
    .field-pill input:disabled { opacity: 0.5; }

    .desc-row { margin-top: 0.75rem; display: grid; grid-template-columns: 1fr auto; gap: 0.75rem; align-items: end; }
    @media (max-width: 576px) { .desc-row { grid-template-columns: 1fr; } }

    .btn-add {
        background: linear-gradient(135deg, #3B82F6, #6366F1);
        color: #fff; border: none;
        padding: 0.6rem 1.5rem;
        border-radius: 8px;
        font-family: 'Syne', sans-serif;
        font-weight: 600; font-size: 0.85rem;
        display: flex; align-items: center; gap: 6px;
        white-space: nowrap;
        transition: all 0.2s;
        box-shadow: 0 4px 12px rgba(99,102,241,0.25);
        cursor: pointer;
    }
    .btn-add:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(99,102,241,0.35); }

    /* ── Products table ── */
    .prod-table-wrap { border-radius: 10px; overflow: hidden; border: 1px solid var(--pv-border, #E4E7EF); }
    .prod-table { width: 100%; border-collapse: collapse; }
    .prod-table thead th {
        background: #0E1117;
        color: rgba(255,255,255,0.55);
        font-family: 'Syne', sans-serif;
        font-size: 0.65rem; font-weight: 700;
        letter-spacing: 0.1em; text-transform: uppercase;
        padding: 0.7rem 1rem; text-align: left;
    }
    .prod-table thead th:last-child { text-align: center; width: 50px; }
    .prod-table tbody tr { border-bottom: 1px solid var(--pv-border, #E4E7EF); transition: background 0.15s; }
    .prod-table tbody tr:last-child { border-bottom: none; }
    .prod-table tbody tr:hover { background: var(--pv-card-header, #F7F8FB); }
    .prod-table td { padding: 0.85rem 1rem; font-size: 0.875rem; font-family: 'DM Sans', sans-serif; color: var(--pv-text, #374151); vertical-align: middle; }
    .prod-table td:last-child { text-align: center; }
    .prod-nombre { font-weight: 600; color: var(--pv-text, #111827); }
    .prod-desc-cell { font-size: 0.78rem; color: #9CA3AF; }
    .desc-badge {
        display: inline-block;
        background: rgba(239,68,68,0.08); color: #DC2626;
        border-radius: 4px; padding: 1px 6px;
        font-size: 0.72rem; font-weight: 600;
    }
    .btn-del {
        background: rgba(239,68,68,0.08);
        color: #DC2626; border: none;
        width: 30px; height: 30px;
        border-radius: 6px; cursor: pointer;
        transition: all 0.15s;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto;
        font-size: 1rem; font-weight: 600; line-height: 1;
    }
    .btn-del:hover { background: rgba(239,68,68,0.15); transform: scale(1.1); }

    /* ── Totals box ── */
    .totals-box {
        margin-top: 1rem;
        margin-left: auto;
        max-width: 300px;
        border: 1px solid var(--pv-border, #E4E7EF);
        border-radius: 10px;
        overflow: hidden;
    }
    .totals-header {
        background: var(--pv-card-header, #F7F8FB);
        padding: 0.6rem 1rem;
        font-family: 'Syne', sans-serif;
        font-size: 0.65rem; font-weight: 700;
        letter-spacing: 0.1em; text-transform: uppercase;
        color: #9CA3AF;
    }
    .total-row-item {
        display: flex; justify-content: space-between;
        padding: 0.45rem 1rem;
        font-size: 0.875rem; font-family: 'DM Sans', sans-serif;
        border-bottom: 1px solid var(--pv-border, #E4E7EF);
        color: #6B7280;
    }
    .total-row-item span:last-child { font-weight: 500; color: var(--pv-text, #111827); }
    .total-row-item.final {
        background: #0E1117;
        padding: 0.7rem 1rem;
        border-bottom: none;
    }
    .total-row-item.final span:first-child { color: rgba(255,255,255,0.5); font-family: 'Syne', sans-serif; font-size: 0.8rem; font-weight: 700; }
    .total-row-item.final span:last-child { color: #3B82F6; font-family: 'Syne', sans-serif; font-size: 1.1rem; font-weight: 800; }

    /* ── Submit ── */
    .submit-area {
        display: flex; justify-content: flex-end; align-items: center;
        gap: 1rem; margin-top: 1.5rem;
    }
    .btn-save {
        background: linear-gradient(135deg, #10B981, #059669);
        color: #fff; border: none;
        padding: 0.85rem 2.5rem;
        border-radius: 10px;
        font-family: 'Syne', sans-serif;
        font-weight: 700; font-size: 0.95rem;
        display: flex; align-items: center; gap: 8px;
        transition: all 0.2s;
        box-shadow: 0 4px 14px rgba(16,185,129,0.3);
        cursor: pointer;
    }
    .btn-save:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(16,185,129,0.4); }
    .btn-save:disabled { opacity: 0.4; cursor: not-allowed; transform: none; }

    /* Empty state */
    .empty-row td {
        text-align: center;
        padding: 2.5rem;
        color: #9CA3AF;
        font-size: 0.85rem;
        font-family: 'DM Sans', sans-serif;
        letter-spacing: 0.02em;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 mb-1" style="font-family:'Syne',sans-serif; font-weight:800; font-size:1.6rem;">Nueva Cotización</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('cotizaciones.index') }}">Cotizaciones</a></li>
        <li class="breadcrumb-item active">Nueva</li>
    </ol>
</div>

<form action="{{ route('cotizaciones.store') }}" method="post" id="formCotizacion">
    @csrf
    <div class="cot-wrap">

        {{-- ── PASO 1: Datos generales ── --}}
        <div class="section-header">
            <div class="step-num">1</div>
            <h6>Datos Generales</h6>
        </div>
        <div class="cot-card">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Cliente</label>
                    <select name="cliente_id" id="cliente_id"
                        class="form-control selectpicker show-tick"
                        data-live-search="true" title="Selecciona un cliente"
                        data-size="5">
                        @foreach ($clientes as $item)
                        <option value="{{ $item->id }}">{{ $item->persona->razon_social }}</option>
                        @endforeach
                    </select>
                    @error('cliente_id')
                    <small class="text-danger">{{ '*'.$message }}</small>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Válida hasta</label>
                    <input type="date" name="fecha_validez" id="fecha_validez"
                        class="form-control"
                        value="{{ date('Y-m-d', strtotime('+7 days')) }}" required>
                    @error('fecha_validez')
                    <small class="text-danger">{{ '*'.$message }}</small>
                    @enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label">IVA</label>
                    <label class="iva-toggle-wrap">
                        <input class="form-check-input" type="checkbox"
                            name="aplicar_iva" id="aplicar_iva" value="1" checked>
                        <span class="iva-label">Aplicar IVA</span>
                        <span class="iva-pct">{{ $empresa->porcentaje_impuesto }}%</span>
                    </label>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Descuento Global (%)</label>
                    <input type="number" name="descuento_global" id="descuento_global"
                        class="form-control" value="0" step="any" min="0" max="100"
                        placeholder="0">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Observaciones</label>
                    <textarea name="observaciones" id="observaciones"
                        class="form-control" rows="2"
                        placeholder="Notas adicionales, condiciones, etc."></textarea>
                </div>
            </div>
        </div>

        {{-- ── PASO 2: Productos ── --}}
        <div class="section-header">
            <div class="step-num">2</div>
            <h6>Productos / Servicios</h6>
        </div>
        <div class="cot-card">

            {{-- Buscador de producto --}}
            <div class="product-search-card">
                <label class="form-label" style="font-family:'Syne',sans-serif; font-size:0.7rem; font-weight:700; letter-spacing:0.08em; text-transform:uppercase; color:#9CA3AF;">
                    Buscar producto
                </label>
                <select id="producto_id"
                    class="form-control selectpicker"
                    data-live-search="true" data-size="5"
                    title="Escribe el nombre o código...">
                    @foreach ($productos as $item)
                    <option value="{{ $item->id }}-{{ $item->cantidad }}-{{ $item->precio }}-{{ $item->nombre }}-{{ $item->sigla }}">
                        {{ 'Cód: '.$item->codigo.' · '.$item->nombre.' · '.$item->sigla }}
                    </option>
                    @endforeach
                </select>

                <div class="field-group">
                    <div class="field-pill">
                        <label>En Stock</label>
                        <input disabled id="stock" type="text" placeholder="—">
                    </div>
                    <div class="field-pill">
                        <label>Precio Unit.</label>
                        <input id="precio" type="number" step="any" placeholder="—">
                    </div>
                    <div class="field-pill">
                        <label>Cantidad</label>
                        <input type="number" id="cantidad" placeholder="0" min="1">
                    </div>
                    <div class="field-pill">
                        <label>Descuento (%)</label>
                        <input type="number" id="descuento_p" placeholder="0" value="0" min="0" max="100" step="any">
                    </div>
                </div>

                <div class="desc-row">
                    <div class="field-pill" style="border-color: var(--pv-border);">
                        <label>Descripción / Detalle del producto</label>
                        <input type="text" id="descripcion_p" placeholder="Ej. Medidas especiales, color, acabado...">
                    </div>
                    <button id="btn_agregar" class="btn-add" type="button">
                        Agregar
                    </button>
                </div>
            </div>

            {{-- Tabla de productos agregados --}}
            <div class="prod-table-wrap">
                <table class="prod-table" id="tabla_detalle">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Descripción</th>
                            <th style="text-align:center;">Cant.</th>
                            <th style="text-align:right;">Precio</th>
                            <th style="text-align:center;">Desc.</th>
                            <th style="text-align:right;">Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="tbody_productos">
                        <tr class="empty-row" id="empty-row">
                            <td colspan="7">
                                Aún no has agregado productos
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Totales --}}
            <div class="totals-box">
                <div class="totals-header">Resumen</div>
                <div class="total-row-item">
                    <span>Subtotal</span>
                    <span>
                        <input type="hidden" name="subtotal" id="inputSubtotal" value="0">
                        <span id="sumas">0.00</span> {{ $empresa->moneda->simbolo }}
                    </span>
                </div>
                <div class="total-row-item" id="row-iva">
                    <span>{{ $empresa->abreviatura_impuesto }} ({{ $empresa->porcentaje_impuesto }}%)</span>
                    <span>
                        <input type="hidden" name="impuesto" id="inputImpuesto" value="0">
                        <span id="igv">0.00</span> {{ $empresa->moneda->simbolo }}
                    </span>
                </div>
                <div class="total-row-item final">
                    <span>Total</span>
                    <span>
                        <input type="hidden" name="total" id="inputTotal" value="0">
                        <span id="total">0.00</span> {{ $empresa->moneda->simbolo }}
                    </span>
                </div>
            </div>
        </div>

        {{-- ── Submit ── --}}
        <div class="submit-area">
            <a href="{{ route('cotizaciones.index') }}"
                style="font-family:'DM Sans',sans-serif; font-size:0.875rem; color:#9CA3AF; text-decoration:none;">
                Cancelar
            </a>
            <button type="submit" class="btn-save" id="guardar" disabled>
                Guardar Cotización
            </button>
        </div>

    </div>
</form>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
<script>
    $(document).ready(function() {
        $('#producto_id').change(mostrarValores);
        $('#btn_agregar').click(agregarProducto);
        $('#aplicar_iva').change(calcularTotales);
        $('#descuento_global').on('input', calcularTotales);
    });

    let cont = 0;
    let subtotal = [];
    let arrayIdProductos = [];
    const impuesto = @json($empresa->porcentaje_impuesto);

    function mostrarValores() {
        let data = $('#producto_id').val().split('-');
        $('#stock').val(data[1]);
        $('#precio').val(data[2]);
        $('#cantidad').focus();
    }

    function agregarProducto() {
        let data        = $('#producto_id').val().split('-');
        let idProducto  = data[0];
        let nameProducto = data[3];
        let cantidad    = $('#cantidad').val();
        let precio      = $('#precio').val();
        let descripcion = $('#descripcion_p').val();
        let descuento   = parseFloat($('#descuento_p').val()) || 0;

        if (!idProducto || !cantidad || !precio) return showToast('Completa los campos del producto', 'warning');
        if (parseFloat(cantidad) <= 0)           return showToast('La cantidad debe ser mayor a 0', 'warning');
        if (arrayIdProductos.includes(idProducto)) return showToast('Este producto ya fue agregado', 'warning');

        let sub = round(cantidad * precio * (1 - descuento / 100));
        subtotal[cont] = sub;

        // Quitar empty row
        $('#empty-row').remove();

        let fila = `<tr id="fila${cont}">
            <td>
                <input type="hidden" name="arrayidproducto[]" value="${idProducto}">
                <div class="prod-nombre">${nameProducto}</div>
            </td>
            <td>
                <input type="hidden" name="arraydescripcion[]" value="${descripcion}">
                <div class="prod-desc-cell">${descripcion || '<span style="color:#D1D5DB;">—</span>'}</div>
            </td>
            <td style="text-align:center;">
                <input type="hidden" name="arraycantidad[]" value="${cantidad}">
                ${cantidad}
            </td>
            <td style="text-align:right;">
                <input type="hidden" name="arrayprecioventa[]" value="${precio}">
                $${parseFloat(precio).toFixed(2)}
            </td>
            <td style="text-align:center;">
                <input type="hidden" name="arraydescuento[]" value="${descuento}">
                ${descuento > 0 ? `<span class="desc-badge">-${descuento}%</span>` : '<span style="color:#D1D5DB;">—</span>'}
            </td>
            <td style="text-align:right; font-weight:600;">$${sub.toFixed(2)}</td>
            <td>
                <button class="btn-del" type="button" onclick="eliminarProducto(${cont}, '${idProducto}')">
                    ×
                </button>
            </td>
        </tr>`;

        $('#tbody_productos').append(fila);
        arrayIdProductos.push(idProducto);
        cont++;
        limpiarCampos();
        calcularTotales();
    }

    function calcularTotales() {
        let sumas = 0;
        subtotal.forEach(v => { if (v !== undefined) sumas += v; });
        sumas = round(sumas);

        let descGlobal = parseFloat($('#descuento_global').val()) || 0;
        let sumasConDesc = round(sumas * (1 - descGlobal / 100));
        if (sumasConDesc < 0) sumasConDesc = 0;

        let aplicaIva = $('#aplicar_iva').is(':checked');
        let igv = aplicaIva ? round(sumasConDesc * (impuesto / 100)) : 0;
        let total = round(sumasConDesc + igv);

        $('#sumas').text(sumas.toFixed(2));
        $('#igv').text(igv.toFixed(2));
        $('#total').text(total.toFixed(2));
        $('#inputSubtotal').val(sumas);
        $('#inputImpuesto').val(igv);
        $('#inputTotal').val(total);

        $('#row-iva').css('opacity', aplicaIva ? '1' : '0.35');
        $('#guardar').prop('disabled', total <= 0);
    }

    function eliminarProducto(indice, idProducto) {
        delete subtotal[indice];
        $(`#fila${indice}`).remove();
        arrayIdProductos = arrayIdProductos.filter(id => id !== idProducto);

        if (arrayIdProductos.length === 0) {
            $('#tbody_productos').append(`
                <tr class="empty-row" id="empty-row">
                    <td colspan="7">Sin productos agregados</td>
                </tr>`);
        }
        calcularTotales();
    }

    function limpiarCampos() {
        $('#producto_id').selectpicker('val', '');
        $('#cantidad, #precio, #stock').val('');
        $('#descripcion_p').val('');
        $('#descuento_p').val('0');
    }

    function showToast(message, icon = 'error') {
        Swal.mixin({
            toast: true, position: 'top-end',
            showConfirmButton: false, timer: 3000, timerProgressBar: true
        }).fire({ icon, title: message });
    }

    function round(num, decimales = 2) {
        var signo = num >= 0 ? 1 : -1;
        num = num * signo;
        if (decimales === 0) return signo * Math.round(num);
        num = num.toString().split('e');
        num = Math.round(+(num[0] + 'e' + (num[1] ? +num[1] + decimales : decimales)));
        num = num.toString().split('e');
        return signo * +(num[0] + 'e' + (num[1] ? +num[1] - decimales : -decimales));
    }
</script>
@endpush