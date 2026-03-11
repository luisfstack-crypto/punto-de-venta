@extends('layouts.app')
@section('title','Nueva Compra')

@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<style>
    .cot-wrap { max-width: 960px; margin: 0 auto; padding: 0 1rem 3rem; }

    .section-header { display: flex; align-items: center; gap: 10px; margin-bottom: 1rem; }
    .section-header .step-num {
        width: 28px; height: 28px;
        background: linear-gradient(135deg, #3B82F6, #6366F1);
        border-radius: 50%; display: flex; align-items: center; justify-content: center;
        font-family: 'Syne', sans-serif; font-size: .75rem; font-weight: 700;
        color: #fff; flex-shrink: 0;
    }
    .section-header h6 {
        font-family: 'Syne', sans-serif; font-size: .7rem; font-weight: 700;
        letter-spacing: .12em; text-transform: uppercase; color: #9CA3AF; margin: 0;
    }
    .cot-card {
        background: var(--pv-card-bg, #fff); border: 1px solid var(--pv-border, #E4E7EF);
        border-radius: 12px; padding: 1.5rem; margin-bottom: 1.25rem;
    }
    .cot-wrap .form-label {
        font-family: 'DM Sans', sans-serif; font-size: .78rem; font-weight: 500;
        color: #6B7280; margin-bottom: .35rem; display: block;
    }
    .cot-wrap .form-control,
    .cot-wrap .bootstrap-select .btn {
        border-radius: 8px; border-color: var(--pv-border, #E4E7EF);
        font-size: .875rem; font-family: 'DM Sans', sans-serif;
    }
    .cot-wrap .form-control:focus { border-color: #3B82F6; box-shadow: 0 0 0 3px rgba(59,130,246,.12); }

    .field-group { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: .75rem; margin-top: .75rem; }
    @media(max-width:768px){ .field-group { grid-template-columns: 1fr 1fr; } }

    .field-pill { background: var(--pv-card-bg, #fff); border: 1px solid var(--pv-border, #E4E7EF); border-radius: 8px; padding: .6rem .9rem; }
    .field-pill label { font-size: .68rem; font-family: 'Syne', sans-serif; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; color: #9CA3AF; display: block; margin-bottom: 3px; }
    .field-pill input { border: none; background: transparent; padding: 0; font-size: .9rem; font-family: 'DM Sans', sans-serif; font-weight: 500; color: var(--pv-text, #111827); width: 100%; outline: none; }

    .product-search-card { background: var(--pv-card-header, #F7F8FB); border: 1px dashed var(--pv-border, #E4E7EF); border-radius: 10px; padding: 1.25rem; margin-bottom: 1rem; }
    .product-search-card .bootstrap-select .btn { background: var(--pv-card-bg, #fff); }

    .desc-row { margin-top: .75rem; display: flex; justify-content: flex-end; }
    .btn-add { background: linear-gradient(135deg, #3B82F6, #6366F1); color: #fff; border: none; padding: .6rem 1.5rem; border-radius: 8px; font-family: 'Syne', sans-serif; font-weight: 600; font-size: .85rem; display: flex; align-items: center; gap: 6px; transition: all .2s; box-shadow: 0 4px 12px rgba(99,102,241,.25); cursor: pointer; }
    .btn-add:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(99,102,241,.35); }

    .prod-table-wrap { border-radius: 10px; overflow: hidden; border: 1px solid var(--pv-border, #E4E7EF); }
    .prod-table { width: 100%; border-collapse: collapse; }
    .prod-table thead th { background: #0E1117; color: rgba(255,255,255,.55); font-family: 'Syne', sans-serif; font-size: .65rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; padding: .7rem 1rem; text-align: left; }
    .prod-table thead th:last-child { text-align: center; width: 50px; }
    .prod-table tbody tr { border-bottom: 1px solid var(--pv-border, #E4E7EF); transition: background .15s; }
    .prod-table tbody tr:last-child { border-bottom: none; }
    .prod-table tbody tr:hover { background: var(--pv-card-header, #F7F8FB); }
    .prod-table td { padding: .85rem 1rem; font-size: .875rem; font-family: 'DM Sans', sans-serif; color: var(--pv-text, #374151); vertical-align: middle; }
    .prod-table td:last-child { text-align: center; }
    .prod-nombre { font-weight: 600; color: var(--pv-text, #111827); }
    .btn-del { background: rgba(239,68,68,.08); color: #DC2626; border: none; width: 30px; height: 30px; border-radius: 6px; cursor: pointer; transition: all .15s; display: flex; align-items: center; justify-content: center; margin: 0 auto; font-size: 1rem; font-weight: 600; }
    .btn-del:hover { background: rgba(239,68,68,.15); transform: scale(1.1); }

    .totals-box { margin-top: 1rem; margin-left: auto; max-width: 300px; border: 1px solid var(--pv-border, #E4E7EF); border-radius: 10px; overflow: hidden; }
    .totals-header { background: var(--pv-card-header, #F7F8FB); padding: .6rem 1rem; font-family: 'Syne', sans-serif; font-size: .65rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: #9CA3AF; }
    .total-row-item { display: flex; justify-content: space-between; padding: .45rem 1rem; font-size: .875rem; font-family: 'DM Sans', sans-serif; border-bottom: 1px solid var(--pv-border, #E4E7EF); color: #6B7280; }
    .total-row-item span:last-child { font-weight: 500; color: var(--pv-text, #111827); }
    .total-row-item.final { background: #0E1117; padding: .7rem 1rem; border-bottom: none; }
    .total-row-item.final span:first-child { color: rgba(255,255,255,.5); font-family: 'Syne', sans-serif; font-size: .8rem; font-weight: 700; }
    .total-row-item.final span:last-child { color: #3B82F6; font-family: 'Syne', sans-serif; font-size: 1.1rem; font-weight: 800; }

    .submit-area { display: flex; justify-content: flex-end; align-items: center; gap: 1rem; margin-top: 1.5rem; }
    .btn-save { background: linear-gradient(135deg, #10B981, #059669); color: #fff; border: none; padding: .85rem 2.5rem; border-radius: 10px; font-family: 'Syne', sans-serif; font-weight: 700; font-size: .95rem; display: flex; align-items: center; gap: 8px; transition: all .2s; box-shadow: 0 4px 14px rgba(16,185,129,.3); cursor: pointer; }
    .btn-save:hover { transform: translateY(-1px); }
    .btn-save:disabled { opacity: .4; cursor: not-allowed; transform: none; }
    .btn-cancel-outline { background: transparent; color: #ef4444; border: 1.5px solid #ef4444; border-radius: 8px; padding: .6rem 1.4rem; font-family: 'Syne', sans-serif; font-weight: 600; font-size: .85rem; cursor: pointer; transition: all .15s; }
    .btn-cancel-outline:hover { background: #ef4444; color: #fff; }

    .empty-row td { text-align: center; padding: 2.5rem; color: #9CA3AF; font-size: .85rem; font-family: 'DM Sans', sans-serif; }

    .pv-file-wrap { border: 1.5px dashed var(--pv-border, #E4E7EF); border-radius: 10px; padding: .65rem 1rem; background: #fafafa; cursor: pointer; transition: border-color .2s; position: relative; height: 100%; }
    .pv-file-wrap:hover { border-color: #3B82F6; }
    .pv-file-wrap input[type="file"] { position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; }
    .pv-file-wrap .pv-file-tag { font-family: 'Syne', sans-serif; font-size: .65rem; font-weight: 700; letter-spacing: .06em; text-transform: uppercase; color: #9CA3AF; margin-bottom: 2px; }
    .pv-file-wrap .pv-file-name { font-family: 'DM Sans', sans-serif; font-size: .85rem; color: #6B7280; }
</style>
@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 mb-1" style="font-family:'Syne',sans-serif;font-weight:800;font-size:1.6rem;">Nueva Compra</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('compras.index') }}">Compras</a></li>
        <li class="breadcrumb-item active">Nueva</li>
    </ol>
</div>

<form action="{{ route('compras.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="cot-wrap">

        {{-- PASO 1 --}}
        <div class="section-header">
            <div class="step-num">1</div>
            <h6>Datos Generales</h6>
        </div>
        <div class="cot-card">
            <div class="row g-3">

                <div class="col-12">
                    <label class="form-label">Proveedor</label>
                    <select name="proveedore_id" id="proveedore_id" required
                        class="form-control selectpicker show-tick"
                        data-live-search="true" title="Selecciona un proveedor" data-size="5">
                        @foreach ($proveedores as $item)
                        <option value="{{ $item->id }}">{{ $item->nombre_documento }}</option>
                        @endforeach
                    </select>
                    @error('proveedore_id')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Tipo de comprobante</label>
                    <select name="comprobante_id" id="comprobante_id" required
                        class="form-control selectpicker" title="Selecciona">
                        @foreach ($comprobantes as $item)
                        <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                        @endforeach
                    </select>
                    @error('comprobante_id')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <div class="col-md-4">
                    <div class="field-pill">
                        <label>Número de comprobante</label>
                        <input type="text" name="numero_comprobante" id="numero_comprobante" placeholder="Folio o número">
                    </div>
                    @error('numero_comprobante')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <div class="col-md-4">
                    <div class="pv-file-wrap">
                        <input type="file" name="file_comprobante" id="file_comprobante" accept=".pdf">
                        <div class="pv-file-tag">Archivo comprobante (PDF)</div>
                        <div class="pv-file-name" id="file-label">Sin archivo seleccionado</div>
                    </div>
                    @error('file_comprobante')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Método de pago</label>
                    <select name="metodo_pago" id="metodo_pago" required
                        class="form-control selectpicker" title="Selecciona">
                        @foreach ($optionsMetodoPago as $item)
                        <option value="{{ $item->value }}">{{ $item->label() }}</option>
                        @endforeach
                    </select>
                    @error('metodo_pago')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <div class="col-md-6">
                    <div class="field-pill">
                        <label>Fecha y hora</label>
                        <input type="datetime-local" name="fecha_hora" id="fecha_hora" required>
                    </div>
                    @error('fecha_hora')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

            </div>
        </div>

        {{-- PASO 2 --}}
        <div class="section-header">
            <div class="step-num">2</div>
            <h6>Detalle de la Compra</h6>
        </div>
        <div class="cot-card">

            <div class="product-search-card">
                <label class="form-label" style="font-family:'Syne',sans-serif;font-size:.7rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#9CA3AF;">
                    Buscar producto
                </label>
                <select id="producto_id" class="form-control selectpicker"
                    data-live-search="true" data-size="5" title="Escribe el nombre o código...">
                    @foreach ($productos as $item)
                    <option value="{{ $item->id }}">{{ $item->nombre_completo }}</option>
                    @endforeach
                </select>

                <div class="field-group">
                    <div class="field-pill">
                        <label>Cantidad</label>
                        <input type="number" id="cantidad" placeholder="0" min="1">
                    </div>
                    <div class="field-pill">
                        <label>Precio de compra</label>
                        <input type="number" id="precio_compra" placeholder="0.00" step="0.1">
                    </div>
                    <div class="field-pill">
                        <label>Fecha vencimiento</label>
                        <input type="date" id="fecha_vencimiento">
                    </div>
                </div>

                <div class="desc-row">
                    <button id="btn_agregar" class="btn-add" type="button">
                        Agregar producto
                    </button>
                </div>
            </div>

            <div class="prod-table-wrap">
                <table class="prod-table" id="tabla_detalle">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Presentación</th>
                            <th style="text-align:center;">Cant.</th>
                            <th style="text-align:right;">Precio</th>
                            <th>Vencimiento</th>
                            <th style="text-align:right;">Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="tbody_productos">
                        <tr class="empty-row" id="empty-row">
                            <td colspan="7">Aún no has agregado productos</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="totals-box">
                <div class="totals-header">Resumen</div>
                <div class="total-row-item">
                    <span>Subtotal</span>
                    <span>
                        <input type="hidden" name="subtotal" value="0" id="inputSubtotal">
                        <span id="sumas">0.00</span> {{ $empresa->moneda->simbolo }}
                    </span>
                </div>
                <div class="total-row-item final">
                    <span>Total</span>
                    <span>
                        <input type="hidden" name="total" value="0" id="inputTotal">
                        <input type="hidden" name="impuesto" value="0" id="inputImpuesto">
                        <span id="total">0.00</span> {{ $empresa->moneda->simbolo }}
                    </span>
                </div>
            </div>
        </div>

        <div class="submit-area">
            <button id="cancelar" type="button" class="btn-cancel-outline"
                data-bs-toggle="modal" data-bs-target="#modalCancelar" style="display:none;">
                Cancelar compra
            </button>
            <a href="{{ route('compras.index') }}"
                style="font-family:'DM Sans',sans-serif;font-size:.875rem;color:#9CA3AF;text-decoration:none;">
                Volver
            </a>
            <button type="submit" class="btn-save" id="guardar" disabled>
                Realizar compra
            </button>
        </div>

    </div>
</form>

<div class="modal fade" id="modalCancelar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content border-0 rounded-3 shadow">
            <div class="modal-body p-4 text-center">
                <p style="font-family:'Syne',sans-serif;font-weight:700;font-size:1rem;margin-bottom:6px;">¿Cancelar la compra?</p>
                <p style="font-size:.85rem;color:#64748b;margin-bottom:0;">Se perderán los productos agregados.</p>
                <div class="d-flex gap-2 justify-content-center mt-3">
                    <button type="button" class="btn btn-sm btn-light rounded-3" data-bs-dismiss="modal">No, volver</button>
                    <button id="btnCancelarCompra" type="button" class="btn btn-sm btn-danger rounded-3" data-bs-dismiss="modal">Confirmar</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
<script>
    $(document).ready(function () {
        $('#btn_agregar').click(agregarProducto);
        $('#btnCancelarCompra').click(cancelarCompra);
        $('#file_comprobante').change(function () {
            $('#file-label').text(this.files[0]?.name || 'Sin archivo seleccionado');
        });
    });

    let cont = 0, subtotal = [], sumas = 0, igv = 0, total = 0;
    let arrayIdProductos = [];
    const impuesto = 0;

    function agregarProducto() {
        let idProducto   = $('#producto_id').val();
        let textProducto = $('#producto_id option:selected').text();
        let cantidad     = $('#cantidad').val();
        let precioCompra = $('#precio_compra').val();
        let fechaVenc    = $('#fecha_vencimiento').val();

        if (!textProducto || !cantidad || !precioCompra)
            return showToast('Le faltan campos por llenar', 'warning');
        if (parseInt(cantidad) <= 0 || (cantidad % 1 !== 0) || parseFloat(precioCompra) <= 0)
            return showToast('Valores incorrectos', 'warning');
        if (arrayIdProductos.includes(idProducto))
            return showToast('Ya ha ingresado este producto', 'warning');

        let nameMatch = textProducto.match(/-\s(.*?)\s-/);
        let presMatch = textProducto.match(/Presentación:\s(.*)/);
        let nameProducto = nameMatch ? nameMatch[1] : textProducto;
        let presentacion = presMatch ? presMatch[1] : '—';

        subtotal[cont] = round(cantidad * precioCompra);
        sumas = round(sumas + subtotal[cont]);
        igv   = round(sumas / 100 * impuesto);
        total = round(sumas + igv);

        $('#empty-row').remove();

        $('#tbody_productos').append(`<tr id="fila${cont}">
            <td><input type="hidden" name="arrayidproducto[]" value="${idProducto}"><div class="prod-nombre">${nameProducto}</div></td>
            <td>${presentacion}</td>
            <td style="text-align:center;"><input type="hidden" name="arraycantidad[]" value="${cantidad}">${cantidad}</td>
            <td style="text-align:right;"><input type="hidden" name="arraypreciocompra[]" value="${precioCompra}">$${parseFloat(precioCompra).toFixed(2)}</td>
            <td><input type="hidden" name="arrayfechavencimiento[]" value="${fechaVenc}">${fechaVenc || '—'}</td>
            <td style="text-align:right;font-weight:600;">$${subtotal[cont].toFixed(2)}</td>
            <td><button class="btn-del" type="button" onclick="eliminarProducto(${cont}, '${idProducto}')">×</button></td>
        </tr>`);

        arrayIdProductos.push(idProducto);
        cont++;
        actualizarUI();
        limpiarCampos();
    }

    function eliminarProducto(indice, idProducto) {
        sumas = round(sumas - subtotal[indice]);
        igv   = round(sumas / 100 * impuesto);
        total = round(sumas + igv);
        delete subtotal[indice];
        $(`#fila${indice}`).remove();
        arrayIdProductos = arrayIdProductos.filter(id => id !== idProducto);
        if (!arrayIdProductos.length)
            $('#tbody_productos').append(`<tr class="empty-row" id="empty-row"><td colspan="7">Aún no has agregado productos</td></tr>`);
        actualizarUI();
    }

    function cancelarCompra() {
        cont = 0; subtotal = []; sumas = 0; igv = 0; total = 0; arrayIdProductos = [];
        $('#tbody_productos').html(`<tr class="empty-row" id="empty-row"><td colspan="7">Aún no has agregado productos</td></tr>`);
        actualizarUI();
        limpiarCampos();
    }

    function actualizarUI() {
        $('#sumas').text(sumas.toFixed(2));
        $('#total').text(total.toFixed(2));
        $('#inputSubtotal').val(sumas);
        $('#inputTotal').val(total);
        $('#inputImpuesto').val(igv);
        $('#guardar').prop('disabled', total <= 0);
        total > 0 ? $('#cancelar').show() : $('#cancelar').hide();
    }

    function limpiarCampos() {
        $('#producto_id').selectpicker('val', '');
        $('#cantidad, #precio_compra, #fecha_vencimiento').val('');
    }

    function showToast(message, icon = 'error') {
        Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 3000, timerProgressBar: true })
            .fire({ icon, title: message });
    }

    function round(num, decimales = 2) {
        var signo = (num >= 0 ? 1 : -1); num = num * signo;
        if (decimales === 0) return signo * Math.round(num);
        num = num.toString().split('e');
        num = Math.round(+(num[0] + 'e' + (num[1] ? (+num[1] + decimales) : decimales)));
        num = num.toString().split('e');
        return signo * +(num[0] + 'e' + (num[1] ? (+num[1] - decimales) : -decimales));
    }
</script>
@endpush