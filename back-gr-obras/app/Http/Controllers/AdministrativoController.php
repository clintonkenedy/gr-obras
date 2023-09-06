<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdministrativoRequest;
use App\Models\Persona;
use App\Models\Profesion;
use App\Models\User;
use Illuminate\Http\Request;

class AdministrativoController extends Controller
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
            User::query()
                ->leftJoin('personas', 'users.id', '=', 'personas.administrativo_id')
                ->select('users.*', 'personas.nombre_completo AS persona'),
            [],
            ['id', 'tipo', 'name', 'email', 'profesion', 'condicion', 'personas.nombre_completo'],
            ['id', 'tipo', 'name', 'email', 'profesion', 'condicion', 'personas.nombre_completo']
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdministrativoRequest $request)
    {
        $request->validated();
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'tipo' => $request->tipo,
            'profesion' => $request->profesion,
            'condicion' => $request->condicion
        ]);
        Persona::find($request->persona_id)->update([
            'administrativo_id' => $user->id,
        ]);
        $user->syncRoles($request->rolesSelected);
        return response()->json([$user->save()], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::leftJoin('personas', 'users.id', '=', 'personas.administrativo_id')
            ->select('users.*', 'personas.id AS persona_id', 'personas.nombre_completo AS persona')
            ->where('users.id', $id)
            ->first();
        $user->profesion_id = Profesion::where('nombre', $user->profesion)->first()->id;
        return response()->json([
            'user' => $user,
            'rolesSelected' => $user->roles->pluck('id'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdministrativoRequest $request, $id)
    {
        $request->validated();
        $user = User::find($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
            'tipo' => $request->tipo,
            'profesion' => $request->profesion,
            'condicion' => $request->condicion
        ]);
        $user->syncRoles($request->rolesSelected);
        Persona::find($request->persona_id)->update([
            'administrativo_id' => $request->id,
        ]);
        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        return response()->json($user->delete());
    }
}
