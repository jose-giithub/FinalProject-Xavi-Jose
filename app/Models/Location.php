<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'taller_id',
        'street',
        'city',
        'postal_code',
        'latitude',
        'longitude'
    ];

    public function taller()
    {
        return $this->belongsTo(Taller::class);
    }
}
