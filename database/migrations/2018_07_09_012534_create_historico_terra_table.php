<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoricoTerraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historico_terra', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_terra')->unsigned(); 
            $table->integer('id_insumo')->unsigned();
            $table->integer('id_funcionario')->unsigned(); 
            $table->integer('quantidade');        
            $table->date('data');  
            $table->foreign('id_terra')->references('id')->on('terra');
            $table->foreign('id_insumo')->references('id')->on('insumo');
            $table->foreign('id_funcionario')->references('id')->on('funcionario');
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
        Schema::dropIfExists('historico_terra');
    }
}
