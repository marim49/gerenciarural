<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFazendaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fazenda', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_produtor')->unsigned();  
            $table->string('nome', 100);            
            $table->string('telefone', 16);  
            $table->string('end_cep', 9); 
            $table->integer('end_id_cidade')->unsigned();
            $table->string('end_bairro', 45); 
            $table->string('end_rua', 50); 
            $table->string('end_numero', 15); 
            $table->string('end_complemento', 20); 
            $table->string('endereco', 100);  
            $table->foreign('end_id_cidade')->references('id')->on('cidade');
            $table->foreign('id_produtor')->references('id')->on('users');
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
        Schema::dropIfExists('fazenda');
    }
}
