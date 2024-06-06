<?php

// app/Models/Notification.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'follower_id',
        'taller_id',
        'read',
        'message', // Añadimos este campo para el mensaje de la notificación para itv y revisión
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function follower()
    {
        return $this->belongsTo(User::class, 'follower_id');
    }

    public function taller()
    {
        return $this->belongsTo(Taller::class);
    }
}
