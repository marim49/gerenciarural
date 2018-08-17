<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoricoRevisaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historico_revisao', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_maquina')->unsigned();
            $table->integer('id_funcionario')->unsigned();   
            $table->date('data');        
            $table->string('problema');     
            $table->string('item', 45)->nullable();      
            $table->string('nota_fiscal', 45)->nullable();      
            $table->double('valor')->nulable();  
            $table->boolean('cancelado')->nullable()->default(0);
            $table->string('motivo', 100)->nullable()->default('');           
            $table->integer('id_user_cancelou')->nullable()->unsigned();  
            $table->foreign('id_maquina')->references('id')->on('maquina');
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
        Schema::dropIfExists('historico_revisao');
    }
}
