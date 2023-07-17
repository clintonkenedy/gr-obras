<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfesionRequest;
use App\Models\Profesion;
use Illuminate\Http\Request;

class ProfesionController extends Controller
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
            Profesion::query(),
            [],
            ['id','nombre'],
            ['id','nombre']
          );
        // return $request->filled('all');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProfesionRequest $request)
    {
        return response(Profesion::create($request->all()), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response(Profesion::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProfesionRequest $request, $id)
    {
        Profesion::find($id)->update($request->all());
        return response([$request, $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Profesion::destroy($id);
        return response($id);
    }
}
