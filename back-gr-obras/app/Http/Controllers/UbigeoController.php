<?php

namespace App\Http\Controllers;

use App\Models\Ubigeo;

class UbigeoController extends Controller
{
    public function getDepartamentos()
    {
        return response(
            Ubigeo::select('ndep', 'nombre')->where('tipo', 'de')->get(),
            200,
            ['cache-control' => 'private, max-age=604800'] // Guardar una semana
        );
    }

    public function getProvincias()
    {
        return response(
            Ubigeo::select('ndep', 'nprov', 'nombre')->where('tipo', 'PR')->get(),
            200,
            ['cache-control' => 'private, max-age=604800'] // Guardar una semana
        );
    }

    public function getDistritos()
    {
        return response(
            Ubigeo::select('ndep', 'nprov', 'ndist', 'nombre')->where('tipo', 'DI')->get(),
            200,
            ['cache-control' => 'private, max-age=604800'] // Guardar una semana
        );
    }
}
