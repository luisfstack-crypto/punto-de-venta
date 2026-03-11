<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $producto = $this->route('producto');
        return [
            'codigo' => 'nullable|unique:productos,codigo,'.$producto->id.'|max:50',
            'nombre' => 'required|unique:productos,nombre,'.$producto->id.'|max:255',
            'descripcion' => 'nullable|max:255',
            'img_path' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'marca_id' => 'nullable|integer|exists:marcas,id',
            'presentacione_id' => 'required|integer|exists:presentaciones,id',
            'categoria_id' => 'nullable|integer|exists:categorias,id',
            'precio' => 'required|numeric|min:0',
            'facturable' => 'nullable|boolean',
            'clave_producto_sat' => 'required_if:facturable,1|nullable|string|max:20',
            'codigo_interno' => 'nullable|string|max:50',
            'tasa_cuota' => 'required_if:facturable,1|nullable|string|max:50',
            'unidad_medida' => 'required_if:facturable,1|nullable|string|max:50',
            'clave_unidad_sat' => 'required_if:facturable,1|nullable|string|max:10'
        ];
    }

    public function attributes()
    {
        return [
            'marca_id' => 'marca',
            'presentacione_id' => 'presentación',
            'categoria_id' => 'categoria'
        ];
    }

    public function messages()
    {
        return [
            //'codigo.required' => 'Se necesita un campo código'
        ];
    }
}
