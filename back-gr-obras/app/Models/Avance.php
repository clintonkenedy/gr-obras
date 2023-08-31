<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avance extends Model
{
    use HasFactory;

    protected $table = 'avances';
    protected $fillable = [
      'tipo',
      'fecha',
      'estado',
      'avance_fisico_km',
      'avance_fisico_npisos',
      'avance_fisico_metros',
      'avance_fisico_otros',
      'avance_financiero',
      'obra_id',
      'cronograma_id'
    ];

    public function archivos(){
      return $this->hasMany('App\Models\Archivo', 'avance_id');
    }
}
