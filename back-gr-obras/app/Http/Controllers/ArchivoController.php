<?php

namespace App\Http\Controllers;

use App\Models\Archivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArchivoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Archivo::paginate($this->getPageSize());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nombre = $request->file('file');
        // Nombre
        $nombre1 = 'cronograma' . Str::random(5) . '.' . $nombre->getClientOriginalExtension();
        // Guardando archivo
        $nombre->storeAs('public', $nombre1);
        
        $archivo = Archivo::create([
            "tipo" => $nombre->getClientOriginalExtension(),
            "nombre" => $nombre1,
            "url" => url('storage/' . $nombre1)
        ]);
        return response($archivo, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response(Archivo::find($id));
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
        //
        $archivo = Archivo::find($id);
        if (Storage::disk('local')->exists('public/' . $archivo->nombre)) {
            Storage::disk('local')->delete('public/' . $archivo->nombre);
        }
        $nombre = $request->file('file');
        // Nombre
        $nombre1 = 'cronograma' . Str::random(5) . '.' . $nombre->getClientOriginalExtension();
        // Guardando archivo
        $nombre->storeAs('public', $nombre1);
        
        $archivo = Archivo::find($id)->update([
            "tipo" => $nombre->getClientOriginalExtension(),
            "nombre" => $nombre1,
            "url" => url('storage/' . $nombre1)
        ]);

        return response([$archivo, $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $archivo = Archivo::find($id);
        Archivo::destroy($archivo->id);
        if (Storage::disk('local')->exists('public/' . $archivo->nombre)) {
            Storage::disk('local')->delete('public/' . $archivo->nombre);
        }
        return response($id);
    }
}
