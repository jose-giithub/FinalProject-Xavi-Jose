<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Taller extends Model
{
    protected $table = 'talleres';

    protected $fillable = [
        'user_id', 'nombre_de_taller', 'ubicacionTaller', 'correo_electronico', 'telefono', 'horario',
        'cafeteria', 'wc', 'elevadores', 'coche_de_cortesia', 'num_mecanicos', 'especialidad', 'image_path',
        'ofertas', 'imagen_oferta', 'destacado',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }

    public function location()
    {
        return $this->hasOne(Location::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function averageRating()
    {
        return $this->ratings()->avg('rating');
    }
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
    // public function followers()
    // {
    //     return $this->belongsToMany(User::class, 'subscriptions', 'taller_id', 'user_id');
    // }

    /*********************************************
     * subscriptions hace referencia a la migracion de la tabla subscriptions, esta tabla es una tabla pivote entre user y taller
     * Método crea la relacion entre User y Taller, un taller puede tener muchos subscriptores y un usuario puede estar subscrito a muchos talleres
     */
    public function misSubscriptores()
    {
        return $this->belongsToMany(User::class, 'subscriptions', 'taller_id', 'user_id');
    }

    /**
     * Método crea la relacion entre Taller y MensajePrivadoTaller, un taller puede tener muchos mensajes privados
     */
    public function mensajesPrivados()
    {
        return $this->hasMany(MensajePrivadoTaller::class);
    }


}
