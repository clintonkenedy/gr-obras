<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvanceMes extends Model
{
    use HasFactory;

    protected $table = 'avance_meses';
    protected $fillable = [
          'codigo',
          'sum_programado',
          'sum_fisico',
          'sum_financiero',
          'saldo',
          'obra_id',
    ];

    public function obra()
    {
      return $this->hasOne('App\Models\Obra');
    }

    public function avances()
    {
      return $this->hasMany('App\Models\Avance', 'avance_mes_id');
    }

    public function files()
    {
      return $this->hasMany('App\Models\Archivo', 'avance_mes_id');
    }
}
