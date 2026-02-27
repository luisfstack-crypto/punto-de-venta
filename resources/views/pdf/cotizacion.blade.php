<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotización {{$cotizacion->id}}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .info-box {
            width: 100%;
            margin-bottom: 20px;
        }
        .info-box table {
            width: 100%;
        }
        .table-products {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .table-products th, .table-products td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .table-products th {
            background-color: #f2f2f2;
        }
        .text-right {
            text-align: right;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>{{ $empresa->nombre_empresa ?? 'Punto de Venta' }}</h1>
        <p>{{ $empresa->direccion ?? 'Dirección de la empresa' }}</p>
        <h2>Cotización #{{ $cotizacion->id }}</h2>
    </div>

    <div class="info-box">
        <table>
            <tr>
                <td><strong>Cliente:</strong> {{ $cotizacion->cliente->persona->razon_social }}</td>
                <td class="text-right"><strong>Fecha:</strong> {{ $cotizacion->fecha }}</td>
            </tr>
            <tr>
                <td><strong>RFC/DNI:</strong> {{ $cotizacion->cliente->persona->numero_documento }}</td>
                <td class="text-right"><strong>Validez:</strong> {{ $cotizacion->fecha_validez }}</td>
            </tr>
        </table>
    </div>

    <table class="table-products">
        <thead>
            <tr>
                <th>Producto</th>
                <th class="text-right">Cantidad</th>
                <th class="text-right">Precio Unit.</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cotizacion->productos as $producto)
            <tr>
                <td>{{ $producto->nombre }}</td>
                <td class="text-right">{{ $producto->pivot->cantidad }}</td>
                <td class="text-right">{{ number_format($producto->pivot->precio, 2) }}</td>
                <td class="text-right">{{ number_format($producto->pivot->cantidad * $producto->pivot->precio, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="text-right"><strong>Subtotal:</strong></td>
                <td class="text-right">{{ number_format($cotizacion->total - $cotizacion->impuesto, 2) }}</td>
            </tr>
                <tr>
                    <td colspan="3" class="text-right total-label">IVA (16%):</td>
                    <td class="total-amount">{{ number_format($cotizacion->impuesto, 2) }}</td>
                </tr>
            <tr>
                <td colspan="3" class="text-right"><strong>Total:</strong></td>
                <td class="text-right"><strong>{{ number_format($cotizacion->total, 2) }}</strong></td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>Gracias por su preferencia.</p>
        <p>{{ $cotizacion->observaciones }}</p>
    </div>

</body>
</html>
