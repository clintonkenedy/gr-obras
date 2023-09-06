<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gasto extends Model
{
  use HasFactory;

  protected $table = 'gastos';

  protected $fillable = [
    'costo_directo',
    'gastos_generales',
    'gastos_supervision',
    'gastos_gest_proyect',
    'gastos_liquidacion',
    'gastos_monito_segui',
    'gastos_elabo_expediente',
    'gastos_evalu_expediente',
    'presupuesto_id'
  ];

  public function obras()
  {
    return $this->belongsToMany("App\Models\Obras", "gasto_presupuesto_obra");
  }
}
