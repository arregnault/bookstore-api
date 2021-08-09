<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('roles')->delete();

        Role::create([
            'id' => 1,
            'name' => 'admin',
            'description' => 'Usuario Administrador',
            'is_active' => 1
        ]);
        Role::create([
            'id' => 2,
            'name' => 'reader',
            'description' => 'Usuario Lector',
            'is_active' => 1
        ]);
        Role::create([
            'id' => 3,
            'name' => 'author',
            'description' => 'Usuario Autor',
            'is_active' => 1
        ]);
    }
}
