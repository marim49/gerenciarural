<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoricoAbastecimentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historico_abastecimento', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_maquina')->unsigned();
            $table->integer('id_combustivel')->unsigned();
            $table->integer('id_funcionario')->unsigned(); 
            $table->float('quantidade');            
            $table->foreign('id_maquina')->references('id')->on('maquina');
            $table->foreign('id_combustivel')->references('id')->on('combustivel');
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
        Schema::dropIfExists('historico_abastecimento');
    }
}
