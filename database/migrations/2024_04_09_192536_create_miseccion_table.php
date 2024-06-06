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
        // Schema::table('miseccion', function (Blueprint $table) {
        //     $table->timestamps();
        // });
        Schema::create('miseccion', function (Blueprint $table) {
            $table->id(); // Este es el ID primario, típicamente necesario.
            $table->timestamps(); // Crea las columnas `created_at` y `updated_at`.
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('miseccion');
        Schema::table('miseccion', function (Blueprint $table) {
            $table->dropTimestamps();
        });
      
    }
};
