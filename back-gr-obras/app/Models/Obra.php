<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obra extends Model
{
  use HasFactory;

  protected $table = 'obras';
  protected $fillable = [
    'cui',
    'meta',
    'nombre_proyecto',
    'sector',
    'estado_obra',
    'dura_dias',
    'fec_ini',
    'fec_fin',
    'ubigeo_cod',
    'coordinador_id',
    'residente_id',
    'economista_id',
  ];

  public function obras()
  {
    return $this->belongsToMany("App\Models\Gasto", "gasto_presupuesto_obra");
  }
}
