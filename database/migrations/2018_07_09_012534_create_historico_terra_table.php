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
            $table->boolean('cancelado')->default(0);
            $table->string('motivo', 100)->nullable();          
            $table->integer('id_user_cancelou')->unsigned()->nullable();
            $table->foreign('id_terra')->references('id')->on('terra');
            $table->foreign('id_insumo')->references('id')->on('insumo');
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
        Schema::dropIfExists('historico_terra');
    }
}
