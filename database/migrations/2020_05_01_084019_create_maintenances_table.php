<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenances', function (Blueprint $table) {
            $table->id();
            $table->datetime('debut')->nullable();
            $table->datetime('fin')->nullable();
            $table->text('operations')->nullable();
            $table->text('observations')->nullable();
             $table->unsignedBigInteger('rdv_id');
             $table->string('facture')->nullable();
            $table->foreign('rdv_id')->references('id')->on('rendez_vous');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('maintenances');
    }
}
