<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ubigeo extends Model
{
    use HasFactory;

    protected $table = 'ubigeos';
    protected $fillable = [
      'codigo',
      'tipo',
      'cod_dist',
      'cod_prov',
      'cod_dep',
      'nombre',
    ];
}
