<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('imagenes_carrusel', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('taller_id');
            $table->string('ruta'); // Ruta de la imagen
            $table->timestamps();

            // Llave foránea para asociar las imágenes al taller
            $table->foreign('taller_id')->references('id')->on('talleres')->onDelete('cascade');
        });
    }





    public function down(): void
    {
        Schema::dropIfExists('imagenes_carrusel');
    }
};
