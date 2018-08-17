<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoricoCompraMedicamentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historico_compra_medicamento', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_medicamento')->unsigned(); 
            $table->integer('id_funcionario')->unsigned(); 
            $table->integer('id_fornecedor')->unsigned(); 
            $table->date('data');            
            $table->string('lote', 45)->nullable();  
            $table->string('quantidade', 45); 
            $table->string('nota_fiscal', 45); 
            $table->float('valor');    
            $table->boolean('cancelado')->default(0);
            $table->string('motivo', 100)->default(null);              
            $table->integer('id_user_cancelou')->unsigned();
            $table->foreign('id_medicamento')->references('id')->on('medicamento');
            $table->foreign('id_funcionario')->references('id')->on('funcionario');
            $table->foreign('id_fornecedor')->references('id')->on('fornecedor');
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
        Schema::dropIfExists('historico_compra_medicamento');
    }
}
