<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trabajador extends Model
{
  use HasFactory;

  protected $table = 'trabajadores';
  protected $fillable = [
    'profesion',
    'condicion',
    'obra_id',
  ];

  public function cargos()
  {
    return $this->belongsToMany("App\Models\Cargo", "trabajador_cargo");
  }
}
