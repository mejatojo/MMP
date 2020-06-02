<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reference_id');
            $table->foreign('reference_id')->references('id')->on('references');
            $table->integer('quantite');
            $table->datetime('date');
            $table->string('source')->nullable();
            $table->float('hgInit')->nullable();
            $table->integer('kInit')->nullable();
            $table->float('hgFinal')->nullable();
            $table->integer('kFinal')->nullable();
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
        Schema::dropIfExists('stocks');
    }
}
