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
      'fec',
      'estado',
      'obra_id',
    ];
}
