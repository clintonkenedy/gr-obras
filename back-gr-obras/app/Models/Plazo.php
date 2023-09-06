<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plazo extends Model
{
    use HasFactory;

    protected $table = 'plazos';
    protected $fillable = [
      'dura_dias',
      'fec_ini',
      'fec_fin',
      'fecha',
      'comentario',
      'obra_id'
    ];
}
