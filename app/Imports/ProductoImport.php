<?php

namespace App\Imports;

use App\Models\Categoria;
use App\Models\Marca;
use App\Models\Presentacione;
use App\Models\Producto;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class ProductoImport implements ToCollection, WithHeadingRow, SkipsEmptyRows
{
    public array $errors  = [];
    public int   $imported = 0;

    public function collection(Collection $rows): void
    {
        foreach ($rows as $index => $row) {
            $fila = $index + 2; 
            $validator = Validator::make($row->toArray(), [
                'nombre' => 'required|string|max:255',
                'precio' => 'required|numeric|min:0',
            ], [
                'nombre.required' => "Fila {$fila}: El nombre es obligatorio.",
                'precio.required' => "Fila {$fila}: El precio es obligatorio.",
                'precio.numeric'  => "Fila {$fila}: El precio debe ser un número.",
            ]);

            if ($validator->fails()) {
                foreach ($validator->errors()->all() as $error) {
                    $this->errors[] = $error;
                }
                continue;
            }

            $categoriaId    = null;
            $marcaId        = null;
            $presentacionId = null;

            if (!empty($row['categoria'])) {
                $cat = Categoria::whereRaw('LOWER(nombre) = ?', [strtolower(trim($row['categoria']))])->first();
                $categoriaId = $cat?->id;
                if (!$cat) {
                    $this->errors[] = "Fila {$fila}: Categoría '{$row['categoria']}' no encontrada (se omite).";
                }
            }

            if (!empty($row['marca'])) {
                $marca = Marca::whereRaw('LOWER(nombre) = ?', [strtolower(trim($row['marca']))])->first();
                $marcaId = $marca?->id;
                if (!$marca) {
                    $this->errors[] = "Fila {$fila}: Marca '{$row['marca']}' no encontrada (se omite).";
                }
            }

            if (!empty($row['presentacion'])) {
                $pres = Presentacione::whereRaw('LOWER(nombre) = ?', [strtolower(trim($row['presentacion']))])->first();
                $presentacionId = $pres?->id;
            }

            if (!$presentacionId) {
                $presentacionId = Presentacione::first()?->id;
            }

            if (!$presentacionId) {
                $this->errors[] = "Fila {$fila}: No se encontró presentación. Crea al menos una presentación en el sistema.";
                continue;
            }

            Producto::create([
                'nombre'          => trim($row['nombre']),
                'descripcion'     => $row['descripcion'] ?? null,
                'precio'          => $row['precio'],
                'codigo'          => !empty($row['codigo']) ? trim($row['codigo']) : null,
                'categoria_id'    => $categoriaId,
                'marca_id'        => $marcaId,
                'presentacione_id'=> $presentacionId,
                
                'facturable'      => !empty($row['facturable']) && strtolower($row['facturable']) === 'si',
                'clave_producto_sat' => $row['clave_producto_sat'] ?? null,
                'clave_unidad_sat'   => $row['clave_unidad_sat'] ?? null,
                'unidad_medida'      => $row['unidad_medida'] ?? null,
                'tasa_cuota'         => $row['tasa_cuota'] ?? null,
            ]);

            $this->imported++;
        }
    }
}
