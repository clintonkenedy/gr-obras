<?php

namespace Database\Seeders;

use App\Models\Obra;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ObraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Obra::create([
            'cui' => 12,
            'meta' => 12,
            'nombre_proyecto' => 'Obra1',
            'sector' => '12',
            'estado_obra' => 'pendiente',
            'dura_dias' => 12,
            'fec_ini' => '2023-01-02',
            'fec_fin' => '2023-01-05',
        ]);
    }
}
