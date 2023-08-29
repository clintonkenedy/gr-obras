<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
  use HasFactory;

  protected $table = 'cargos';
  protected $fillable = [
    'nombre',
  ];

  public function trabajadores()
  {
    return $this->belongsToMany("App\Models\Trabajador", "trabajador_cargo");
  }
}
