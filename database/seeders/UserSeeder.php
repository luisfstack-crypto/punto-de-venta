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
        // Creamos el usuario Administrador por defecto
        $user = User::create([
            'name' => 'Administrador',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678'),
            'estado' => 1,
            'empleado_id' => null,
        ]);

        // Creamos el rol de administrador
        $rol = Role::create(['name' => 'administrador']);

        // Obtenemos todos los permisos generados por el PermissionSeeder
        $permisos = Permission::pluck('id', 'id')->all();

        // Sincronizamos el rol con todos los permisos del sistema
        $rol->syncPermissions($permisos);

        // Asignamos el rol de administrador a tu usuario
        $user->assignRole('administrador');
    }
}