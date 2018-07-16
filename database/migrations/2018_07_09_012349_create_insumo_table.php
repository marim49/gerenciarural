<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInsumoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insumo', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_celeiro')->unsigned(); 
            $table->integer('id_tipo_insumo')->unsigned(); 
            $table->integer('quantidade')->default(0);    
            $table->foreign('id_celeiro')->references('id')->on('celeiro');
            $table->foreign('id_tipo_insumo')->references('id')->on('tipo_insumo');
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
        Schema::dropIfExists('insumo');
    }
}
