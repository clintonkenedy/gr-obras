<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avance extends Model
{
  use HasFactory;

  protected $table = 'avances';
  protected $fillable = [
    // 'num_semana',
    'codigo',
    'codigo_semana',

    'monto_prog',
    'porcentaje_prog',
    'acum_prog',

    'monto_fisic',
    'porcentaje_fisc',
    'acum_fisc',

    'monto_finan',
    'porcentaje_finan',
    'acum_finan',

    'avance_mes_id'
  ];
}
