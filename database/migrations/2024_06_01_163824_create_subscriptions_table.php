<?php

// database/migrations/xxxx_xx_xx_create_subscriptions_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Tabla pivote para las suscripciones a talleres
     */
    public function up()
    {

        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('taller_id');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('taller_id')->references('id')->on('talleres')->onDelete('cascade');

            $table->unique(['user_id', 'taller_id']);
        });


    }

    public function down()
    {
        Schema::dropIfExists('subscriptions');
    }

    
        // Schema::create('subscriptions', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('user_id')->constrained()->onDelete('cascade');
        //     $table->foreignId('taller_id')->constrained()->onDelete('cascade');
        //     $table->timestamps();
        // });
}

