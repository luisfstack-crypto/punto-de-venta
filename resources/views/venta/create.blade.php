@extends('layouts.app')

@section('title','Realizar Venta')

@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<style>
    .vta-wrap {
        max-width: 960px;
        margin: 0 auto;
        padding: 0 1rem 3rem;
    }

    .section-header {
        display: flex; align-items: center; gap: 10px; margin-bottom: 1rem;
    }
    .section-header .step-num {
        width: 28px; height: 28px;
        background: linear-gradient(135deg, #3B82F6, #6366F1);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-family: 'Syne', sans-serif; font-size: 0.75rem; font-weight: 700;
        color: #fff; flex-shrink: 0;
    }
    .section-header h6 {
        font-family: 'Syne', sans-serif; font-size: 0.7rem; font-weight: 700;
        letter-spacing: 0.12em; text-transform: uppercase; color: #9CA3AF; margin: 0;
    }

    .vta-card {
        background: var(--pv-card-bg, #fff);
        border: 1px solid var(--pv-border, #E4E7EF);
        border-radius: 12px; padding: 1.5rem; margin-bottom: 1.25rem;
    }

    /* Banner cotización cargada */
    .cot-banner {
        display: flex; align-items: center; gap: 10px;
        background: rgba(59,130,246,0.06);
        border: 1px solid rgba(59,130,246,0.2);
        border-radius: 8px; padding: 0.65rem 1rem;
        margin-bottom: 1.25rem;
        font-family: 'DM Sans', sans-serif; font-size: 0.85rem; color: #2563EB;
    }
    .cot-banner strong { font-weight: 600; }

    .vta-wrap .form-label {
        font-family: 'DM Sans', sans-serif; font-size: 0.78rem; font-weight: 500;
        color: #6B7280; margin-bottom: 0.35rem; display: block;
    }
    .vta-wrap .form-control,
    .vta-wrap .bootstrap-select .btn {
        border-radius: 8px; border-color: var(--pv-border, #E4E7EF);
        font-size: 0.875rem; font-family: 'DM Sans', sans-serif;
    }
    .vta-wrap .form-control:focus {
        border-color: #3B82F6; box-shadow: 0 0 0 3px rgba(59,130,246,0.12);
    }

    .iva-toggle-wrap {
        display: flex; align-items: center; gap: 10px;
        padding: 0.65rem 1rem;
        border: 1px solid var(--pv-border, #E4E7EF);
        border-radius: 8px; cursor: pointer; transition: all 0.2s;
    }
    .iva-toggle-wrap:hover { border-color: #3B82F6; }
    .iva-toggle-wrap .form-check-input { margin: 0; cursor: pointer; }
    .iva-toggle-wrap .iva-label {
        font-family: 'DM Sans', sans-serif; font-size: 0.875rem;
        font-weight: 500; color: var(--pv-text, #111827); flex: 1;
    }
    .iva-toggle-wrap .iva-pct {
        font-family: 'Syne', sans-serif; font-size: 0.75rem; font-weight: 700;
        color: #3B82F6; background: rgba(59,130,246,0.1); padding: 2px 8px; border-radius: 20px;
    }

    .product-search-card {
        background: var(--pv-card-header, #F7F8FB);
        border: 1px dashed var(--pv-border, #E4E7EF);
        border-radius: 10px; padding: 1.25rem; margin-bottom: 1rem;
    }
    .product-search-card .bootstrap-select .btn { background: var(--pv-card-bg, #fff); }

    .field-group {
        display: grid; grid-template-columns: 1fr 1fr 1fr 1fr;
        gap: 0.75rem; margin-top: 0.75rem;
    }
    @media (max-width: 768px) { .field-group { grid-template-columns: 1fr 1fr; } }

    .field-pill {
        background: var(--pv-card-bg, #fff);
        border: 1px solid var(--pv-border, #E4E7EF);
        border-radius: 8px; padding: 0.6rem 0.9rem;
    }
    .field-pill label {
        font-size: 0.68rem; font-family: 'Syne', sans-serif; font-weight: 700;
        letter-spacing: 0.08em; text-transform: uppercase; color: #9CA3AF;
        display: block; margin-bottom: 3px;
    }
    .field-pill input {
        border: none; background: transparent; padding: 0;
        font-size: 0.9rem; font-family: 'DM Sans', sans-serif; font-weight: 500;
        color: var(--pv-text, #111827); width: 100%; outline: none;
    }
    .field-pill input:disabled { opacity: 0.5; }

    .desc-row { margin-top: 0.75rem; display: grid; grid-template-columns: 1fr auto; gap: 0.75rem; align-items: end; }
    @media (max-width: 576px) { .desc-row { grid-template-columns: 1fr; } }

    .btn-add {
        background: linear-gradient(135deg, #3B82F6, #6366F1);
        color: #fff; border: none; padding: 0.6rem 1.5rem; border-radius: 8px;
        font-family: 'Syne', sans-serif; font-weight: 600; font-size: 0.85rem;
        white-space: nowrap; transition: all 0.2s;
        box-shadow: 0 4px 12px rgba(99,102,241,0.25); cursor: pointer;
    }
    .btn-add:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(99,102,241,0.35); }

    .prod-table-wrap { border-radius: 10px; overflow: hidden; border: 1px solid var(--pv-border, #E4E7EF); }
    .prod-table { width: 100%; border-collapse: collapse; }
    .prod-table thead th {
        background: #0E1117; color: rgba(255,255,255,0.55);
        font-family: 'Syne', sans-serif; font-size: 0.65rem; font-weight: 700;
        letter-spacing: 0.1em; text-transform: uppercase; padding: 0.7rem 1rem; text-align: left;
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
        display: inline-block; background: rgba(239,68,68,0.08); color: #DC2626;
        border-radius: 4px; padding: 1px 6px; font-size: 0.72rem; font-weight: 600;
    }
    .btn-del {
        background: rgba(239,68,68,0.08); color: #DC2626; border: none;
        width: 30px; height: 30px; border-radius: 6px; cursor: pointer;
        transition: all 0.15s; display: flex; align-items: center; justify-content: center;
        margin: 0 auto; font-size: 1rem; font-weight: 600; line-height: 1;
    }
    .btn-del:hover { background: rgba(239,68,68,0.15); transform: scale(1.1); }

    .totals-box {
        margin-top: 1rem; margin-left: auto; max-width: 300px;
        border: 1px solid var(--pv-border, #E4E7EF); border-radius: 10px; overflow: hidden;
    }
    .totals-header {
        background: var(--pv-card-header, #F7F8FB); padding: 0.6rem 1rem;
        font-family: 'Syne', sans-serif; font-size: 0.65rem; font-weight: 700;
        letter-spacing: 0.1em; text-transform: uppercase; color: #9CA3AF;
    }
    .total-row-item {
        display: flex; justify-content: space-between; padding: 0.45rem 1rem;
        font-size: 0.875rem; font-family: 'DM Sans', sans-serif;
        border-bottom: 1px solid var(--pv-border, #E4E7EF); color: #6B7280;
    }
    .total-row-item span:last-child { font-weight: 500; color: var(--pv-text, #111827); }
    .total-row-item.final {
        background: #0E1117; padding: 0.7rem 1rem; border-bottom: none;
    }
    .total-row-item.final span:first-child {
        color: rgba(255,255,255,0.5); font-family: 'Syne', sans-serif;
        font-size: 0.8rem; font-weight: 700;
    }
    .total-row-item.final span:last-child {
        color: #3B82F6; font-family: 'Syne', sans-serif; font-size: 1.1rem; font-weight: 800;
    }

    /* Cobro */
    .cobro-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    @media (max-width: 576px) { .cobro-grid { grid-template-columns: 1fr; } }

    .cobro-pill {
        background: var(--pv-card-bg, #fff);
        border: 1px solid var(--pv-border, #E4E7EF);
        border-radius: 10px; padding: 1rem 1.25rem;
    }
    .cobro-pill label {
        font-size: 0.68rem; font-family: 'Syne', sans-serif; font-weight: 700;
        letter-spacing: 0.08em; text-transform: uppercase; color: #9CA3AF;
        display: block; margin-bottom: 6px;
    }
    .cobro-pill input {
        border: none; border-bottom: 2px solid var(--pv-border, #E4E7EF);
        border-radius: 0; padding: 0.25rem 0;
        font-size: 1.25rem; font-family: 'Syne', sans-serif; font-weight: 700;
        color: var(--pv-text, #111827); width: 100%; outline: none; background: transparent;
        transition: border-color 0.2s;
    }
    .cobro-pill input:focus { border-bottom-color: #3B82F6; }
    .cobro-pill input[readonly] { color: #10B981; cursor: default; }

    .empty-row td {
        text-align: center; padding: 2.5rem; color: #9CA3AF;
        font-size: 0.85rem; font-family: 'DM Sans', sans-serif; letter-spacing: 0.02em;
    }

    .submit-area {
        display: flex; justify-content: flex-end; align-items: center;
        gap: 1rem; margin-top: 1.5rem;
    }
    .btn-save {
        background: linear-gradient(135deg, #10B981, #059669);
        color: #fff; border: none; padding: 0.85rem 2.5rem; border-radius: 10px;
        font-family: 'Syne', sans-serif; font-weight: 700; font-size: 0.95rem;
        transition: all 0.2s; box-shadow: 0 4px 14px rgba(16,185,129,0.3); cursor: pointer;
    }
    .btn-save:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(16,185,129,0.4); }
    .btn-save:disabled { opacity: 0.4; cursor: not-allowed; transform: none; }
    .btn-cancel-vta {
        background: rgba(239,68,68,0.08); color: #DC2626; border: 1px solid rgba(239,68,68,0.2);
        padding: 0.6rem 1.25rem; border-radius: 8px;
        font-family: 'Syne', sans-serif; font-weight: 600; font-size: 0.82rem;
        cursor: pointer; transition: all 0.2s;
    }
    .btn-cancel-vta:hover { background: rgba(239,68,68,0.12); }
</style>
@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 mb-1" style="font-family:'Syne',sans-serif; font-weight:800; font-size:1.6rem;">Realizar Venta</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('ventas.index') }}">Ventas</a></li>
        <li class="breadcrumb-item active">Nueva</li>
    </ol>
</div>

<form action="{{ route('ventas.store') }}" method="post" id="formVenta">
    @csrf
    <div class="vta-wrap">

        @if(isset($cotizacion))
            <input type="hidden" name="cotizacion_id" value="{{ $cotizacion->id }}">
            <div class="cot-banner">
                <i class="fas fa-file-invoice" style="font-size:0.9rem;"></i>
                Cargando datos desde <strong>Cotización #CIT-{{ $cotizacion->id }}</strong>
                &mdash; {{ $cotizacion->cliente->persona->razon_social }}
            </div>
        @endif

        {{-- ── PASO 1: Datos generales ── --}}
        <div class="section-header">
            <div class="step-num">1</div>
            <h6>Datos Generales</h6>
        </div>
        <div class="vta-card">
            <div class="row g-3">

                <div class="col-12">
                    <label class="form-label">Cliente</label>
                    <select name="cliente_id" id="cliente_id"
                        class="form-control selectpicker show-tick"
                        data-live-search="true" title="Selecciona un cliente" data-size="5">
                        @foreach ($clientes as $item)
                        <option value="{{ $item->id }}">{{ $item->nombre_documento }}</option>
                        @endforeach
                    </select>
                    @error('cliente_id')
                    <small class="text-danger">{{ '*'.$message }}</small>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Comprobante</label>
                    <select name="comprobante_id" id="comprobante_id"
                        class="form-control selectpicker" title="Selecciona">
                        @foreach ($comprobantes as $item)
                        <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                        @endforeach
                    </select>
                    @error('comprobante_id')
                    <small class="text-danger">{{ '*'.$message }}</small>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Método de pago</label>
                    <select required name="metodo_pago" id="metodo_pago"
                        class="form-control selectpicker" title="Selecciona">
                        @foreach ($optionsMetodoPago as $item)
                        <option value="{{ $item->value }}" {{ old('metodo_pago') == $item->value ? 'selected' : '' }} data-icon="{{ $item->icon() }}">
                            {{ $item->label() }}
                        </option>
                        @endforeach
                    </select>
                    @error('metodo_pago')
                    <small class="text-danger">{{ '*'.$message }}</small>
                    @enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label">IVA</label>
                    <label class="iva-toggle-wrap">
                        <input class="form-check-input" type="checkbox"
                            name="aplicar_iva" id="aplicar_iva" value="1"
                            {{ old('aplicar_iva', '1') == '1' ? 'checked' : '' }}>
                        <span class="iva-label">Aplicar IVA</span>
                        <span class="iva-pct">{{ $empresa->porcentaje_impuesto }}%</span>
                    </label>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Descuento Global (%)</label>
                    <input type="number" name="descuento_global" id="descuento_global"
                        class="form-control" value="{{ old('descuento_global', 0) }}"
                        step="any" min="0" max="100" placeholder="0">
                </div>

            </div>
        </div>

        {{-- ── PASO 2: Productos ── --}}
        <div class="section-header">
            <div class="step-num">2</div>
            <h6>Productos</h6>
        </div>
        <div class="vta-card">

            <div class="product-search-card">
                <label class="form-label" style="font-family:'Syne',sans-serif; font-size:0.7rem; font-weight:700; letter-spacing:0.08em; text-transform:uppercase; color:#9CA3AF;">
                    Buscar producto
                </label>
                <select id="producto_id" class="form-control selectpicker"
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
                    <div class="field-pill">
                        <label>Descripción / Detalle</label>
                        <input type="text" id="descripcion_p" placeholder="Ej. Medidas, color, acabado...">
                    </div>
                    <button id="btn_agregar" class="btn-add" type="button">Agregar</button>
                </div>
            </div>

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
                            <td colspan="7">Sin productos agregados</td>
                        </tr>
                    </tbody>
                </table>
            </div>

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

        {{-- ── PASO 3: Cobro ── --}}
        <div class="section-header">
            <div class="step-num">3</div>
            <h6>Cobro</h6>
        </div>
        <div class="vta-card">
            <div class="cobro-grid">
                <div class="cobro-pill">
                    <label>Dinero recibido</label>
                    <input type="number" id="dinero_recibido" name="monto_recibido" step="any" placeholder="0.00">
                </div>
                <div class="cobro-pill">
                    <label>Vuelto</label>
                    <input readonly type="number" name="vuelto_entregado" id="vuelto" step="any" placeholder="0.00">
                </div>
            </div>
        </div>

        {{-- ── Submit ── --}}
        <div class="submit-area">
            <button type="button" class="btn-cancel-vta" id="cancelar"
                data-bs-toggle="modal" data-bs-target="#modalCancelar" style="display:none;">
                Cancelar venta
            </button>
            <a href="{{ route('ventas.index') }}"
                style="font-family:'DM Sans',sans-serif; font-size:0.875rem; color:#9CA3AF; text-decoration:none;">
                Volver
            </a>
            <button type="submit" class="btn-save" id="guardar" disabled>
                Realizar Venta
            </button>
        </div>

    </div>
</form>

{{-- Modal cancelar --}}
<div class="modal fade" id="modalCancelar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" style="font-family:'Syne',sans-serif; font-weight:700;">Cancelar venta</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="font-size:0.875rem;">
                ¿Seguro que quieres limpiar todos los productos?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">No</button>
                <button id="btnCancelarVenta" type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Sí, cancelar</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
<script>
    $(document).ready(function() {
        $('#producto_id').change(mostrarValores);
        $('#btn_agregar').click(agregarProducto);
        $('#btnCancelarVenta').click(cancelarVenta);
        $('#aplicar_iva').change(calcularTotales);
        $('#descuento_global').on('input', calcularTotales);

        $('#dinero_recibido').on('input', function() {
            let recibido = parseFloat($(this).val());
            if (!isNaN(recibido) && recibido >= total && total > 0) {
                $('#vuelto').val((recibido - total).toFixed(2));
            } else {
                $('#vuelto').val('0.00');
            }
        });
    });

    let cont = 0;
    let subtotal = [];
    let total = 0;
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
        let stock       = $('#stock').val();
        let descripcion = $('#descripcion_p').val();
        let descuento   = parseFloat($('#descuento_p').val()) || 0;

        if (!idProducto || !cantidad)           return showToast('Completa los campos del producto', 'warning');
        if (parseFloat(cantidad) <= 0)           return showToast('La cantidad debe ser mayor a 0', 'warning');
        if (parseFloat(cantidad) > parseFloat(stock)) return showToast('No hay stock suficiente', 'warning');
        if (arrayIdProductos.includes(idProducto))    return showToast('Este producto ya fue agregado', 'warning');

        let sub = round(cantidad * precio * (1 - descuento / 100));
        subtotal[cont] = sub;

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
                <button class="btn-del" type="button" onclick="eliminarProducto(${cont}, '${idProducto}')">×</button>
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
        total = round(sumasConDesc + igv);

        $('#sumas').text(sumas.toFixed(2));
        $('#igv').text(igv.toFixed(2));
        $('#total').text(total.toFixed(2));
        $('#inputSubtotal').val(sumas);
        $('#inputImpuesto').val(igv);
        $('#inputTotal').val(total);

        $('#row-iva').css('opacity', aplicaIva ? '1' : '0.35');
        $('#guardar').prop('disabled', total <= 0);
        total > 0 ? $('#cancelar').show() : $('#cancelar').hide();

        // Recalcular vuelto si ya hay monto
        let recibido = parseFloat($('#dinero_recibido').val());
        if (!isNaN(recibido) && recibido >= total && total > 0) {
            $('#vuelto').val((recibido - total).toFixed(2));
        }
    }

    function eliminarProducto(indice, idProducto) {
        delete subtotal[indice];
        $(`#fila${indice}`).remove();
        arrayIdProductos = arrayIdProductos.filter(id => id !== idProducto);

        if (arrayIdProductos.length === 0) {
            $('#tbody_productos').append(`<tr class="empty-row" id="empty-row"><td colspan="7">Sin productos agregados</td></tr>`);
        }
        calcularTotales();
    }

    function cancelarVenta() {
        subtotal = []; total = 0; cont = 0; arrayIdProductos = [];
        $('#tbody_productos').html(`<tr class="empty-row" id="empty-row"><td colspan="7">Sin productos agregados</td></tr>`);
        $('#sumas, #igv, #total').text('0.00');
        $('#inputSubtotal, #inputImpuesto, #inputTotal').val(0);
        $('#dinero_recibido, #vuelto').val('');
        limpiarCampos();
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

    // ── Cargar cotización ──
    const cotizacion = @json($cotizacion ?? null);
    if (cotizacion) {
        $(document).ready(function() {
            $('#aplicar_iva').prop('checked', !!cotizacion.aplicar_iva);
            $('#descuento_global').val(cotizacion.descuento_global || 0);

            // Preseleccionar cliente
            $('#cliente_id').val(cotizacion.cliente_id).trigger('change');
            $('#cliente_id').selectpicker('refresh');

            cotizacion.productos.forEach(producto => {
                let options = document.getElementById('producto_id').options;
                for (let i = 0; i < options.length; i++) {
                    if (options[i].value.startsWith(producto.id + '-')) {
                        $('#producto_id').val(options[i].value);
                        $('#producto_id').selectpicker('refresh');
                        mostrarValores();
                        $('#cantidad').val(producto.pivot.cantidad);
                        $('#precio').val(producto.pivot.precio);
                        $('#descripcion_p').val(producto.pivot.descripcion || '');
                        $('#descuento_p').val(producto.pivot.descuento || 0);
                        agregarProducto();
                        break;
                    }
                }
            });
            calcularTotales();
        });
    }
</script>
@endpush