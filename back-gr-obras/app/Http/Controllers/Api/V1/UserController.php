<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
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
            User::query(),
            [],
            ['id', 'name'],
            ['id', 'name']
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        //
        // return "xd";
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        $user->syncRoles($request->rolesSelected);
        return response()->json([$user->save()], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  User  $usuario
     * @return \Illuminate\Http\Response
     */
    public function show(User $usuario)
    {
        //
        // return response()->json($usuario);
        return response()->json([
            'user' => $usuario,
            'rolesSelected' => $usuario->roles->pluck('id'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User  $usuario
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User  $usuario)
    {
        //
        $usuario->syncRoles($request->rolesSelected);
        $usuario->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $usuario->password,
        ]);
        return response()->json($usuario);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User  $usuario
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $usuario)
    {
        //
        return response()->json($usuario->delete());
    }
}
