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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('taller_id');
            $table->string('street');
            $table->string('city');
            $table->string('postal_code');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->timestamps(); // Crea automáticamente las columnas created_at y updated_at

            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('taller_id')->references('id')->on('talleres')->onDelete('cascade');
        });
    }

    // public function up(): void
    // {
    //     Schema::create('locations', function (Blueprint $table) {
    //         $table->id();
    //         $table->unsignedBigInteger('taller_id');
    //         $table->string('street');
    //         $table->string('city');
    //         $table->string('postal_code');
    //         $table->decimal('latitude', 10, 7);
    //         $table->decimal('longitude', 10, 7);
    //         $table->timestamps();

    //         $table->foreign('taller_id')->references('id')->on('talleres')->onDelete('cascade');
    //     });
    // }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
