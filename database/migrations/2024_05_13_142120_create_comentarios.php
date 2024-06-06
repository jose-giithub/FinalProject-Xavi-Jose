<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('comentarios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // ID del usuario que hace el comentario
            $table->unsignedBigInteger('taller_id'); // ID del taller al que se hace el comentario
            $table->text('contenido'); // Contenido del comentario
            $table->timestamps();

            // Relación con la tabla 'users'
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // Relación con la tabla 'talleres'
            $table->foreign('taller_id')->references('id')->on('talleres')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comentarios');
    }
};
