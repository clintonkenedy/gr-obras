<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Valorizacion extends Model
{
    use HasFactory;

    protected $table = 'valorizaciones';
    protected $fillable = [
      'tipo',
      'tot_aprobado',
      'cd',
      'anterior',
      'actual',
      'acumulado',
      'saldo',
      'acum_porc',
      'saldo_porc',
      'obra_id',
    ];
}
