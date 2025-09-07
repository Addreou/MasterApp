<?php

namespace Database\Seeders;

use App\Enums\PermissionName;
use App\Enums\RoleName;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'name' => RoleName::DEVELOPER,
            'description' => 'Acceso a cada una de las funcionalidades del sistema. Rol especializado para desarrolladores',
        ])
        ->permissions()
        ->sync(Permission::where('name', PermissionName::FULL_ACCESS->value)->first());

        Role::create([
            'name' => RoleName::ADMIN,
            'description' => 'Acceso restringido. Rol principal para usuarios finales, puede no tener habilitadas funcionalidades muy específicas del sistema.',
        ]);

        Role::create([
            'name' => RoleName::Primary,
            'description' => 'Acceso limitado. Pruebas 1.',
        ]);

        Role::create([
            'name' => RoleName::Secondary,
            'description' => 'Acceso limitado. Pruebas 2.',
        ]);

        Role::create([
            'name' => RoleName::Tertiary,
            'description' => 'Acceso limitado. Pruebas 3.',
        ]);
    }
}
