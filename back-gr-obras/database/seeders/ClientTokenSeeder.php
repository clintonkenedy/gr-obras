<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientTokenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user = User::create([
            'name' => 'password',
            'email' => 'password@gmail.com',
            'password'=>bcrypt('password'),
        ]);
        $user->assignRole('Administrador');

       DB::table('oauth_clients')->insert([
           'name' => 'Laravel Password Grant Client',
           'secret' => 'e5N7GPJm98afXF0Agc4EINtdZwAMzuv11NdEUkxC',
           'provider' => 'users',
           'redirect' => 'http://localhost',
           'personal_access_client' => 0,
           'password_client' => 1,
           'revoked' => 0,
           // ...
       ]);
    }
}
