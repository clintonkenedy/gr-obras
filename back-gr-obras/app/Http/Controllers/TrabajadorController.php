<?php

namespace App\Http\Controllers;

use App\Http\Requests\TrabajadorRequest;
use App\Models\Persona;
use App\Models\Profesion;
use App\Models\Trabajador;
use Illuminate\Http\Request;

class TrabajadorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->generateViewSetList(
            $request,
            Trabajador::query()
                ->leftJoin('personas', 'trabajadores.id', '=', 'personas.trabajador_id')
                ->leftJoin('obras', 'trabajadores.obra_id', '=', 'obras.id')
                ->select('trabajadores.*', 'personas.nombre_completo AS persona', 'obras.nombre_proyecto AS obra'),
            [],
            ['id', 'obras.nombre_proyecto', 'personas.nombre_completo', 'profesion', 'cargo', 'condicion'],
            ['id', 'obras.nombre_proyecto', 'personas.nombre_completo', 'profesion', 'cargo', 'condicion']
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TrabajadorRequest $request)
    {
        $request->validated();
        $trabajador = Trabajador::create($request->all());
        Persona::find($request->persona_id)->update([
            'trabajador_id' => $trabajador->id,
        ]);
        $trabajador_cargo = [];
        $trabajador_cargo[] = [
            'trabajador_id' => $trabajador->id,
            'cargo_id' => $request->cargo_id,
        ];
        $trabajador->cargos()->sync($trabajador_cargo);
        return response($trabajador, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $trabajador = Trabajador::find($id);
        $trabajador->persona_id = Persona::where('trabajador_id', $trabajador->id)->first()->id;
        $trabajador->profesion_id = Profesion::where('nombre', $trabajador->profesion)->first()->id;
        $trabajador->cargo_id = count($trabajador->cargos) != 0 ? $trabajador->cargos[0]->id : null;
        return response($trabajador);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TrabajadorRequest $request, $id)
    {
        $request->validated();
        $trabajador = Trabajador::find($id);
        $trabajador->update($request->all());
        Persona::find($request->persona_id)->update([[
            'trabajador_id' => $trabajador->id,
        ]]);
        $trabajador_cargo = [];
        $trabajador_cargo[] = [
            'trabajador_id' => $trabajador->id,
            'cargo_id' => $request->cargo_id,
        ];
        $trabajador->cargos()->sync($trabajador_cargo);
        return response($trabajador);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Trabajador::destroy($id);
        return response($id);
    }
}
