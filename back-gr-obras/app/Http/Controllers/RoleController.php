<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Role::paginate(300);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        $rol = Role::create($request->all());
        if (!empty($request->permisosSelected)) {
            $rol->syncPermissions($request->permisosSelected);
        };
        return response()->json([$rol]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rol = Role::find($id);
        $permisos = Permission::select('name')->orderBy('id')->get();
        $permisosRol = $rol->permissions;
        foreach ($permisosRol as $permisoRol) {
            $permisosRolArray[] = $permisoRol->name;
        }
        $permisosSelected = [];
        foreach ($permisos as $permiso) {
            if (!empty($permisosRolArray) && in_array($permiso->name, $permisosRolArray)) {
                $permisosSelected[] = $permiso->name;
            } else {
                $permisosSelected[] = false;
            }
        }
        return response()->json([
            'rol' => $rol,
            'permisosSelected' => $permisosSelected
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, $id)
    {
        $rol = Role::find($id);
        $rol->update($request->all());
        if (!empty($request->permisosSelected)) {
            $rol->syncPermissions($request->permisosSelected);
        }
        return response()->json([$rol]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Role::destroy($id);
        return response()->json([$id]);
    }
}
