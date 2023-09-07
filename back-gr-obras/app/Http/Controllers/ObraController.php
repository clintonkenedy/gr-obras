<?php

namespace App\Http\Controllers;

use App\Models\Archivo;
use App\Models\Gasto;
use App\Models\Obra;
use App\Models\Presupuesto;
use Carbon\Carbon;
use Exception;
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
        $obra = Obra::create($request->all());
        try {
            $presupuesto = Presupuesto::create($request->presupuesto);
            $presupuesto->fecha = Carbon::now()->toDateTimeString();
            $presupuesto->obra_id = $obra->id;
            $presupuesto->save();
            $gasto = Gasto::create($request->gasto);
            $gasto->presupuesto_id = $presupuesto->id;
            $gasto->save();
            // $gasto = Gasto::create($request->all());
            Archivo::AgregarArchivos($request, obra_id: $obra->id);
            return response($obra, 201);
        } catch (Exception $e) {
            $this->destroy($obra->id);
            return response($e, 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $obra = Obra::find($id);
        $obra->presupuesto->reverse()->first();
        $obra->presupuesto->reverse()->first()->gasto->reverse()->first();
        $obra->files;
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
        $data = json_decode($request->data, true);
        //
        $obra = Obra::find($id);
        $obra->update($data);
        Presupuesto::find($data['presupuesto']['id'])->update($data['presupuesto']);
        Gasto::find($data['gasto']['id'])->update($data['gasto']);

        Archivo::AgregarArchivos($request, obra_id: $obra->id);
        return response([$data, $id]);
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
