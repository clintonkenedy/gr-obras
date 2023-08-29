<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

use App\Http\Requests\PermisoRequest;
class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // if($request->input('rowsPerPage')==0){
        //     return response()->json([
        //         'data'=>Profesion::all()
        //     ]
        //     );

        // }else{
        //     return Profesion::paginate($request->input('rowsPerPage'));

        // }
        return $this->generateViewSetList(
            $request,
            Permission::query(),
            [],
            ['id','name'],
            ['id','name','description']
          );
        // return $request->filled('all');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermisoRequest $request)
    {
        return response(Permission::create($request->all()), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response(Permission::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PermisoRequest $request, $id)
    {
        Permission::find($id)->update($request->all());
        return response([$request, $id]);
        // return $request;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Permission::destroy($id);
        return response($id);
    }
}
