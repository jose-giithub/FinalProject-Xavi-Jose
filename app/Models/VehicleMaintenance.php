<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleMaintenance extends Model
{
    use HasFactory;
    //para vincular la tabla user con la de vehicle_maintenances
    protected $fillable = [ 'id','user_id', 'fechaMantenimiento', 'nomDeTaller', 'trabajoRealizado'];
}
