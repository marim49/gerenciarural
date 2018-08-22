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
            $table->float('quantidade');    
            $table->string('motivo', 100)->nullable();  
            $table->date('data');   
            $table->boolean('cancelado')->default(0);
            $table->string('motivo_cancelamento', 100)->nullable();              
            $table->integer('id_user_cancelou')->unsigned()->nullable();
            $table->foreign('id_animal')->references('id')->on('animal');
            $table->foreign('id_medicamento')->references('id')->on('medicamento');
            $table->foreign('id_funcionario')->references('id')->on('funcionario');
            $table->foreign('id_user_cancelou')->references('id')->on('users');
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
