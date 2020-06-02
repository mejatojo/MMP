<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiculesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicules', function (Blueprint $table) {
            $table->id();
            $table->string('immatriculation');
            $table->string('marque');
            $table->string('model');
            $table->integer('pneu');
            $table->date('derniereMaintenance');
            $table->text('etatPneu')->nullable();
            $table->date('control')->nullable();
            $table->text('refPneus')->nullable();
            $table->string('serrage')->nullable();
            $table->string('type')->nullable();
            $table->text('t1')->nullable();
            $table->text('t2')->nullable();
            $table->integer('kilometrage')->nullable();
            $table->text('etatPneuInit')->nullable();
            $table->date('dernierePerte')->nullable();
            $table->text('hGomme')->nullable();
            $table->unsignedBigInteger('conducteur_id');
             $table->boolean('alert')->default(false);
             $table->date('dateAlert')->nullable();
              $table->boolean('alertP')->default(false);
             $table->date('dateAlertP')->nullable();
             $table->boolean('active')->nullable();
             $table->string('nomH');
             $table->string('emailH')->nullable();
             $table->string('phoneH')->nullable();
             $table->text('information')->nullable();
             $table->date('dateC')->nullable();
            $table->foreign('conducteur_id')->references('id')->on('users');
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
        Schema::dropIfExists('vehicules');
    }
}
