<?php

namespace Database\Seeders;

use App\Models\Empresa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Empresa::updateOrCreate(
            ['ruc' => '1234567890'],
            [
                'nombre' => 'Mi Empresa',
                'propietario' => 'Propietario',
                'porcentaje_impuesto' => '15',
                'abreviatura_impuesto' => 'IGV',
                'direccion' => 'Dirección de la Empresa',
                'moneda_id' => 1
            ]
        );
    }
}
