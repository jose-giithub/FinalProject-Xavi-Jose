<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMensajePrivadoTallerTable extends Migration
{
    /**
     * Migration para crear la tabla 'mensaje_privado_taller' y relacionarla con la tabla 'talleres' y 'users' 
     * usando esta tabla como tabla pivote.
     */
    public function up()
    {
        Schema::create('mensaje_privado_taller', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('taller_id');
            $table->unsignedBigInteger('user_id');
            $table->text('mensaje');
            $table->string('receptor'); // user o taller
            $table->timestamps();

            $table->foreign('taller_id')->references('id')->on('talleres')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mensaje_privado_taller');
    }
};



