<?php

namespace App\Http\Controllers;

use App\Models\Archivo;
use App\Models\Avance;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AvanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Avance::paginate($this->getPageSize());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $avance = Avance::create($request->all());
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $f) {
                $nombre = Str::random(5) . '.' . $f->getClientOriginalExtension();
                // Guardando archivo
                $f->storeAs('public', $nombre);
                Archivo::create([
                    'extension' => $f->getClientOriginalExtension(),
                    'es_plantilla' => false,
                    'nombre' => $nombre,
                    'url' => url('storage/' . $nombre),
                    'desc' => pathinfo($f->getClientOriginalName(), PATHINFO_FILENAME),
                    'size' => round($f->getSize() / (1024 * 1024), 2) . 'MB',
                    'avance_id' => $avance->id
                ]);
            }
        }

        return response($avance, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $avance = Avance::with('archivos')->find($id, ['*']);
        return response($avance);
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
        $avance = Avance::find($id);
        $avance->update($request->all());
        if ($request->hasFile('files')) {
            // return response($request->file('files'));
            foreach ($request->file('files') as $f) {
                $nombre = Str::random(5) . '.' . $f->getClientOriginalExtension();
                // Guardando archivo
                $f->storeAs('public', $nombre);
                Archivo::create([
                    'extension' => $f->getClientOriginalExtension(),
                    'es_plantilla' => false,
                    'nombre' => $nombre,
                    'url' => url('storage/' . $nombre),
                    'desc' => pathinfo($f->getClientOriginalName(), PATHINFO_FILENAME),
                    'size' => round($f->getSize() / (1024 * 1024), 2) . 'MB',
                    'avance_id' => $avance->id
                ]);
            }
        }

        return response([$avance, $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Avance::destroy($id);
        return response($id);
    }
}
