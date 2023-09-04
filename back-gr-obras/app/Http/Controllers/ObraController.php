<?php

namespace App\Http\Controllers;

use App\Models\Archivo;
use App\Models\Obra;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ObraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Obra::paginate($this->getPageSize());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $obra = Obra::create([
            'cui' => $request->cui,
            'meta' => $request->meta,
            'nombre_proyecto' => $request->nombre_proyecto,
            'sector' => $request->sector,
            'estado_obra' => $request->estado_obra,
            'dura_dias' => $request->dura_dias,
            'fec_ini' => $request->fec_ini,
            'fec_fin' => $request->fec_fin,
            'ubigeo_cod' => $request->ubigeo_cod,
            'coordinador_id' => $request->coordinador_id,
            'residente_id' => $request->residente_id,
            'economista_id' => $request->economista_id,
        ]);

        Archivo::AgregarArchivos($request, obra_id: $obra->id);
        return response($obra, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $obra = Obra::with('files')->find($id, ['*']);
        return response($obra, 200);
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
        //
        $obra = Obra::find($id);
        $obra->update([
            'cui' => $data->cui,
            'meta' => $data->meta,
            'nombre_proyecto' => $data->nombre_proyecto,
            'sector' => $data->sector,
            'estado_obra' => $data->estado_obra,
            'dura_dias' => $data->dura_dias,
            'fec_ini' => $data->fec_ini,
            'fec_fin' => $data->fec_fin,
            'ubigeo_cod' => $data->ubigeo_cod,
            'coordinador_id' => $data->coordinador_id,
            'residente_id' => $data->residente_id,
            'economista_id' => $data->economista_id,
        ]);

        Archivo::AgregarArchivos($request, obra_id: $obra->id);
        return response([$obra, $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Obra::destroy($id);
        return response($id);
    }
}
