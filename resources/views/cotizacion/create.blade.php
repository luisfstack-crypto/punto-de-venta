@extends('layouts.app')

@section('title','Nueva Cotización')

@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Nueva Cotización</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('cotizaciones.index')}}">Cotizaciones</a></li>
        <li class="breadcrumb-item active">Nueva Cotización</li>
    </ol>
</div>

<form action="{{ route('cotizaciones.store') }}" method="post">
    @csrf
    <div class="container-lg mt-4">
        <div class="row gy-4">

            <!-----General Data---->
            <div class="col-12">
                <div class="text-white bg-success p-1 text-center">
                    Datos generales
                </div>
                <div class="p-3 border border-3 border-success">
                    <div class="row g-4">

                        <!--Cliente-->
                        <div class="col-md-6">
                            <label for="cliente_id" class="form-label">
                                Cliente:</label>
                            <select name="cliente_id" id="cliente_id"
                                class="form-control selectpicker show-tick"
                                data-live-search="true" title="Selecciona"
                                data-size='2'>
                                @foreach ($clientes as $item)
                                <option value="{{$item->id}}">{{$item->persona->razon_social}}</option>
                                @endforeach
                            </select>
                            @error('cliente_id')
                            <small class="text-danger">{{ '*'.$message }}</small>
                            @enderror
                        </div>

                        <!--Fecha Validez-->
                        <div class="col-md-6">
                            <label for="fecha_validez" class="form-label">
                                Validez hasta:</label>
                            <input type="date" name="fecha_validez" id="fecha_validez" class="form-control" value="{{ date('Y-m-d', strtotime('+7 days')) }}" required>
                            @error('fecha_validez')
                            <small class="text-danger">{{ '*'.$message }}</small>
                            @enderror
                        </div>
                        
                        <!--Observaciones-->
                        <div class="col-12">
                             <label for="observaciones" class="form-label">Observaciones:</label>
                             <textarea name="observaciones" id="observaciones" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!------Details---->
            <div class="col-12">
                <div class="text-white bg-primary p-1 text-center">
                    Detalles de la cotización
                </div>
                <div class="p-3 border border-3 border-primary">
                    <div class="row gy-4">

                        <!-----Producto---->
                        <div class="col-12">
                            <select id="producto_id"
                                class="form-control selectpicker"
                                data-live-search="true" data-size="1"
                                title="Busque un producto aquí">
                                @foreach ($productos as $item)
                                <option value="{{$item->id}}-{{$item->cantidad}}-{{$item->precio}}-{{$item->nombre}}-{{$item->sigla}}">
                                    {{'Código: '. $item->codigo.' - '. $item->nombre.' - '.$item->sigla}}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-----Stock--->
                        <div class="d-flex justify-content-end">
                            <div class="col-12 col-sm-6">
                                <div class="row">
                                    <label for="stock" class="col-form-label col-4">
                                        En stock:</label>
                                    <div class="col-8">
                                        <input disabled id="stock"
                                            type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-----Precio -->
                        <div class="d-flex justify-content-end">
                            <div class="col-12 col-sm-6">
                                <div class="row">
                                    <label for="precio" class="col-form-label col-4">
                                        Precio:</label>
                                    <div class="col-8">
                                        <input disabled id="precio"
                                            type="number" class="form-control"
                                            step="any">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-----Cantidad---->
                        <div class="col-md-6">
                            <label for="cantidad" class="form-label">
                                Cantidad:</label>
                            <input type="number" id="cantidad"
                                class="form-control">
                        </div>

                        <!-----botón para agregar--->
                        <div class="col-12 text-end">
                            <button id="btn_agregar" class="btn btn-primary" type="button">
                                Agregar</button>
                        </div>

                        <!-----Tabla para el detalle--->
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="tabla_detalle" class="table table-hover">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th class="text-white">Producto</th>
                                            <th class="text-white">Presentación</th>
                                            <th class="text-white">Cantidad</th>
                                            <th class="text-white">Precio</th>
                                            <th class="text-white">Subtotal</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th></th>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="4">Sumas</th>
                                            <th colspan="2">
                                                <input type="hidden" name="subtotal"
                                                    value="0"
                                                    id="inputSubtotal">
                                                <span id="sumas">0</span>
                                                <span>{{$empresa->moneda->simbolo}}</span>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th colspan="4">
                                                {{$empresa->abreviatura_impuesto}} (16%)
                                            </th>
                                            <th colspan="2">
                                                <input type="hidden" name="impuesto"
                                                    id="inputImpuesto"
                                                    value="0">
                                                <span id="igv">0</span>
                                                <span>{{$empresa->moneda->simbolo}}</span>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th colspan="4">Total</th>
                                            <th colspan="2">
                                                <input type="hidden" name="total" value="0" id="inputTotal">
                                                <span id="total">0</span>
                                                <span>{{$empresa->moneda->simbolo}}</span>
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!----Finalizar-->
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-success" id="guardar">
                    Guardar Cotización</button>
            </div>

        </div>
    </div>

</form>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
<script>
    $(document).ready(function() {
        $('#producto_id').change(mostrarValores);
        $('#btn_agregar').click(function() {
            agregarProducto();
        });
        disableButtons();
    });

    let cont = 0;
    let subtotal = [];
    let sumas = 0;
    let igv = 0;
    let total = 0;
    let arrayIdProductos = [];

    const impuesto = @json($empresa->porcentaje_impuesto);

    function mostrarValores() {
        let dataProducto = document.getElementById('producto_id').value.split('-');
        $('#stock').val(dataProducto[1]);
        $('#precio').val(dataProducto[2]);
    }

    function agregarProducto() {
        let dataProducto = document.getElementById('producto_id').value.split('-');
        let idProducto = dataProducto[0];
        let nameProducto = dataProducto[3];
        let presentacioneProducto = dataProducto[4];
        let cantidad = $('#cantidad').val();
        let precioVenta = $('#precio').val();
        let stock = $('#stock').val();

        if (idProducto != '' && cantidad != '') {
            if (parseInt(cantidad) > 0 && (cantidad % 1 == 0)) {
                
                // Note: For quotations, maybe we allow exceeding stock? 
                // But for now I'll keep the check or make it a warning. 
                // Let's keep it strict for simplicity unless user complained.
                if (parseInt(cantidad) <= parseInt(stock)) {

                    if (!arrayIdProductos.includes(idProducto)) {
                        subtotal[cont] = round(cantidad * precioVenta);
                        sumas = round(sumas + subtotal[cont]);
                        igv = round(sumas / 100 * impuesto);
                        total = round(sumas + igv);

                        let fila = '<tr id="fila' + cont + '">' +
                            '<td><input type="hidden" name="arrayidproducto[]" value="' + idProducto + '">' + nameProducto + '</td>' +
                            '<td>' + presentacioneProducto + '</td>' +
                            '<td><input type="hidden" name="arraycantidad[]" value="' + cantidad + '">' + cantidad + '</td>' +
                            '<td><input type="hidden" name="arrayprecioventa[]" value="' + precioVenta + '">' + precioVenta + '</td>' +
                            '<td>' + subtotal[cont] + '</td>' +
                            '<td><button class="btn btn-danger" type="button" onClick="eliminarProducto(' + cont + ',' + idProducto + ')"><i class="fa-solid fa-trash"></i></button></td>' +
                            '</tr>';

                        $('#tabla_detalle').append(fila);
                        limpiarCampos();
                        cont++;
                        disableButtons();

                        $('#sumas').html(sumas);
                        $('#igv').html(igv);
                        $('#total').html(total);
                        $('#inputImpuesto').val(igv);
                        $('#inputTotal').val(total);
                        $('#inputSubtotal').val(sumas);

                        arrayIdProductos.push(idProducto);
                    } else {
                        showModal('Ya ha ingresado el producto');
                    }
                } else {
                    showModal('Cantidad supera el stock disponible');
                }
            } else {
                showModal('Valores incorrectos');
            }
        } else {
            showModal('Le faltan campos por llenar');
        }
    }

    function eliminarProducto(indice, idProducto) {
        sumas -= round(subtotal[indice]);
        igv = round(sumas / 100 * impuesto);
        total = round(sumas + igv);

        $('#sumas').html(sumas);
        $('#igv').html(igv);
        $('#total').html(total);
        $('#inputImpuesto').val(igv);
        $('#inputTotal').val(total);
        $('#inputSubtotal').val(sumas);

        $('#fila' + indice).remove();

        let index = arrayIdProductos.indexOf(idProducto.toString());
        arrayIdProductos.splice(index, 1);

        disableButtons();
    }

    function disableButtons() {
        if (total == 0) {
            $('#guardar').hide();
        } else {
            $('#guardar').show();
        }
    }

    function limpiarCampos() {
        let select = $('#producto_id');
        select.selectpicker('val', '');
        $('#cantidad').val('');
        $('#precio').val('');
        $('#stock').val('');
    }

    function showModal(message, icon = 'error') {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: icon,
            title: message
        })
    }

    function round(num, decimales = 2) {
        var signo = (num >= 0 ? 1 : -1);
        num = num * signo;
        if (decimales === 0) return signo * Math.round(num);
        num = num.toString().split('e');
        num = Math.round(+(num[0] + 'e' + (num[1] ? (+num[1] + decimales) : decimales)));
        num = num.toString().split('e');
        return signo * (num[0] + 'e' + (num[1] ? (+num[1] - decimales) : -decimales));
    }
</script>
@endpush
