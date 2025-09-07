<?php

namespace Database\Seeders;

use App\Enums\PermissionName;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create([
            'name' => PermissionName::FULL_ACCESS->value,
            'description' => 'Acceso Total.',
        ]);

        Permission::create([
            'name' => 'dashboard',
            'description' => 'Página Principal.',
        ]);

        Permission::create([
            'name' => 'admin.config',
            'description' => 'Panel de Control.',
        ]);

        /* Usuarios */

        Permission::create([
            'name' => 'user.create',
            'description' => 'Usuario: Permite el acceso al formulario correspondiente.',
        ]);

        Permission::create([
            'name' => 'user.store',
            'description' => 'Usuario: Permite el procesamiento del formulario correspondiente y su almacenamiento de datos.',
        ]);

        Permission::create([
            'name' => 'user.edit',
            'description' => 'Usuario: Permite el acceso y la visualización de datos del formulario correspondiente.',
        ]);

        Permission::create([
            'name' => 'user.update',
            'description' => 'Usuario: Permite el procesamiento del formulario correspondiente y su actualización de datos.',
        ]);

        Permission::create([
            'name' => 'user.delete',
            'description' => 'Usuario: Permite la eliminación de datos (dar baja lógica).',
        ]);

        Permission::create([
            'name' => 'user.restore',
            'description' => 'Usuario: Permite la restauración de datos (recuperar baja lógica).',
        ]);

        /* Roles */

        Permission::create([
            'name' => 'role.create',
            'description' => 'Rol: Permite el acceso al formulario correspondiente.',
        ]);

        Permission::create([
            'name' => 'role.store',
            'description' => 'Rol: Permite el procesamiento del formulario correspondiente y su almacenamiento de datos.',
        ]);

        Permission::create([
            'name' => 'role.edit',
            'description' => 'Rol: Permite el acceso y la visualización de datos del formulario correspondiente.',
        ]);

        Permission::create([
            'name' => 'role.update',
            'description' => 'Rol: Permite el procesamiento del formulario correspondiente y su actualización de datos.',
        ]);

        Permission::create([
            'name' => 'role.delete',
            'description' => 'Rol: Permite la eliminación de datos (dar baja lógica).',
        ]);

        Permission::create([
            'name' => 'role.restore',
            'description' => 'Rol: Permite la restauración de datos (recuperar baja lógica).',
        ]);

        /* Permisos */

        Permission::create([
            'name' => 'permission.grants',
            'description' => 'Permisos: Permite la visualización del formulario correspondiente a los permisos de un rol especificado.',
        ]);

        Permission::create([
            'name' => 'permission.toggle',
            'description' => 'Permisos: Permite el procesamiento de los datos, almacenando o eliminando los permisos asignados al rol especificado.',
        ]);

        Permission::create([
            'name' => 'permission.create',
            'description' => 'Permiso: Permite el acceso al formulario correspondiente.',
        ]);

        Permission::create([
            'name' => 'permission.store',
            'description' => 'Permiso: Permite el procesamiento del formulario correspondiente y su almacenamiento de datos.',
        ]);

        Permission::create([
            'name' => 'permission.edit',
            'description' => 'Permiso: Permite el acceso y la visualización de datos del formulario correspondiente.',
        ]);

        Permission::create([
            'name' => 'permission.update',
            'description' => 'Permiso: Permite el procesamiento del formulario correspondiente y su actualización de datos.',
        ]);

        Permission::create([
            'name' => 'permission.delete',
            'description' => 'Permiso: Permite la eliminación de datos (dar baja lógica).',
        ]);

        Permission::create([
            'name' => 'permission.restore',
            'description' => 'Permiso: Permite la restauración de datos (recuperar baja lógica).',
        ]);
    }
}
