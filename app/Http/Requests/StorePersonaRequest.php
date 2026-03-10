<?php

namespace App\Http\Requests;

use App\Enums\TipoPersonaEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StorePersonaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'razon_social'    => 'required|max:255',
            'nombre_contacto' => 'nullable|max:255',
            'direccion'       => 'nullable|max:255',
            'telefono'        => 'nullable|max:15',
            'tipo'            => ['required', new Enum(TipoPersonaEnum::class)],
            'email'           => 'nullable|max:255|email',
            'documento_id'    => 'required|integer|exists:documentos,id',
            'numero_documento' => 'required|max:20|unique:personas,numero_documento',
            'rfc'             => 'nullable|max:20',
            'regimen_fiscal'  => 'nullable|max:255',
            'uso_cfdi'        => 'nullable|max:255',
            'requiere_factura' => 'nullable|boolean',
        ];
    }
}
