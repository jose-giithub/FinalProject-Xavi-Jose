<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('taller')->default(false); // Agrega el campo taller con valor predeterminado false
            $table->string('profile_image')->nullable();//foto perfil
            $table->string('fotoPortada')->nullable(); // foto cabecera en la vista miSeccion
            $table->string('tipo_vehiculo')->nullable();//tipo de vehículo
            $table->integer('anoFabricacion')->nullable();//tipo de vehículo
            $table->string('marca')->nullable()->nullable();//  marca del vehículo modelo
            $table->string('modelo')->nullable();//  marca del vehículo modelo
            $table->integer('km')->nullable();//KM
            $table->integer('cc')->nullable();//CC
            $table->integer('cv')->nullable();//cv
            $table->date('fechaITV')->nullable();//fecha ITV
            $table->date('fechaUltimaRevision')->nullable();//fecha ITV
            $table->string('nomTaller')->nullable();//nombre del taller
            $table->string('residenciaUser')->nullable();//nombre del taller
            $table->string('tipo_combustible')->nullable();//tipo de vehículo  anoFabricacion
            $table->rememberToken();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
