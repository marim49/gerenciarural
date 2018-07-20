<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoricoCompraInsumoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historico_compra_insumo', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_insumo')->unsigned(); 
            $table->integer('id_funcionario')->unsigned(); 
            $table->integer('id_fornecedor')->unsigned(); 
            $table->date('data');            
            $table->string('lote', 45);  
            $table->string('quantidade', 45); 
            $table->string('nota_fiscal', 45); 
            $table->float('valor');        
            $table->foreign('id_insumo')->references('id')->on('insumo');
            $table->foreign('id_funcionario')->references('id')->on('funcionario');
            $table->foreign('id_fornecedor')->references('id')->on('fornecedor');
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
        Schema::dropIfExists('historico_compra_insumo');
    }
}
