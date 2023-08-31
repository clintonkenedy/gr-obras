<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Roles
        $coordinador = Role::firstOrCreate(['name' => 'Coordinador'], ['name' => 'Coordinador']);
        $residente = Role::firstOrCreate(['name' => 'Residente'], ['name' => 'Residente']);
        $economista = Role::firstOrCreate(['name' => 'Economista'], ['name' => 'Economista']);

        //Profesiones
        Permission::firstOrCreate(['name' => 'admin_profesiones'], [
            'name' => 'admin_profesiones',
            'description' => 'Acceder a Profesiones'
        ])->assignRole([$coordinador]);

        //Cargos
        Permission::firstOrCreate(['name' => 'admin_cargos'], [
            'name' => 'admin_cargos',
            'description' => 'Acceder a Cargos'
        ])->assignRole([$coordinador]);
    }
}
