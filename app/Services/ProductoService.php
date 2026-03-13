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
            'codigo'             => $data['codigo'],
            'nombre'             => $data['nombre'],
            'descripcion'        => $data['descripcion'],
            'img_path'           => isset($data['img_path']) && $data['img_path']
                                        ? $this->handleUploadImage($data['img_path'])
                                        : null,
            'marca_id'           => $data['marca_id'],
            'categoria_id'       => $data['categoria_id'],
            'presentacione_id'   => $data['presentacione_id'],
            'precio'             => $data['precio'] ?? 0,
            'costo'              => $data['costo'] ?? null,
            'facturable'         => $data['facturable'] ?? false,
            'clave_producto_sat' => $data['clave_producto_sat'] ?? null,
            'codigo_interno'     => $data['codigo_interno'] ?? null,
            'tasa_cuota'         => $data['tasa_cuota'] ?? null,
            'unidad_medida'      => $data['unidad_medida'] ?? null,
            'clave_unidad_sat'   => $data['clave_unidad_sat'] ?? null,
        ]);

        return $producto;
    }

    /**
     * Editar un registro
     */
    public function editarProducto(array $data, Producto $producto): Producto
    {
        $producto->update([
            'codigo'             => $data['codigo'],
            'nombre'             => $data['nombre'],
            'descripcion'        => $data['descripcion'],
            'img_path'           => isset($data['img_path']) && $data['img_path']
                                        ? $this->handleUploadImage($data['img_path'], $producto->img_path)
                                        : $producto->img_path,
            'marca_id'           => $data['marca_id'],
            'categoria_id'       => $data['categoria_id'],
            'presentacione_id'   => $data['presentacione_id'],
            'precio'             => $data['precio'] ?? 0,
            'costo'              => $data['costo'] ?? null,
            'facturable'         => $data['facturable'] ?? false,
            'clave_producto_sat' => $data['clave_producto_sat'] ?? null,
            'codigo_interno'     => $data['codigo_interno'] ?? null,
            'tasa_cuota'         => $data['tasa_cuota'] ?? null,
            'unidad_medida'      => $data['unidad_medida'] ?? null,
            'clave_unidad_sat'   => $data['clave_unidad_sat']   ?? null,
        ]);

        return $producto;
    }


    private function handleUploadImage(UploadedFile $image, $img_path = null): string
    {
        $disk = Storage::disk(config('filesystems.default'));

        if ($img_path) {
            if (str_starts_with($img_path, 'http')) {
                $awsUrl  = config('filesystems.disks.s3.url');
                $objKey  = ltrim(str_replace($awsUrl, '', $img_path), '/');
            } else {
                $objKey = str_replace('storage/', '', $img_path);
            }

            if ($disk->exists($objKey)) {
                $disk->delete($objKey);
            }
        }

        $name    = uniqid() . '.' . $image->getClientOriginalExtension();
        $objKey  = 'productos/' . $name;

        $disk->put($objKey, file_get_contents($image->getRealPath()), 'public');

        return $disk->url($objKey);
    }
}
