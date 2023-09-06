<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Archivo extends Model
{
  use HasFactory;

  protected $table = 'archivos';
  protected $fillable = [
    'extension',
    'es_plantilla',
    'nombre',
    'desc',
    'size',
    'url',
    'obra_id',
    'avance_mes_id',
  ];

  public static function AgregarArchivos(Request $request, $obra_id = null, $avance_mes_id = null)
  {
    if ($request->hasFile('files')) {
      foreach ($request->file('files') as $f) {
        $nombre = Str::random(5) . '.' . $f->getClientOriginalExtension();
        // // Eliminar archivo.
        // if (Storage::disk('local')->exists('public/' . $nombre)) {
        //   Storage::disk('local')->delete('public/' . $nombre);
        // }
        // Guardando archivo
        $f->storeAs('public', $nombre);
        Archivo::updateOrCreate(['nombre' => $nombre,], [
          'extension' => $f->getClientOriginalExtension(),
          'es_plantilla' => false,
          'url' => url('storage/' . $nombre),
          'desc' => pathinfo($f->getClientOriginalName(), PATHINFO_FILENAME),
          'size' => round($f->getSize() / (1024 * 1024), 2) . 'MB',
          'obra_id' => $obra_id,
          'avance_mes_id' => $avance_mes_id
        ]);
      }
    }
  }
}
