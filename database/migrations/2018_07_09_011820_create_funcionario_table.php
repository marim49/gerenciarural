<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFuncionarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('funcionario', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome', 100);
            $table->integer('id_estado_civil')->unsigned();
            $table->integer('id_fazenda')->unsigned();
            $table->string('endereco_rua', 45);
            $table->string('endereco_numero', 45);
            $table->string('endereco_bairro', 45);  
            $table->string('endereco_cidade', 45);             
            $table->string('endereco_estado', 45);             
            $table->string('endereco_pais', 45);
            $table->string('sexo', 45);
            $table->date('nascimento');
            $table->date('admissao');
            $table->string('cargo', 45);
            $table->string('rg', 45)->unique();
            $table->string('cpf', 45)->unique();
            $table->string('pis', 45)->unique();
            $table->string('tel_fixo', 45);
            $table->string('celular', 45);
            $table->string('cep', 45);          
            $table->foreign('id_estado_civil')->references('id')->on('estado_civil');
            $table->foreign('id_fazenda')->references('id')->on('fazenda');
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
        Schema::dropIfExists('funcionario');
    }
}
