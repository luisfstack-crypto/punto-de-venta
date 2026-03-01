<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::updateOrCreate(
            ['email' => 'solucionesedgar@gmail.com'],
            [
                'name' => 'Administrador',
                'password' => bcrypt('Soluciones.2026!'),
                'estado' => 1,
                'status' => 'active',
                'empleado_id' => null,
            ]
        );

        $rol = Role::firstOrCreate(['name' => 'administrador']);

        $permisos = Permission::pluck('id', 'id')->all();

        $rol->syncPermissions($permisos);

        $user->assignRole('administrador');
    }
}