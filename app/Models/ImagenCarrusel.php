<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImagenCarrusel extends Model
{
    protected $table = 'imagenes_carrusel';
    protected $fillable = ['taller_id', 'ruta'];

    public function taller()
    {
        return $this->belongsTo(Taller::class);
    }
  
}
