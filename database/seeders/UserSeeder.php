<?php

namespace Database\Seeders;

use App\Enums\RoleName;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createDeveloperUser();
    }

    public function createDeveloperUser()
    {
        User::create([
            'first_name' => 'Main',
            'last_name' => 'Developer',
            'email' => 'dev.test@test.com',
            'username' => 'M.Developer',
            'password' => Hash::make('Password'),
        ])
        ->roles()
        ->sync(Role::where('name', RoleName::DEVELOPER->value)->first());

        User::create([
            'first_name' => 'Jhon',
            'last_name' => 'Doe',
            'email' => 'admin.test@test.com',
            'username' => 'J.Doe',
            'password' => Hash::make('Password'),
        ])
        ->roles()
        ->sync(Role::where('name', RoleName::ADMIN->value)->first());

        User::create([
            'first_name' => 'Melissa',
            'last_name' => 'Nelson',
            'email' => 'primary.test@test.com',
            'username' => 'M.Nelson',
            'password' => Hash::make('Password'),
        ])
        ->roles()
        ->sync(Role::where('name', RoleName::Primary->value)->first());

        User::create([
            'first_name' => 'Brianna',
            'last_name' => 'Brooks',
            'email' => 'secondary.test@test.com',
            'username' => 'B.Brooks',
            'password' => Hash::make('Password'),
        ])
        ->roles()
        ->sync(Role::where('name', RoleName::Secondary->value)->first());

        User::create([
            'first_name' => 'Owen',
            'last_name' => 'Bell',
            'email' => 'tertiary.test@test.com',
            'username' => 'O.Bell',
            'password' => Hash::make('Password'),
        ])
        ->roles()
        ->sync(Role::where('name', RoleName::Tertiary->value)->first());
    }
}