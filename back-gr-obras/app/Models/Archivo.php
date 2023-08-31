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
    'obra_resolucion_id',
    'obra_kmz_id',
    'arch_cronograma_id',
    'cronograma_req_id',
    'avance_id',
  ];

  public static function AgregarArchivo(Request $request, string $nombre, $archivo = null, $obra_resolucion_id = null, $obra_kmz_id = null, $arch_cronograma_id = null, $cronograma_req_id = null, $avance_id = null)
  {
    if ($request->hasFile($nombre)) {
      // Eliminar archivo.
      // $resolucion_ant = $obra->resolucion;
      if ($archivo && Storage::disk('local')->exists('public/' . $archivo->nombre)) {
        Archivo::destroy($archivo->id);
        Storage::disk('local')->delete('public/' . $archivo->nombre);
      }
      // Crear un nuevo archivo.
      $arhivo = $request->file($nombre);
      // Nombre
      $nombre_archivo = $nombre . Str::random(5) . '.' . $arhivo->getClientOriginalExtension();
      // Guardando archivo
      $arhivo->storeAs('public', $nombre_archivo);

      Archivo::create([
        'extension' => $arhivo->getClientOriginalExtension(),
        'es_plantilla' => false,
        'nombre' => $nombre_archivo,
        'url' => url('storage/' . $nombre_archivo),
        'obra_resolucion_id' => $obra_resolucion_id,
        'obra_kmz_id' => $obra_kmz_id,
        'arch_cronograma_id' => $arch_cronograma_id,
        'cronograma_req_id' => $cronograma_req_id,
        'avance_id' => $avance_id
      ]);
    }
  }
}
