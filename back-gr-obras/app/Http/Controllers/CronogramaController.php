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
        $cronograma = Cronograma::create([
            'tipo'=>$request->tipo,
            'fec_ini'=>$request->fec_ini,
            'fec_fin'=>$request->fec_fin,
            'presu_req'=>$request->presu_req,
            'num_req'=>$request->num_req,
            'porcentaje'=>$request->porcentaje,
            'monto_adqui'=>$request->monto_adqui,
            'monto_proceso'=>$request->monto_proceso,
            'monto_total'=>$request->monto_total,
            'obra_id'=>$request->obra_id,
            'administrativo_id'=>$request->administrativo_id
        ]);

        Archivo::AgregarArchivo($request, 'arch_cronograma', arch_cronograma_id: $cronograma->id);
        Archivo::AgregarArchivo($request, 'requerimientos', cronograma_req_id: $cronograma->id);

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
        $cronograma = Cronograma::with('arch_cronograma', 'requerimientos')->find($id, ['*']);
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
        //
        $cronograma = Cronograma::find($id);
        $cronograma->update([
            'tipo'=>$data->tipo,
            'fec_ini'=>$data->fec_ini,
            'fec_fin'=>$data->fec_fin,
            'presu_req'=>$data->presu_req,
            'num_req'=>$data->num_req,
            'porcentaje'=>$data->porcentaje,
            'monto_adqui'=>$data->monto_adqui,
            'monto_proceso'=>$data->monto_proceso,
            'monto_total'=>$data->monto_total,
            'obra_id'=>$data->obra_id,
            'administrativo_id'=>$data->administrativo_id
        ]);

        Archivo::AgregarArchivo($request, 'file1', arch_cronograma_id: $cronograma->id, archivo: $cronograma->arch_cronograma);
        Archivo::AgregarArchivo($request, 'file2', cronograma_req_id: $cronograma->id, archivo: $cronograma->requerimientos);

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
