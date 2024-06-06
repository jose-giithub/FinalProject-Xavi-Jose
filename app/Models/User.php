<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;




//añado esto
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Location;
use App\Models\Taller;
use Attribute;
use Carbon\Carbon;

//class User extends Authenticatable
//modifico por esto
class User extends Authenticatable implements MustVerifyEmail
{

    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
    // Añado todo esto para que funcione la data en formato DD/MM/YYYY con carbon
    protected $dates = ['fechaITV', 'fechaUltimaRevision'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_image',
        'fotoPortada',
        // Añado todo esto para que funcione la data en formato DD/MM/YYYY con carbon
        'tipo_vehiculo', 'anoFabricacion', 'marca', 'modelo', 'km', 'cc', 'cv',
        'fechaITV', 'fechaUltimaRevision', 'nomTaller', 'residenciaUser', 'tipo_combustible',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        // Añado todo esto para que funcione la data en formato DD/MM/YYYY con carbon
        'fechaITV' => 'datetime',
        'fechaUltimaRevision' => 'datetime',
    ];
    // Añado todo esto para que funcione la data en formato DD/MM/YYYY con carbon
    protected function fechaITV(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? Carbon::parse($value)->format('d-m-Y') : null,
        );
    }

    protected function fechaUltimaRevision(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? Carbon::parse($value)->format('d-m-Y') : null,
        );
    }

    public function taller()
    {
        return $this->hasOne(Taller::class); // Asumiendo una relación uno a uno
    }

    public function location()
    {
        return $this->hasOne(Location::class); // Asumiendo una relación uno a uno
    }
    /**
     * Get the maintenances for the user.
     */
    public function maintenances()
    {
        return $this->hasMany(\App\Models\VehicleMaintenance::class);
    }

    /**
     * enlacamos la en la BD user con imagenes_carrusel
     */
    public function carouselImages()
    {
        return $this->hasMany(ImagenCarruselMiSeccion::class);
    }

    // public function subscriptions()
    // {
    //     return $this->hasMany(Subscription::class);
    // }

    /*********************************************
     * subscriptions hace referencia a la migracion de la tabla subscriptions, esta tabla es una tabla pivote entre user y taller
     * Método crea la relacion entre User y Taller, un taller puede tener muchos subscriptores y un usuario puede estar subscrito a muchos talleres
     */
    public function subscriptoresTalleres()
    {
        return $this->belongsToMany(Taller::class, 'subscriptions', 'user_id', 'taller_id');//subscriptions los obtiene de la tabla pivote de la base de datos
        
    }

    /**
     * Relacion entre User y MensajePrivadoTaller del taller
     */
    public function mensajesPrivados()
    {
        return $this->hasMany(MensajePrivadoTaller::class);
    }

    /**
     * Relacion entre User y Notificaciones
     */
    public function notifications()
{
    return $this->hasMany(Notification::class, 'user_id');
}
}
