<?php

namespace App\Http\Controllers;

use App\Models\Archivo;
use App\Models\Cronograma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CronogramaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Cronograma::paginate($this->getPageSize());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $arch_cronograma = $request->file('archivo_cronograma');
        $arch_requerimientos = $request->file('archivo_requerimientos');
        // Nombre
        $nombre1 = 'cronograma' . $request->obra_id . str_replace('-', '', $request->fec_ini) . Str::random(5) . '.' . $arch_cronograma->getClientOriginalExtension();
        $nombre2 = 'requerimientos' . $request->obra_id . str_replace('-', '', $request->fec_ini) . Str::random(5) . '.' . $arch_requerimientos->getClientOriginalExtension();
        // Guardando archivo
        $arch_cronograma->storeAs('public', $nombre1);
        $arch_requerimientos->storeAs('public', $nombre2);

        Archivo::create([
            'tipo' => $arch_cronograma->getClientOriginalExtension(),
            'nombre' => $nombre1,
            "url" => url('storage/' . $request->nombre)
        ]);
        Archivo::create([
            'tipo' => $arch_requerimientos->getClientOriginalExtension(),
            'nombre' => $nombre2,
            "url" => url('storage/' . $request->nombre)
        ]);
        $cronograma = Cronograma::create([
            'tipo' => $request->tipo,
            'fec_ini' => $request->fec_ini,
            'fec_fin' => $request->fec_fin,
            'presu_req' => $request->presu_req,
            'num_req' => $request->num_req,
            'porcentaje' => $request->porcentaje,
            'monto_adqui' => $request->monto_adqui,
            'monto_proceso' => $request->monto_proceso,
            'monto_total' => $request->monto_total,
            'archivo_cronograma' => $nombre1,
            'archivo_requerimientos' => $nombre2,
            'obra_id' => $request->obra_id,
        ]);
        return response($cronograma, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cronograma = Cronograma::find($id);
        $cronograma->url_cronograma = $cronograma->archivo_cronograma ? url('storage/' . $cronograma->archivo_cronograma) : null;
        $cronograma->url_requerimientos = $cronograma->archivo_requerimientos ? url('storage/' . $cronograma->archivo_requerimientos) : null;
        return response($cronograma, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = json_decode($request->data);
        $nombre1 = $data->archivo_cronograma;
        $nombre2 = $data->archivo_requerimientos;
        //
        if ($request->hasFile('file1')) {
            $arch_cronograma = $request->file('file1');
            // Nombre
            $nombre1 = 'cronograma' . $data->obra_id . str_replace('-', '', $data->fec_ini) . Str::random(5) . '.' . $arch_cronograma->getClientOriginalExtension();
            // Guardando archivo
            $arch_cronograma->storeAs('public', $nombre1);
            Archivo::create([
                'tipo' => $arch_cronograma->getClientOriginalExtension(),
                'nombre' => $nombre1,
                "url" => url('storage/' .  $nombre1)
            ]);
        }
        // 
        if ($request->hasFile('file2')) {
            $arch_requerimientos = $request->file('file2');
            // Nombre
            $nombre2 = 'requerimientos' . $data->obra_id . str_replace('-', '', $data->fec_ini) . Str::random(5) . '.' . $arch_requerimientos->getClientOriginalExtension();
            $arch_requerimientos->storeAs('public', $nombre2);
            Archivo::create([
                'tipo' => $arch_requerimientos->getClientOriginalExtension(),
                'nombre' => $nombre2,
                "url" => url('storage/' . $nombre2)
            ]);
        }

        $cronograma = Cronograma::find($id)->update([
            'tipo' => $data->tipo,
            'fec_ini' => $data->fec_ini,
            'fec_fin' => $data->fec_fin,
            'presu_req' => $data->presu_req,
            'num_req' => $data->num_req,
            'porcentaje' => $data->porcentaje,
            'monto_adqui' => $data->monto_adqui,
            'monto_proceso' => $data->monto_proceso,
            'monto_total' => $data->monto_total,
            'archivo_cronograma' => $nombre1,
            'archivo_requerimientos' => $nombre2,
            'obra_id' => $data->obra_id,
        ]);
        return response([$cronograma, $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Cronograma::destroy($id);
        return response($id);
    }
}
