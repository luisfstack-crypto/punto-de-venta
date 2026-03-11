<?php

namespace App\Services;

use App\Models\Producto;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProductoService
{
    /**
     * Crear un Registro
     */
    public function crearProducto(array $data): Producto
    {
        $producto = Producto::create([
            'codigo' => $data['codigo'],
            'nombre' => $data['nombre'],
            'descripcion' => $data['descripcion'],
            'img_path' => isset($data['img_path']) && $data['img_path']
                ? $this->handleUploadImage($data['img_path'])
                : null,
            'marca_id' => $data['marca_id'],
            'categoria_id' => $data['categoria_id'],
            'presentacione_id' => $data['presentacione_id'],
            'precio' => $data['precio'] ?? 0,
            'facturable' => $data['facturable'] ?? false,
            'clave_producto_sat' => $data['clave_producto_sat'] ?? null,
            'codigo_interno' => $data['codigo_interno'] ?? null,
            'tasa_cuota' => $data['tasa_cuota'] ?? null,
            'unidad_medida' => $data['unidad_medida'] ?? null,
            'clave_unidad_sat' => $data['clave_unidad_sat'] ?? null,
        ]);

        return $producto;
    }

    /**
     * Editar un registro
     */
    public function editarProducto(array $data, Producto $producto): Producto
    {

        $producto->update([
            'codigo' => $data['codigo'],
            'nombre' => $data['nombre'],
            'descripcion' => $data['descripcion'],
            'img_path' => isset($data['img_path']) && $data['img_path']
                ? $this->handleUploadImage($data['img_path'], $producto->img_path)
                : $producto->img_path,
            'marca_id' => $data['marca_id'],
            'categoria_id' => $data['categoria_id'],
            'presentacione_id' => $data['presentacione_id'],
            'precio' => $data['precio'] ?? 0,
            'facturable' => $data['facturable'] ?? false,
            'clave_producto_sat' => $data['clave_producto_sat'] ?? null,
            'codigo_interno' => $data['codigo_interno'] ?? null,
            'tasa_cuota' => $data['tasa_cuota'] ?? null,
            'unidad_medida' => $data['unidad_medida'] ?? null,
            'clave_unidad_sat' => $data['clave_unidad_sat'] ?? null,
        ]);

        return $producto;
    }


    /**
     * Guarda una imagen en el Storage
     * 
     */
    private function handleUploadImage(UploadedFile $image, $img_path = null): string
    {
        if ($img_path) {
            $relative_path = str_replace('storage/', '', $img_path);

            if (Storage::disk('public')->exists($relative_path)) {
                Storage::disk('public')->delete($relative_path);
            }
        }

        $name = uniqid() . '.' . $image->getClientOriginalExtension();
        $path = 'storage/' . $image->storeAs('productos', $name);
        return $path;
    }
}
