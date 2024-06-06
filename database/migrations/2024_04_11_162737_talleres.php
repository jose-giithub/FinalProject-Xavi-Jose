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
    Schema::create('talleres', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id');
        $table->string('nombre_de_taller');
        $table->string('ubicacionTaller');
        $table->string('correo_electronico'); // Nuevo campo para la dirección de correo
        $table->string('telefono'); // Nuevo campo para el número de teléfono
        $table->string('horario'); // Nuevo campo para el horario del taller
        $table->boolean('cafeteria')->default(0);
        $table->boolean('wc')->default(0); // Si es solo un indicador de disponibilidad de baños
        $table->integer('elevadores'); // Si es la cantidad de elevadores disponibles
        $table->boolean('coche_de_cortesia')->default(0);
        $table->integer('num_mecanicos');
        $table->string('especialidad');
        $table->string('image_path')->nullable(); // Foto de la sección de los talleres
        $table->text('ofertas')->nullable(); // Campo para almacenar ofertas, opcional
        $table->string('imagen_oferta')->nullable(); // Campo para la ruta de la imagen de la oferta
        $table->boolean('destacado')->default(false); // Añadir el campo 'destacado'
        $table->timestamps();

        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
}




    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
