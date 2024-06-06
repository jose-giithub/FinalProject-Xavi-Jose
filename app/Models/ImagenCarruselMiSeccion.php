<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImagenCarruselMiSeccion extends Model
{
    use HasFactory;
    // Define la tabla asociada al modelo.
    protected $table = 'imagenes_carrusel_mi_seccion';

    // Define los campos que se pueden asignar masivamente.
    protected $fillable = ['user_id', 'ruta'];

    /**
     * Relación de pertenencia a un usuario.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo La relación de pertenencia.
     */
    public function user()
    {
        // Define la relación con el modelo User.
        return $this->belongsTo(User::class);
    }
 
}