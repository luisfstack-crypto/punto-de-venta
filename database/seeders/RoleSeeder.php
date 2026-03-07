<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Vendedor
        $vendedor = Role::firstOrCreate(['name' => 'vendedor']);
        $vendedor->syncPermissions([
            'ver-venta', 'crear-venta', 'mostrar-venta',
            'ver-cliente', 'crear-cliente',
            'ver-perfil', 'editar-perfil',
            'ver-producto',
            'ver-cotizacion', 'crear-cotizacion',
        ]);

        // Cajero
        $cajero = Role::firstOrCreate(['name' => 'cajero']);
        $cajero->syncPermissions([
            'ver-venta', 'crear-venta', 'mostrar-venta',
            'ver-cliente', 'crear-cliente',
            'ver-perfil', 'editar-perfil',
            'ver-producto',
            'ver-caja', 'aperturar-caja', 'cerrar-caja',
        ]);

        // Almacenero
        $almacenero = Role::firstOrCreate(['name' => 'almacenero']);
        $almacenero->syncPermissions([
            'ver-inventario', 'crear-inventario',
            'ver-kardex',
            'ver-producto', 'crear-producto', 'editar-producto',
            'ver-categoria', 'crear-categoria', 'editar-categoria',
            'ver-marca', 'crear-marca', 'editar-marca',
            'ver-compra', 'crear-compra', 'mostrar-compra',
            'ver-proveedore', 'crear-proveedore', 'editar-proveedore',
            'ver-movimiento', 'crear-movimiento',
            'ver-perfil', 'editar-perfil',
        ]);
    }
}
