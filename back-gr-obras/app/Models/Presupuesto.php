<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presupuesto extends Model
{
    use HasFactory;

    protected $table = 'presupuestos';
    protected $fillable = [
      'fec',
      'costo_actualizado',
      'ejec_acumulado',
      'pia',
      'sal_asig',
      'fec_asig',
      'pia_inc',
      'obra_id',
    ];
}
