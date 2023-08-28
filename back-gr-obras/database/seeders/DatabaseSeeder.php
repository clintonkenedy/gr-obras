<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Persona;
use App\Models\Profesion;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Persona::firstOrCreate(['tipo_doc' => 'DNI'],[
        //     'num_doc' => '123456789',
        //     'accion' => '/configuraciones',
        //     'icon_class' => 'mdi mdi-cog',
        //     'es_menu' => false,
        //     'permiso_req' => 'admin_configuraciones'
        // ]);
        // \App\Models\User::factory(10)->create();
        Profesion::factory(100)->create();
        Persona::factory(100)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            PermissionSeeder::class,
            ClientTokenSeeder::class,
        ]);
    }
}
