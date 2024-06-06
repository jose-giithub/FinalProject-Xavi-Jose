<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MensajePrivadoTaller extends Model
{
    use HasFactory;
    protected $table = 'mensaje_privado_taller';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'taller_id',
        'user_id',
        'mensaje',
        'receptor'
    ];

    /**
     * Relaciono el modelo con la tabla 'talleres' y 'users' usando esta tabla como tabla pivote.
     * un taller puede tener muchos mensajes privados y un mensaje privado pertenece a un solo taller.
     */
    public function taller()
    {
        return $this->belongsTo(Taller::class);
    }

    /**
     * Relaciono el modelo con la tabla 'users' y 'talleres' usando esta tabla como tabla pivote.
     * un usuario puede tener muchos mensajes privados y un mensaje privado pertenece a un solo usuario.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
