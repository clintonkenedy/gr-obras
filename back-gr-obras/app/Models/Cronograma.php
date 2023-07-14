<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cronograma extends Model
{
    use HasFactory;

    protected $table = 'cronogramas';
    protected $fillable = [
      'tipo',
      'fec_ini',
      'fec_fin',
      'presu_req',
      'num_req',
      'porcentaje',
      'monto_adqui',
      'monto_proceso',
      'monto_total',
      'archivo_cronograma',
      'archivo_requerimientos',
      'obra_id',
    ];
}
