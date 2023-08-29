<?php

namespace App\Http\Controllers;

use App\Http\Requests\Persona\PersonaStoreRequest;
use App\Http\Requests\Persona\PersonaUpdateRequest;
use App\Models\Persona;
use Illuminate\Http\Request;

class PersonaController extends Controller
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
            Persona::query(),
            [],
            ['id', 'tipo_doc', 'num_doc', 'nombres', 'a_paterno', 'a_materno', 'nombre_completo'],
            ['id', 'tipo_doc', 'num_doc', 'nombres', 'a_paterno', 'a_materno']
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PersonaStoreRequest $request)
    {
        $persona = Persona::create($request->all());
        $profesiones = $request->input('profesiones');
        $persona_profesion = [];
        for ($i = 0; $i < count($profesiones); $i++) {
            $persona_profesion[] = [
                'persona_id' => $persona->id,
                'profesion_id' => $profesiones[$i]['id'],
            ];
        }
        $persona->profesiones()->sync($persona_profesion);
        return response($persona, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $persona = Persona::find($id);
        $persona->profesiones = $persona->profesiones;
        return response($persona);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PersonaUpdateRequest $request, $id)
    {
        $persona = Persona::find($id);
        $persona->update($request->all());
        $profesiones = $request->input('profesiones');
        $persona_profesion = [];
        for ($i = 0; $i < count($profesiones); $i++) {
            $persona_profesion[] = [
                'persona_id' => $persona->id,
                'profesion_id' => $profesiones[$i]['id'],
            ];
        }
        $persona->profesiones()->sync($persona_profesion);
        return response($persona);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Persona::destroy($id);
        return response($id);
    }
}
