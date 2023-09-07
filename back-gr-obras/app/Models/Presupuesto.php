<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presupuesto extends Model
{
    use HasFactory;

    protected $table = 'presupuestos';
    protected $fillable = [
      'ppto',
      'adicional',
      'ejecutado',
      'saldo',
      'fecha',
      'obra_id',
    ];
    public function gasto()
    {
      return $this->hasMany("App\Models\Gasto", "presupuesto_id");
    }
}
