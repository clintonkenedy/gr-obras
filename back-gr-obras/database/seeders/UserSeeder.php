<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'coordinador',
            'email' => 'coordinador@gmail.com',
            'password' => bcrypt('coordinador'),
            'tipo' => 'COORDINADOR',
            'profesion' => 'ADMINISTRADOR DE EMPRESAS',
            'condicion' => ''
        ]);
        $user->assignRole('Coordinador');

        $user = User::create([
            'name' => 'residente',
            'email' => 'residente@gmail.com',
            'password' => bcrypt('residente'),
            'tipo' => 'RESIDENTE',
            'profesion' => 'ADMINISTRADOR DE EMPRESAS',
            'condicion' => ''
        ]);
        $user->assignRole('Residente');

        $user = User::create([
            'name' => 'economista',
            'email' => 'economista@gmail.com',
            'password' => bcrypt('economista'),
            'tipo' => 'ECONOMISTA',
            'profesion' => 'ADMINISTRADOR DE EMPRESAS',
            'condicion' => ''
        ]);
        $user->assignRole('Economista');
    }
}
