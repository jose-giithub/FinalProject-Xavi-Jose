<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    protected $table = 'comentarios';  // Asegurarse de que el modelo use la tabla correcta

    // Definir los atributos que pueden ser asignados masivamente
    protected $fillable = ['user_id', 'taller_id', 'contenido'];

    // Relación con el modelo User
    // En el modelo Comentario
    public function taller()
    {
        return $this->belongsTo(Taller::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
