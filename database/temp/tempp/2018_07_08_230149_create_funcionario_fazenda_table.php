<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFuncionarioFazendaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('funcionario_fazenda', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_fazenda')->unsigned(); 
            $table->integer('id_funcionario')->unsigned(); 
            $table->foreign('id_fazenda')->references('id')->on('fazenda');
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
        Schema::dropIfExists('funcionario_fazenda');
    }
}
