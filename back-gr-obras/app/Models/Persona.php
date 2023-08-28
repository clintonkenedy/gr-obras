<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
  use HasFactory;

  protected $table = 'personas';
  protected $fillable = [
    'tipo_doc',
    'num_doc',
    'nombres',
    'a_paterno',
    'a_materno',
    'nombre_completo',
    'email',
    'direccion',
    'celular',
    'administrativo_id',
    'trabajador_id',
    'ubigeo_id',
  ];

  public function profesiones()
  {
    return $this->belongsToMany("App\Models\Profesion", "persona_profesion");
  }
}
