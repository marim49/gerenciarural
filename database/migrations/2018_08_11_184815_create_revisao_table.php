<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRevisaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('revisao', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_maquina')->unsigned();
            $table->integer('id_funcionario')->unsigned(); 
            $table->string('item', 45)->nullable();      
            $table->string('nota_fiscal', 45)->nullable();      
            $table->double('valor')->nulable();      
            $table->string('problema');      
            $table->date('data');        
            $table->foreign('id_maquina')->references('id')->on('maquina');
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
        Schema::dropIfExists('revisao');
    }
}
