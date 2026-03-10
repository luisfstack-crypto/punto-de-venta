<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePersonaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // ── Datos generales ───────────────────────────────────────────────
            'razon_social'     => ['required', 'string', 'max:255'],
            'nombre_contacto'  => ['nullable', 'string', 'max:255'],
            'tipo'             => ['required', 'in:NATURAL,JURIDICA'],
            'documento_id'     => ['required', 'exists:documentos,id'],
            'numero_documento' => ['required', 'string', 'max:20'],
            'email'            => ['nullable', 'email', 'max:255'],
            'telefono'         => ['nullable', 'string', 'max:15'],
            'estado'           => ['nullable', 'boolean'],

            // ── Datos fiscales mexicanos ──────────────────────────────────────
            'requiere_factura' => ['nullable', 'boolean'],
            'rfc'              => ['nullable', 'string', 'max:13', 'regex:/^[A-ZÑ&]{3,4}[0-9]{6}[A-Z0-9]{3}$/i'],
            'regimen_fiscal'   => ['nullable', 'string', 'max:100'],
            'uso_cfdi'         => ['nullable', 'string', 'max:10'],

            // ── Dirección fiscal ──────────────────────────────────────────────
            'pais'             => ['nullable', 'string', 'max:100'],
            'estado_fiscal'    => ['nullable', 'string', 'max:100'],
            'ciudad'           => ['nullable', 'string', 'max:100'],
            'codigo_postal'    => ['nullable', 'string', 'max:10'],
            'calle'            => ['nullable', 'string', 'max:255'],
            'cruzamientos'     => ['nullable', 'string', 'max:255'],
            'numero_exterior'  => ['nullable', 'string', 'max:20'],
            'numero_interior'  => ['nullable', 'string', 'max:20'],
        ];
    }

    public function messages(): array
    {
        return [
            'razon_social.required'     => 'La razón social es obligatoria.',
            'tipo.required'             => 'Selecciona el tipo de persona.',
            'tipo.in'                   => 'El tipo debe ser Persona Física o Persona Moral.',
            'documento_id.required'     => 'Selecciona el tipo de identificación oficial.',
            'documento_id.exists'       => 'La identificación oficial seleccionada no es válida.',
            'numero_documento.required' => 'El número de identificación es obligatorio.',
            'rfc.regex'                 => 'El RFC no tiene el formato correcto (ej: XAXX010101000).',
            'email.email'               => 'Ingresa un correo electrónico válido.',
        ];
    }

    public function attributes(): array
    {
        return [
            'razon_social'     => 'razón social',
            'nombre_contacto'  => 'nombre de contacto',
            'tipo'             => 'tipo de persona',
            'documento_id'     => 'tipo de identificación',
            'numero_documento' => 'número de identificación',
            'requiere_factura' => 'requiere factura',
            'rfc'              => 'RFC',
            'regimen_fiscal'   => 'régimen fiscal',
            'uso_cfdi'         => 'uso del CFDI',
            'pais'             => 'país',
            'estado_fiscal'    => 'estado',
            'ciudad'           => 'ciudad',
            'codigo_postal'    => 'código postal',
            'calle'            => 'calle',
            'cruzamientos'     => 'cruzamientos',
            'numero_exterior'  => 'número exterior',
            'numero_interior'  => 'número interior',
        ];
    }
}
