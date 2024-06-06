<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = ['user_id', 'taller_id', 'rating'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function taller()
    {
        return $this->belongsTo(Taller::class);
    }
}
