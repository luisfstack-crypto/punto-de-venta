<?php

namespace App\Services;

use App\Models\Producto;
use App\Models\ProductoImagen;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProductoService
{
    public function crearProducto(array $data): Producto
    {
        $producto = Producto::create([
            'codigo'             => $data['codigo'],
            'nombre'             => $data['nombre'],
            'descripcion'        => $data['descripcion'] ?? null,
            'img_path'           => null,
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

        if (!empty($data['imagenes'])) {
            foreach (array_slice($data['imagenes'], 0, 5) as $orden => $file) {
                $url = $this->uploadImagen($file);
                ProductoImagen::create([
                    'producto_id' => $producto->id,
                    'img_path'    => $url,
                    'orden'       => $orden,
                ]);
                if ($orden === 0) {
                    $producto->update(['img_path' => $url]);
                }
            }
        }

        return $producto;
    }

    public function editarProducto(array $data, Producto $producto): Producto
    {
        $producto->update([
            'codigo'             => $data['codigo'],
            'nombre'             => $data['nombre'],
            'descripcion'        => $data['descripcion'] ?? null,
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

        if (!empty($data['imagenes'])) {
            // Eliminar imágenes viejas de R2
            foreach ($producto->imagenes as $img) {
                $this->deleteImagen($img->img_path);
                $img->delete();
            }

            // Subir nuevas
            foreach (array_slice($data['imagenes'], 0, 5) as $orden => $file) {
                $url = $this->uploadImagen($file);
                ProductoImagen::create([
                    'producto_id' => $producto->id,
                    'img_path'    => $url,
                    'orden'       => $orden,
                ]);
                if ($orden === 0) {
                    $producto->update(['img_path' => $url]);
                }
            }
        }

        return $producto;
    }

    private function uploadImagen(UploadedFile $file): string
    {
        $disk   = Storage::disk(config('filesystems.default'));
        $name   = uniqid() . '.' . $file->getClientOriginalExtension();
        $objKey = 'productos/' . $name;
        $disk->put($objKey, file_get_contents($file->getRealPath()), 'public');
        return $disk->url($objKey);
    }

    private function deleteImagen(string $img_path): void
    {
        $disk   = Storage::disk(config('filesystems.default'));
        $awsUrl = config('filesystems.disks.s3.url');
        $objKey = str_starts_with($img_path, 'http')
            ? ltrim(str_replace($awsUrl, '', $img_path), '/')
            : str_replace('storage/', '', $img_path);
        if ($disk->exists($objKey)) {
            $disk->delete($objKey);
        }
    }
}