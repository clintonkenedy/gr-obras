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
      'obra_id',
      'administrativo_id',
    ];

    public function arch_cronograma()
    {
      return $this->hasOne('App\Models\Archivo', 'arch_cronograma_id');
    }
    public function requerimientos()
    {
      return $this->hasOne('App\Models\Archivo', 'cronograma_req_id');
    }
}
