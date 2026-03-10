@extends('layouts.app')

@section('title','Editar cliente')

@push('css')

@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Editar Cliente</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('clientes.index')}}">Clientes</a></li>
        <li class="breadcrumb-item active">Editar cliente</li>
    </ol>

    <div class="card text-bg-light">
        <form action="{{ route('clientes.update',['cliente'=>$cliente]) }}" method="post">
            @method('PATCH')
            @csrf
            <div class="card-header">
                <p>Tipo de cliente: <span class="fw-bold">
                        {{ strtoupper($cliente->persona->tipo->value)}}
                    </span></p>
            </div>
            <div class="card-body">

                <div class="row g-3">

                    <!-------Razón social------->
                    <div class="col-12">
                        <label id="label-juridica" for="razon_social" class="form-label">
                            {{ $cliente->persona->tipo->value == 'NATURAL' ? 'Nombres y apellidos:' : 'Nombre de la empresa:'}}
                        </label>
                        <input required
                            type="text"
                            name="razon_social"
                            id="razon_social"
                            class="form-control"
                            value="{{old('razon_social',$cliente->persona->razon_social)}}">
                        @error('razon_social')
                        <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>

                    <!----Nombre de contacto (nuevo)---->
                    <div class="col-md-6">
                        <label for="nombre_contacto" class="form-label">Nombre de contacto:</label>
                        <input type="text" name="nombre_contacto" id="nombre_contacto"
                            class="form-control" value="{{old('nombre_contacto', $cliente->persona->nombre_contacto)}}"
                            placeholder="Persona de contacto directo">
                        @error('nombre_contacto')
                        <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>

                    <!------Dirección---->
                    <div class="col-md-6">
                        <label for="direccion" class="form-label">Dirección:</label>
                        <input type="text"
                            name="direccion"
                            id="direccion"
                            class="form-control"
                            value="{{old('direccion',$cliente->persona->direccion)}}">
                        @error('direccion')
                        <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>

                    <!------Email---->
                    <div class="col-md-6">
                        <x-forms.input id="email"
                            type='email'
                            labelText='Correo eléctronico'
                            :defaultValue='$cliente->persona->email' />
                    </div>

                    <!------Telefono---->
                    <div class="col-md-6">
                        <x-forms.input id="telefono"
                            type='number'
                            :defaultValue='$cliente->persona->telefono' />
                    </div>

                    <!--------------Documento------->
                    <div class="col-md-6">
                        <label for="documento_id" class="form-label">
                            Tipo de documento:</label>
                        <select class="form-select" name="documento_id" id="documento_id">
                            @foreach ($documentos as $item)
                            <option value="{{ $item->id }}"
                                {{ old('documento_id', $cliente->persona->documento_id) == $item->id ? 'selected' : '' }}>
                                {{ $item->nombre }}
                            </option>
                            @endforeach
                        </select>
                        @error('documento_id')
                        <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="numero_documento" class="form-label">Numero de documento:</label>
                        <input required
                            type="text"
                            name="numero_documento"
                            id="numero_documento"
                            class="form-control"
                            value="{{old('numero_documento',$cliente->persona->numero_documento)}}">
                        @error('numero_documento')
                        <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>

                    <!----Sección fiscal (toggle)---->
                    <div class="col-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="requiere_factura"
                                name="requiere_factura" value="1"
                                {{ old('requiere_factura', $cliente->persona->requiere_factura) ? 'checked' : '' }}
                                onchange="toggleFiscal(this)">
                            <label class="form-check-label" for="requiere_factura">
                                ¿Requiere facturación / datos fiscales?
                            </label>
                        </div>
                    </div>

                    <div class="col-12" id="box-fiscal" style="{{ old('requiere_factura', $cliente->persona->requiere_factura) ? '' : 'display:none;' }}">
                        <div class="card" style="border: 1px dashed var(--pv-border);">
                            <div class="card-header">
                                <i class="fas fa-receipt me-1"></i> Datos Fiscales
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label for="rfc" class="form-label">RFC:</label>
                                        <input type="text" name="rfc" id="rfc"
                                            class="form-control" value="{{old('rfc', $cliente->persona->rfc)}}"
                                            placeholder="XAXX010101000" maxlength="20">
                                        @error('rfc')
                                        <small class="text-danger">{{'*'.$message}}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="regimen_fiscal" class="form-label">Régimen Fiscal:</label>
                                        <input type="text" name="regimen_fiscal" id="regimen_fiscal"
                                            class="form-control" value="{{old('regimen_fiscal', $cliente->persona->regimen_fiscal)}}"
                                            placeholder="Ej: 601 - General de Ley">
                                        @error('regimen_fiscal')
                                        <small class="text-danger">{{'*'.$message}}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="uso_cfdi" class="form-label">Uso de CFDI:</label>
                                        <input type="text" name="uso_cfdi" id="uso_cfdi"
                                            class="form-control" value="{{old('uso_cfdi', $cliente->persona->uso_cfdi)}}"
                                            placeholder="Ej: G03 - Gastos en general">
                                        @error('uso_cfdi')
                                        <small class="text-danger">{{'*'.$message}}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <div class="card-footer text-center">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
    function toggleFiscal(checkbox) {
        if (checkbox.checked) {
            $('#box-fiscal').slideDown(200);
        } else {
            $('#box-fiscal').slideUp(200);
        }
    }
</script>
@endpush