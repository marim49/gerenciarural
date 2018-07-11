<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoricoAnimalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historico_animal', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_animal')->unsigned(); 
            $table->integer('id_medicamento')->unsigned();               
            $table->integer('id_funcionario')->unsigned();
            $table->integer('quantidade');     
            $table->foreign('id_animal')->references('id')->on('animais');
            $table->foreign('id_medicamento')->references('id')->on('medicamento');
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
        Schema::dropIfExists('historico_animal');
    }
}
