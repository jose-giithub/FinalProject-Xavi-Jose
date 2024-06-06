<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->unsignedBigInteger('follower_id')->nullable()->change(); // Hacer nullable
            $table->unsignedBigInteger('taller_id')->nullable()->change(); // Hacer nullable
            $table->text('message')->nullable(); // Añadir la columna 'message'
        });

    }

 /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->unsignedBigInteger('follower_id')->nullable(false)->change(); // Revertir a no nullable
            $table->unsignedBigInteger('taller_id')->nullable(false)->change(); // Revertir a no nullable
            $table->dropColumn('message'); // Eliminar la columna 'message'
        });
    }
}
// return new class extends Migration
// {
//     /**
//      * Run the migrations.
//      */
//     public function up(): void
//     {
//         Schema::table('notifications', function (Blueprint $table) {
//             //
//         });
//     }

//     /**
//      * Reverse the migrations.
//      */
//     public function down(): void
//     {
//         Schema::table('notifications', function (Blueprint $table) {
//             //
//         });
//     }
// };
