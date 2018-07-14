<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCombustivelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('combustivel', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_fazenda')->unsigned(); 
            $table->integer('id_tipo_combustivel')->unsigned(); 
            $table->float('quantidade')->nullable()->default(0);            
            $table->foreign('id_fazenda')->references('id')->on('fazenda');
            $table->foreign('id_tipo_combustivel')->references('id')->on('tipo_combustivel');
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
        Schema::dropIfExists('combustivel');
    }
}
