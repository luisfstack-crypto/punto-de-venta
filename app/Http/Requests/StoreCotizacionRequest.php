<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCotizacionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cliente_id' => 'required|exists:clientes,id',
            'fecha_validez' => 'required|date|after_or_equal:today',
            'impuesto' => 'required|numeric',
            'total' => 'required|numeric',
            'arrayidproducto' => 'required|array',
            'arraycantidad' => 'required|array',
            'arrayprecioventa' => 'required|array',
        ];
    }
}
